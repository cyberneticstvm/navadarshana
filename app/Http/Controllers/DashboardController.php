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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

use function Pest\Laravel\json;

class DashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using(['dashboard-finance', 'dashboard-finance-all']), only: ['financeDashboard', 'ieTotal', 'studentFeeCollectionChart']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using(['dashboard-student', 'dashboard-student-all']), only: ['studentDashboard']),
        ];
    }

    function financeDashboard(Request $request)
    {
        $fee = Fee::selectRaw("CASE WHEN category='admission' THEN amount-IFNULL(discount, 0) END AS admission, CASE WHEN category='monthly' THEN amount-IFNULL(discount, 0) END AS batch, CASE WHEN category='other' THEN amount-IFNULL(discount, 0) END AS other")->when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->when(Auth::user()->roles->first()->name == 'Administrator', function ($q) {
            return $q->whereMonth('payment_date', Carbon::now()->month)->whereYear('payment_date', Carbon::now()->year);
        })->when(Auth::user()->roles->first()->name != 'Administrator', function ($q) {
            return $q->whereDay('payment_date', Carbon::now()->day)->whereMonth('payment_date', Carbon::now()->month)->whereYear('payment_date', Carbon::now()->year);
        })->get();
        //whereMonth('payment_date', Carbon::now()->month)->whereYear('payment_date', Carbon::now()->year)->get();
        $ie = IncomeExpense::selectRaw("CASE WHEN category='income' THEN amount END AS income, CASE WHEN category='expense' THEN amount END AS expense")->when($request->type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->when(Auth::user()->roles->first()->name == 'Administrator', function ($q) {
            return $q->whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year);
        })->when(Auth::user()->roles->first()->name != 'Administrator', function ($q) {
            return $q->whereDay('date', Carbon::now()->day)->whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year);
        })->get();
        //whereMonth('date', Carbon::now()->month)->whereYear('date', Carbon::now()->year)->get();
        $type = $request->type;
        $months = Month::orderBy('id')->get();
        $years = collect([Carbon::now()->year])
            ->merge(
                Fee::when($request->type == 0, function ($q) {
                    return $q->where('branch_id', Session::get('branch'));
                })->selectRaw('YEAR(payment_date) AS finance_year')->distinct()->pluck('finance_year')
            )
            ->merge(
                IncomeExpense::when($request->type == 0, function ($q) {
                    return $q->where('branch_id', Session::get('branch'));
                })->selectRaw('YEAR(date) AS finance_year')->distinct()->pluck('finance_year')
            )
            ->filter()
            ->unique()
            ->sortDesc()
            ->values();

        return view('dashboards.finance', compact('fee', 'ie', 'type', 'months', 'years'));
    }

    function ieTotal(Request $request, $type)
    {
        abort_unless(in_array((int) $type, [0, 1], true), 404);

        if ((int) $type === 1) {
            abort_unless($request->user()->can('dashboard-finance-all'), 403);
        } else {
            abort_unless($request->user()->can('dashboard-finance') || $request->user()->can('dashboard-finance-all'), 403);
        }

        $validated = $request->validate([
            'month' => ['required', 'integer', 'between:1,12'],
            'year' => ['required', 'integer', 'between:2000,2100'],
        ]);

        $fee = Fee::selectRaw("CASE WHEN category='admission' THEN amount-IFNULL(discount, 0) END AS admission, CASE WHEN category='monthly' THEN amount-IFNULL(discount, 0) END AS batch, CASE WHEN category='other' THEN amount-IFNULL(discount, 0) END AS other")->when($type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->whereMonth('payment_date', $validated['month'])
            ->whereYear('payment_date', $validated['year'])
            ->get();
        $ie = IncomeExpense::selectRaw("CASE WHEN category='income' THEN amount END AS income, CASE WHEN category='expense' THEN amount END AS expense")->when($type == 0, function ($q) {
            return $q->where('branch_id', Session::get('branch'));
        })->whereMonth('date', $validated['month'])
            ->whereYear('date', $validated['year'])
            ->get();

        return response()->json([
            'income' => $fee->sum('admission') + $fee->sum('batch') + $fee->sum('other') + $ie->sum('income'),
            'expense' => $ie->sum('expense'),
        ]);
    }

    function studentFeeCollectionChart(Request $request, $type)
    {
        abort_unless(in_array((int) $type, [0, 1], true), 404);

        if ((int) $type === 1) {
            abort_unless($request->user()->can('dashboard-finance-all'), 403);
        } else {
            abort_unless($request->user()->can('dashboard-finance') || $request->user()->can('dashboard-finance-all'), 403);
        }

        $validated = $request->validate([
            'period' => ['required', 'in:week,month,year,all'],
        ]);

        $period = $validated['period'];
        $now = Carbon::now();
        $feeQuery = Fee::query()->when((int) $type === 0, function ($query) {
            return $query->where('branch_id', Session::get('branch'));
        });
        $sumColumns = "COALESCE(SUM(CASE WHEN category='admission' THEN amount-IFNULL(discount, 0) ELSE 0 END), 0) AS admission, COALESCE(SUM(CASE WHEN category='monthly' THEN amount-IFNULL(discount, 0) ELSE 0 END), 0) AS batch";

        if ($period === 'week') {
            $start = $now->copy()->subDays(6)->startOfDay();
            $end = $now->copy()->endOfDay();
            $rows = $feeQuery->whereBetween('payment_date', [$start->toDateString(), $end->toDateString()])
                ->selectRaw("DATE(payment_date) AS period_key, {$sumColumns}")
                ->groupBy('period_key')
                ->get()
                ->keyBy('period_key');
            $points = collect();

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $key = $date->format('Y-m-d');
                $row = $rows->get($key);
                $points->push([
                    'label' => $date->format('D d'),
                    'admission' => (float) ($row->admission ?? 0),
                    'batch' => (float) ($row->batch ?? 0),
                ]);
            }
        } elseif ($period === 'month') {
            $start = $now->copy()->startOfMonth();
            $end = $now->copy()->endOfDay();
            $rows = $feeQuery->whereBetween('payment_date', [$start->toDateString(), $end->toDateString()])
                ->selectRaw("DATE(payment_date) AS period_key, {$sumColumns}")
                ->groupBy('period_key')
                ->get()
                ->keyBy('period_key');
            $points = collect();

            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                $key = $date->format('Y-m-d');
                $row = $rows->get($key);
                $points->push([
                    'label' => $date->format('d M'),
                    'admission' => (float) ($row->admission ?? 0),
                    'batch' => (float) ($row->batch ?? 0),
                ]);
            }
        } elseif ($period === 'year') {
            $rows = $feeQuery->whereYear('payment_date', $now->year)
                ->selectRaw("MONTH(payment_date) AS period_key, {$sumColumns}")
                ->groupBy('period_key')
                ->get()
                ->keyBy('period_key');
            $points = collect();

            for ($month = 1; $month <= 12; $month++) {
                $row = $rows->get($month);
                $points->push([
                    'label' => Carbon::create($now->year, $month, 1)->format('M'),
                    'admission' => (float) ($row->admission ?? 0),
                    'batch' => (float) ($row->batch ?? 0),
                ]);
            }
        } else {
            $rows = $feeQuery->selectRaw("YEAR(payment_date) AS period_key, {$sumColumns}")
                ->groupBy('period_key')
                ->orderBy('period_key')
                ->get();

            $points = $rows->map(function ($row) {
                return [
                    'label' => (string) $row->period_key,
                    'admission' => (float) $row->admission,
                    'batch' => (float) $row->batch,
                ];
            });

            if ($points->isEmpty()) {
                $points->push([
                    'label' => (string) $now->year,
                    'admission' => 0,
                    'batch' => 0,
                ]);
            }
        }

        return response()->json([
            'period' => $period,
            'labels' => $points->pluck('label')->values(),
            'admission' => $points->pluck('admission')->values(),
            'batch' => $points->pluck('batch')->values(),
        ]);
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
        $type = $request->type;
        return view('dashboards.student', compact('admission', 'active', 'cancelled', 'batches', 'student_pending_batch', 'fee_pending', 'fee_paid', 'class_schedules', 'type'));
    }

    function studentComparisonChart($type)
    {
        $students = Month::leftJoin('students as s', function ($q) use ($type) {
            $q->on('s.date_of_admission', '>=', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH'));
            $q->on('s.date_of_admission', '<', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH + INTERVAL 1 MONTH'))->when($type == 0, function ($q) {
                return $q->where('s.branch_id', Session::get('branch'));
            });
        })->select(DB::raw("LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH AS date, COUNT(CASE WHEN s.enrollment_type='online' THEN s.id END) AS online, COUNT(CASE WHEN s.enrollment_type='offline' THEN s.id END) AS offline, CONCAT_WS('.', DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%b'), DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%y')) AS month"))->groupBy('date', 'months.id')->orderByDesc('date')->get();
        return json_encode($students);
    }

    function studentFeePerChart($type)
    {
        $tot = StudentBatch::leftJoin('students as s', 's.id', 'student_batches.student_id')->leftJoin('batches as b', 'b.id', 'student_batches.batch_id')->leftJoin('fees as f', 'f.student_id', 's.id')->selectRaw("SUM(b.monthly_fee) AS fee")->when($type == 0, function ($q) {
            return $q->where('s.branch_id', Session::get('branch'));
        })->get();

        $fee = StudentBatch::leftJoin('students as s', 's.id', 'student_batches.student_id')->leftJoin('batches as b', 'b.id', 'student_batches.batch_id')->leftJoin('fees as f', 'f.student_id', 's.id')->selectRaw("SUM(f.amount) AS fee")->when($type == 0, function ($q) {
            return $q->where('s.branch_id', Session::get('branch'));
        })->where('f.month', Carbon::now()->month)->where('f.year', Carbon::now()->year)->get();

        return json_encode([
            'tot' => $tot->sum('fee'),
            'fee' => $fee->sum('fee'),
            'per' => ($tot->sum('fee') > 0 && $fee->sum('fee') > 0) ? ($fee->sum('fee') / $tot->sum('fee')) * 100 : 0,
        ]);
    }

    function studentCancelChart($type)
    {
        $students = DB::table('months')->leftJoin('students as s', function ($q) use ($type) {
            $q->on('s.deleted_at', '>=', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH'));
            $q->on('s.deleted_at', '<', DB::raw('LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH + INTERVAL 1 MONTH'))->when($type == 0, function ($q) {
                return $q->where('s.branch_id', Session::get('branch'));
            });
        })->select(DB::raw("LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH AS date, COUNT(CASE WHEN s.deleted_at IS NOT NULL THEN s.id END) AS cancelled, CONCAT_WS('.', DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%b'), DATE_FORMAT(LAST_DAY(CURRENT_DATE) + INTERVAL 1 DAY - INTERVAL months.id MONTH, '%y')) AS month"))->groupBy('date', 'months.id')->orderByDesc('date')->get();
        return json_encode($students);
    }
}
