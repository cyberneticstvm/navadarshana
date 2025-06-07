<?php

use App\Models\Branch;
use App\Models\Fee;
use App\Models\IncomeExpense;
use App\Models\Month;
use App\Models\StudentBatch;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

function branches()
{
    return Branch::all();
}

function gcsPublicUrl()
{
    return Config::get('myconfig.gcs_url_public');
}

function months()
{
    return Month::all();
}

function years()
{
    return Year::all();
}

function gcsPrivateUrl()
{
    return Config::get('myconfig.gcs_url_private');
}

function uniqueRegistrationId()
{
    /*do {
        $code = random_int(1000000, 9999999);
    } while (Ad::where("registration_id", $code)->first());

    return $code;*/
}

function getOpeningBalance($from, $to, $branch)
{
    $ob = 0;
    $fee = Fee::selectRaw("CASE WHEN category='admission' THEN amount-discount END AS admission_fee, CASE WHEN category='monthly' THEN amount-discount END AS batch_fee, CASE WHEN category='other' THEN amount-IFNULL(discount, 0) END AS other, discount")->whereDate('payment_date', '<', Carbon::parse($from)->startOfDay())->where('branch_id', $branch)->get();

    $ie = IncomeExpense::selectRaw("CASE WHEN category='income' THEN amount END AS income, CASE WHEN category='expense' THEN amount END AS expense")->whereDate('date', '<', Carbon::parse($from)->startOfDay())->where('branch_id', $branch)->get();
    $income_tot = $fee->sum('admission_fee') + $fee->sum('batch_fee') + $ie->sum('income');
    $expense_tot = $ie->sum('expense');
    return $income_tot - $expense_tot;
}

function getFeePending($request)
{
    $days = Carbon::now()->month(intval($request->month))->daysInMonth;
    $dt = Carbon::createFromFormat('Y-m-d', $request->year . '-' . $request->month . '-' . $days)->format('Y-m-d');
    $fee = StudentBatch::leftJoin('batches as b', 'student_batches.batch_id', 'b.id')->leftJoin('students as s', 's.id', 'student_batches.student_id')->whereDate('student_batches.created_at', '<=', $dt)->selectRaw("student_batches.student_id, b.monthly_fee as fees, s.date_of_admission")->whereNull('student_batches.deleted_at')->when($request->batch, function ($q) use ($request) {
        return $q->where('student_batches.batch_id', $request->batch);
    })->whereNotIn('student_batches.student_id', function ($q) use ($request) {
        return $q->select('student_id')->where('month', $request->month)->where('year', $request->year)->where('batch_id', $request->batch)->where('category', 'monthly')->whereNull('deleted_at')->from('fees');
    })->get();
    return $fee;
}
