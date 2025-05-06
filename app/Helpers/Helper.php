<?php

use App\Models\Branch;
use App\Models\Fee;
use App\Models\IncomeExpense;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;

function branches()
{
    return Branch::get();
}

function gcsPublicUrl()
{
    return Config::get('myconfig.gcs_url_public');
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
