<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Batch;
use App\Models\StudentBatch;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

class AttendanceController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-attendance'), only: ['index']),
        ];
    }

    public function index()
    {
        $batches = Batch::where('branch_id', Session::get('branch'))->pluck('name', 'id');
        $students = [];
        return view('attendance.index', compact('batches', 'students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request)
    {
        $request->validate([
            'batch' => 'required',
        ]);
        $batch = Batch::findOrFail($request->batch);
        $batches = Batch::where('branch_id', Session::get('branch'))->pluck('name', 'id');
        $students = Attendance::where('batch_id', $batch->id)->whereDate('attendance_date', Carbon::today())->get();
        if ($students->isEmpty()):
            $students = StudentBatch::leftJoin('students as s', 's.id', 'student_batches.student_id')->where('student_batches.batch_id', $batch->id)->where('s.current_status', 'active')->selectRaw("student_batches.student_id, 0 AS `present`, 0 AS `absent`, 0 AS `leave`")->get();
        endif;
        return view('attendance.index', compact('students', 'batches', 'batch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'batch_id' => 'required',
        ]);
        //try {
        $batch = Batch::findOrFail(decrypt($request->batch_id));
        $data = [];
        foreach ($request->student_ids as $key => $student):
            $data[] = [
                'student_id' => $student,
                'batch_id' => $batch->id,
                'attendance_date' => Carbon::today()->format('Y-m-d'),
                'present' => $request->present[$key] ?? 0,
                'absent' => $request->absent[$key] ?? 0,
                'leave' => $request->leave[$key] ?? 0,
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ];
        endforeach;
        Attendance::where('batch_id', $batch->id)->whereDate('attendance_date', Carbon::today())->forceDelete();
        Attendance::insert($data);
        //} catch (Exception $e) {
        //return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        //}
        return redirect()->back()->with("success", "Attendance updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
