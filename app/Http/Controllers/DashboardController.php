<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class DashboardController extends Controller
{
    function studentDashboard(Request $request)
    {
        $admission = Student::whereMonth('date_of_admission', Carbon::now())->whereYear('date_of_admission', Carbon::now())->where('branch_id', Session::get('branch'))->get();
        $active = Student::where('branch_id', Session::get('branch'))->get();
        $cancelled = Student::onlyTrashed()->whereMonth('date_of_admission', Carbon::now())->whereYear('date_of_admission', Carbon::now())->where('branch_id', Session::get('branch'))->get();
        return view('dashboards.student', compact('admission', 'active', 'cancelled'));
    }
}
