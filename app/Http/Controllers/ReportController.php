<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Branch;
use App\Models\Fee;
use App\Models\Head;
use App\Models\IncomeExpense;
use App\Models\Month;
use App\Models\Student;
use App\Models\StudentBatch;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller implements HasMiddleware
{
    protected $branches, $heads;

    public function __construct()
    {
        $br = Branch::when(!in_array(Auth::user()->roles->pluck('name')[0], array('Administrator')), function ($q) {
            return $q->where('id', Session::get('branch'));
        })->select("name", "id");
        if (Auth::user()->roles->pluck('name')[0] == 'Administrator'):
            $br = Branch::selectRaw("'ALL' AS name, 0 AS id")->union($br);
        endif;
        $this->branches = $br->pluck('name', 'id');
        $this->heads = Head::selectRaw("'ALL' AS name, 0 AS id")->union(Head::select("name", "id")->orderBy('name'))->pluck('name', 'id');
    }

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-daybook'), only: ['daybook', 'fetchDaybook']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-student'), only: ['student', 'fetchStudent']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-fee'), only: ['fee', 'fetchFee']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-ie'), only: ['ie', 'fetchIe']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-attendance'), only: ['attendance', 'fetchAttendance']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-fee-pending'), only: ['feePending', 'feePendingFetch']),
        ];
    }

    function daybook(Request $request)
    {
        $inputs = array(date('Y-m-d'), date('Y-m-d'), Session::get('branch'));
        $branches = $this->branches;
        $opening_balance = getOpeningBalance($inputs[0], $inputs[1], $inputs[2]);

        $fee = Fee::selectRaw("CASE WHEN category='admission' THEN amount-IFNULL(discount, 0) END AS admission_fee, CASE WHEN category='monthly' THEN amount-IFNULL(discount, 0) END AS batch_fee, CASE WHEN category='other' THEN amount-IFNULL(discount, 0) END AS material_fee, IFNULL(discount, 0) AS discount")->whereBetween('payment_date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->where('branch_id', $inputs[2])->get();

        $ie = IncomeExpense::selectRaw("CASE WHEN category='income' THEN amount END AS income, CASE WHEN category='expense' THEN amount END AS expense")->whereBetween('date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->where('branch_id', $inputs[2])->get();

        return view('report.daybook', compact('inputs', 'branches', 'fee', 'ie', 'opening_balance'));
    }

    function fetchDaybook(Request $request)
    {
        $request->validate([
            'from_date' => 'required|date',
            'to_date' => 'required|date',
            'branch' => 'required',
        ]);

        $inputs = array($request->from_date, $request->to_date, $request->branch);
        $branches = $this->branches;
        $opening_balance = getOpeningBalance($inputs[0], $inputs[1], $inputs[2]);
        $fee = getFee($request, $inputs);
        $ie = getIe($request, $inputs);

        return view('report.daybook', compact('inputs', 'branches', 'fee', 'ie', 'opening_balance'));
    }

    function student(Request $request)
    {
        $inputs = array(date('Y-m-d'), date('Y-m-d'), 'all', Session::get('branch'));
        $enrollments = array('online' => 'Online', 'offline' => 'Offline', 'all' => 'All');
        $branches = $this->branches;
        $students = Student::where('branch_id', $inputs[3])->whereBetween('date_of_admission', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->get();
        return view('report.student', compact('inputs', 'branches', 'enrollments', 'students'));
    }

    function fetchStudent(Request $request)
    {
        $inputs = array($request->from_date, $request->to_date, $request->enrollment, $request->branch);
        $enrollments = array('online' => 'Online', 'offline' => 'Offline', 'all' => 'All');
        $branches = $this->branches;
        $students = Student::whereBetween('date_of_admission', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->when($request->enrollment != 'all', function ($q) use ($request) {
            return $q->where('enrollment_type', $request->enrollment);
        })->when($request->branch > 0, function ($q) use ($request) {
            return $q->where('branch_id', $request->branch);
        })->get();
        return view('report.student', compact('inputs', 'branches', 'enrollments', 'students'));
    }

    function fee(Request $request)
    {
        $inputs = array(date('Y-m-d'), date('Y-m-d'), 'all', Session::get('branch'));
        $category = array('admission' => 'Admission', 'monthly' => 'Batch', 'other' => 'Other', 'all' => 'All');
        $branches = $this->branches;
        $fees = Fee::where('branch_id', $inputs[3])->whereBetween('payment_date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->selectRaw("id, payment_date, student_id, batch_id, CASE WHEN category='monthly' THEN 'Batch' WHEN category='admission' THEN 'Admission' ELSE remarks END AS category, payment_mode, amount, discount, amount - IFNULL(discount, 0) AS fee")->havingRaw('fee > ?', [0])->get();
        return view('report.fee', compact('inputs', 'branches', 'category', 'fees'));
    }

    function fetchFee(Request $request)
    {
        $inputs = array($request->from_date, $request->to_date, $request->category, $request->branch);
        $category = array('admission' => 'Admission', 'monthly' => 'Batch', 'other' => 'Other', 'all' => 'All');
        $branches = $this->branches;
        $fees = Fee::whereBetween('payment_date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->when($request->category != 'all', function ($q) use ($request) {
            return $q->where('category', $request->category);
        })->when($request->branch > 0, function ($q) use ($request) {
            return $q->where('branch_id', $request->branch);
        })->selectRaw("id, payment_date, student_id, batch_id, CASE WHEN category='monthly' THEN 'Batch' WHEN category='admission' THEN 'Admission' ELSE remarks END AS category, payment_mode, amount, discount, amount - IFNULL(discount, 0) AS fee")->havingRaw('fee > ?', [0])->get();
        return view('report.fee', compact('inputs', 'branches', 'category', 'fees'));
    }

    function ie(Request $request)
    {
        $inputs = array(date('Y-m-d'), date('Y-m-d'), 'all', Session::get('branch'), '');
        $category = array('income' => 'Income', 'expense' => 'Expense', 'all' => 'ALL');
        $branches = $this->branches;
        $heads = $this->heads;
        $ies = IncomeExpense::where('branch_id', $inputs[3])->whereBetween('date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->get();
        return view('report.ie', compact('inputs', 'branches', 'category', 'ies', 'heads'));
    }

    function fetchIe(Request $request)
    {
        $inputs = array($request->from_date, $request->to_date, $request->category, $request->branch, $request->head);
        $category = array('income' => 'Income', 'expense' => 'Expense', 'all' => 'ALL');
        $branches = $this->branches;
        $heads = $this->heads;
        $ies = IncomeExpense::whereBetween('date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->when($request->category != 'all', function ($q) use ($request) {
            return $q->where('category', $request->category);
        })->when($request->head > 0, function ($q) use ($request) {
            return $q->where('head_id', $request->head);
        })->when($request->branch > 0, function ($q) use ($request) {
            return $q->where('branch_id', $request->branch);
        })->get();
        return view('report.ie', compact('inputs', 'branches', 'category', 'ies', 'heads'));
    }

    function attendance(Request $request)
    {
        $inputs = array('', Carbon::now()->month, Carbon::now()->year);
        $batches = Batch::where('branch_id', Session::get('branch'))->pluck('name', 'id');
        $months = Month::pluck('name', 'id');
        $years = Year::pluck('name', 'name');
        $days = 0;
        $students = collect();
        return view('report.attendance', compact('inputs', 'batches', 'months', 'years', 'days', 'students'));
    }

    function fetchAttendance(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required',
            'batch' => 'required',
        ]);
        $inputs = array($request->batch, $request->month, $request->year);
        $batches = Batch::where('branch_id', Session::get('branch'))->pluck('name', 'id');
        $months = Month::pluck('name', 'id');
        $years = Year::pluck('name', 'name');
        $days = cal_days_in_month(CAL_GREGORIAN, $request->month, $request->year);
        $students = StudentBatch::leftJoin('students', 'students.id', 'student_batches.student_id')->selectRaw("student_batches.student_id, student_batches.batch_id")->where('student_batches.batch_id', $request->batch)->where('students.current_status', 'active')->get();
        return view('report.attendance', compact('inputs', 'batches', 'months', 'years', 'days', 'students'));
    }

    function feePending(Request $request)
    {
        $inputs = array('', Carbon::now()->month, Carbon::now()->year);
        $batches = Batch::where('branch_id', Session::get('branch'))->pluck('name', 'id');
        $months = Month::orderBy('id')->pluck('name', 'id');
        $years = Year::pluck('name', 'name');
        $fee = collect();
        $dt = null;
        return view('report.fee-pending', compact('inputs', 'batches', 'months', 'years', 'fee', 'dt'));
    }

    function feePendingFetch(Request $request)
    {
        $request->validate([
            'month' => 'required',
            'year' => 'required',
            'batch' => 'required',
        ]);
        $inputs = array($request->batch, $request->month, $request->year);
        $batches = Batch::where('branch_id', Session::get('branch'))->pluck('name', 'id');
        $months = Month::orderBy('id')->pluck('name', 'id');
        $years = Year::pluck('name', 'name');
        $fee = getFeePending($request);
        return view('report.fee-pending', compact('inputs', 'batches', 'months', 'years', 'fee'));
    }
}
