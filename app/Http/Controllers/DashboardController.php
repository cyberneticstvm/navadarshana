<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ClassSchedule;
use App\Models\Fee;
use App\Models\Month;
use App\Models\Student;
use App\Models\StudentBatch;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    function studentDashboard(Request $request)
    {
        $admission = Student::withTrashed()->whereMonth('date_of_admission', Carbon::now())->whereYear('date_of_admission', Carbon::now())->where('branch_id', Session::get('branch'))->get();
        $active = Student::where('branch_id', Session::get('branch'))->get();
        $cancelled = Student::onlyTrashed()->whereMonth('deleted_at', Carbon::now())->whereYear('deleted_at', Carbon::now())->where('branch_id', Session::get('branch'))->get();
        $batches = Batch::where('branch_id', Session::get('branch'))->get();
        $student_pending_batch = Student::where('branch_id', Session::get('branch'))->whereNotIn('id', StudentBatch::pluck('student_id'))->get();
        $fee_pending = Student::where('branch_id', Session::get('branch'))->whereNotIn('id', Fee::where('branch_id', Session::get('branch'))->where('month', Carbon::now()->month)->where('year', Carbon::now()->year)->pluck('student_id'))->get();
        $fee_paid = Student::where('branch_id', Session::get('branch'))->whereIn('id', Fee::where('branch_id', Session::get('branch'))->where('month', Carbon::now()->month)->where('year', Carbon::now()->year)->pluck('student_id'))->get();
        $class_schedules = ClassSchedule::where('branch_id', Session::get('branch'))->whereDate('date', Carbon::now())->orderBy('from_time')->get();
        return view('dashboards.student', compact('admission', 'active', 'cancelled', 'batches', 'student_pending_batch', 'fee_pending', 'fee_paid', 'class_schedules'));
    }

    function studentComparisonChart(Request $request)
    {
        $students = Month::leftJoin('students as s', function ($q) {
            $q->on('s.date_of_admission', '>=', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH'));
            $q->on('s.date_of_admission', '<', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH + INTERVAL 1 MONTH'))->where('s.branch_id', Session::get('branch'));
        })->select(DB::raw("LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH AS date, COUNT(CASE WHEN s.enrollment_type='online' THEN s.id END) AS online, COUNT(CASE WHEN s.enrollment_type='offline' THEN s.id END) AS offline, CONCAT_WS('.', DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%b'), DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%y')) AS month"))->groupBy('date', 'months.id')->orderByDesc('date')->get();
        return json_encode($students);
    }

    function studentFeePerChart()
    {
        $tot = StudentBatch::leftJoin('students as s', 's.id', 'student_batches.student_id')->leftJoin('batches as b', 'b.id', 'student_batches.batch_id')->leftJoin('fees as f', 'f.student_id', 's.id')->selectRaw("SUM(b.monthly_fee) AS fee")->where('s.branch_id', Session::get('branch'))->get();

        $fee = StudentBatch::leftJoin('students as s', 's.id', 'student_batches.student_id')->leftJoin('batches as b', 'b.id', 'student_batches.batch_id')->leftJoin('fees as f', 'f.student_id', 's.id')->selectRaw("SUM(f.amount) AS fee")->where('s.branch_id', Session::get('branch'))->where('f.month', Carbon::now()->month)->where('f.year', Carbon::now()->year)->get();

        return json_encode([
            'tot' => $tot->sum('fee'),
            'fee' => $fee->sum('fee'),
            'per' => ($tot->sum('fee') > 0 && $fee->sum('fee') > 0) ? ($fee->sum('fee') / $tot->sum('fee')) * 100 : 0,
        ]);
    }
}
