<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ClassSchedule;
use App\Models\Fee;
use App\Models\IncomeExpense;
use App\Models\Month;
use App\Models\Student;
use App\Models\StudentBatch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use function Pest\Laravel\json;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using(['dashboard-finance', 'dashboard-finance-all']), only: ['financeDashboard']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using(['dashboard-student', 'dashboard-student-all']), only: ['studentDashboard']),
        ];
    }

    function financeDashboard(Request $request)
    {
        $fee = Fee::selectRaw("CASE WHEN category='admission' THEN amount-IFNULL(discount, 0) END AS admission, CASE WHEN category='monthly' THEN amount-IFNULL(discount, 0) END AS batch")->when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->whereMonth('payment_date', Carbon::now()->month)->whereYear('payment_date', Carbon::now()->year)->get();
        $ie = IncomeExpense::selectRaw("CASE WHEN category='income' THEN amount END AS income, CASE WHEN category='expense' THEN amount END AS expense")->when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year)->get();
        return view('dashboards.finance', compact('fee', 'ie'));
    }

    function ieTotal()
    {
        $fee = Fee::selectRaw("CASE WHEN category='admission' THEN amount-IFNULL(discount, 0) END AS admission, CASE WHEN category='monthly' THEN amount-IFNULL(discount, 0) END AS batch")->where('branch_id', Session::get('branch'))->whereMonth('payment_date', Carbon::now()->month)->whereYear('payment_date', Carbon::now()->year)->get();
        $ie = IncomeExpense::selectRaw("CASE WHEN category='income' THEN amount END AS income, CASE WHEN category='expense' THEN amount END AS expense")->where('branch_id', Session::get('branch'))->whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year)->get();
        return json_encode([
            'income' => $fee->sum('admission') + $fee->sum('batch') + $ie->sum('income'),
            'expense' => $ie->sum('expense'),
        ]);
    }

    function studentFeeCollectionChart(Request $request)
    {
        $students = Month::leftJoin('fees as f', function ($q) {
            $q->on('f.payment_date', '>=', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH'));
            $q->on('f.payment_date', '<', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH + INTERVAL 1 MONTH'))->where('f.branch_id', Session::get('branch'));
        })->select(DB::raw("LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH AS date, SUM(CASE WHEN f.category='admission' THEN f.amount-IFNULL(f.discount, 0) END) AS admission, SUM(CASE WHEN f.category='monthly' THEN f.amount-IFNULL(f.discount, 0) END) AS batch, CONCAT_WS('.', DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%b'), DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%y')) AS month"))->groupBy('date', 'months.id')->orderByDesc('date')->get();
        return json_encode($students);
    }

    function studentDashboard(Request $request)
    {
        $admission = Student::withTrashed()->whereMonth('date_of_admission', Carbon::now())->whereYear('date_of_admission', Carbon::now())->when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->get();
        $active = Student::when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->get();
        $cancelled = Student::onlyTrashed()->whereMonth('deleted_at', Carbon::now())->whereYear('deleted_at', Carbon::now())->when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->get();
        $batches = Batch::when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->get();
        $student_pending_batch = Student::when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->whereNotIn('id', StudentBatch::pluck('student_id'))->get();
        $fee_pending = Student::when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->whereNotIn('id', Fee::when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->where('month', Carbon::now()->month)->where('year', Carbon::now()->year)->pluck('student_id'))->get();
        $fee_paid = Student::when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->whereIn('id', Fee::when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->where('month', Carbon::now()->month)->where('year', Carbon::now()->year)->pluck('student_id'))->get();
        $class_schedules = ClassSchedule::when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->whereDate('date', Carbon::now())->orderBy('from_time')->get();
        return view('dashboards.student', compact('admission', 'active', 'cancelled', 'batches', 'student_pending_batch', 'fee_pending', 'fee_paid', 'class_schedules'));
    }

    function studentComparisonChart(Request $request)
    {
        $students = Month::leftJoin('students as s', function ($q) use ($request) {
            $q->on('s.date_of_admission', '>=', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH'));
            $q->on('s.date_of_admission', '<', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH + INTERVAL 1 MONTH'))->when($request->type == 0, function ($q) {
                return $q->where('s.branch_id', Session::get('branch'));
            });
        })->select(DB::raw("LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH AS date, COUNT(CASE WHEN s.enrollment_type='online' THEN s.id END) AS online, COUNT(CASE WHEN s.enrollment_type='offline' THEN s.id END) AS offline, CONCAT_WS('.', DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%b'), DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%y')) AS month"))->groupBy('date', 'months.id')->orderByDesc('date')->get();
        return json_encode($students);
    }

    function studentFeePerChart(Request $request)
    {
        $tot = StudentBatch::leftJoin('students as s', 's.id', 'student_batches.student_id')->leftJoin('batches as b', 'b.id', 'student_batches.batch_id')->leftJoin('fees as f', 'f.student_id', 's.id')->selectRaw("SUM(b.monthly_fee) AS fee")->when($request->type == 0, function ($q) {
            return $q->where('s.branch_id', Session::get('branch'));
        })->get();

        $fee = StudentBatch::leftJoin('students as s', 's.id', 'student_batches.student_id')->leftJoin('batches as b', 'b.id', 'student_batches.batch_id')->leftJoin('fees as f', 'f.student_id', 's.id')->selectRaw("SUM(f.amount) AS fee")->when($request->type == 0, function ($q) {
            return $q->where('s.branch_id', Session::get('branch'));
        })->where('f.month', Carbon::now()->month)->where('f.year', Carbon::now()->year)->get();

        return json_encode([
            'tot' => $tot->sum('fee'),
            'fee' => $fee->sum('fee'),
            'per' => ($tot->sum('fee') > 0 && $fee->sum('fee') > 0) ? ($fee->sum('fee') / $tot->sum('fee')) * 100 : 0,
        ]);
    }

    function studentCancelChart(Request $request)
    {
        $students = DB::table('months')->leftJoin('students as s', function ($q) use ($request) {
            $q->on('s.deleted_at', '>=', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH'));
            $q->on('s.deleted_at', '<', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH + INTERVAL 1 MONTH'))->when($request->type == 0, function ($q) {
                return $q->where('s.branch_id', Session::get('branch'));
            });
        })->select(DB::raw("LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH AS date, COUNT(CASE WHEN s.deleted_at IS NOT NULL THEN s.id END) AS cancelled, CONCAT_WS('.', DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%b'), DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%y')) AS month"))->groupBy('date', 'months.id')->orderByDesc('date')->get();
        return json_encode($students);
    }
}
