<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Fee;
use App\Models\IncomeExpense;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class ReportController extends Controller implements HasMiddleware
{
    protected $branches;

    public function __construct()
    {
        $this->branches = Branch::when(!in_array(Auth::user()->roles->pluck('name')[0], array('Administrator')), function ($q) {
            return $q->where('id', Session::get('branch'));
        })->pluck('name', 'id');
    }

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-daybook'), only: ['daybook', 'fetchDaybook']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-student'), only: ['student', 'fetchStudent']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-fee'), only: ['fee', 'fetchFee']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('report-ie'), only: ['ie', 'fetchIe'])
        ];
    }

    function daybook(Request $request)
    {
        $inputs = array(date('Y-m-d'), date('Y-m-d'), Session::get('branch'));
        $branches = $this->branches;
        $opening_balance = getOpeningBalance($inputs[0], $inputs[1], $inputs[2]);

        $fee = Fee::selectRaw("CASE WHEN category='admission' THEN amount-discount END AS admission_fee, CASE WHEN category='monthly' THEN amount-discount END AS batch_fee, discount")->whereBetween('payment_date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->where('branch_id', $inputs[2])->get();

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

        $fee = Fee::selectRaw("CASE WHEN category='admission' THEN amount-discount END AS admission_fee, CASE WHEN category='monthly' THEN amount-discount END AS batch_fee, discount")->whereBetween('payment_date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->where('branch_id', $inputs[2])->get();

        $ie = IncomeExpense::selectRaw("CASE WHEN category='income' THEN amount END AS income, CASE WHEN category='expense' THEN amount END AS expense")->whereBetween('date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->where('branch_id', $inputs[2])->get();

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
        $students = Student::where('branch_id', $inputs[3])->whereBetween('date_of_admission', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->when($request->enrollment != 'all', function ($q) use ($request) {
            return $q->where('enrollment_type', $request->enrollment);
        })->get();
        return view('report.student', compact('inputs', 'branches', 'enrollments', 'students'));
    }

    function fee(Request $request)
    {
        $inputs = array(date('Y-m-d'), date('Y-m-d'), 'all', Session::get('branch'));
        $category = array('admission' => 'Admission', 'monthly' => 'Batch', 'all' => 'All');
        $branches = $this->branches;
        $fees = Fee::where('branch_id', $inputs[3])->whereBetween('payment_date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->where('amount', '>', 0)->get();
        return view('report.fee', compact('inputs', 'branches', 'category', 'fees'));
    }

    function fetchFee(Request $request)
    {
        //havingRaw('amount > ?', [0])
        $inputs = array($request->from_date, $request->to_date, $request->category, $request->branch);
        $category = array('admission' => 'Admission', 'monthly' => 'Batch', 'all' => 'All');
        $branches = $this->branches;
        $fees = Fee::where('branch_id', $inputs[3])->whereBetween('payment_date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->when($request->category != 'all', function ($q) use ($request) {
            return $q->where('category', $request->category);
        })->where(DB::raw("amount-discount"), '>', 0)->get();
        return view('report.fee', compact('inputs', 'branches', 'category', 'fees'));
    }

    function ie(Request $request)
    {
        $inputs = array(date('Y-m-d'), date('Y-m-d'), 'all', Session::get('branch'));
        $category = array('income' => 'Income', 'expense' => 'Expense', 'all' => 'All');
        $branches = $this->branches;
        $ies = IncomeExpense::where('branch_id', $inputs[3])->whereBetween('date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->get();
        return view('report.ie', compact('inputs', 'branches', 'category', 'ies'));
    }

    function fetchIe(Request $request)
    {
        $inputs = array($request->from_date, $request->to_date, $request->category, $request->branch);
        $category = array('income' => 'Income', 'expense' => 'Expense', 'all' => 'All');
        $branches = $this->branches;
        $ies = IncomeExpense::where('branch_id', $inputs[3])->whereBetween('date', [Carbon::parse($inputs[0])->startOfDay(), Carbon::parse($inputs[1])->endOfDay()])->when($request->category != 'all', function ($q) use ($request) {
            return $q->where('category', $request->category);
        })->get();
        return view('report.ie', compact('inputs', 'branches', 'category', 'ies'));
    }
}
