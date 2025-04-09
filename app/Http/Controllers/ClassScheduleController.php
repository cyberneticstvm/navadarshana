<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\ClassSchedule;
use App\Models\CourseSyllabus;
use App\Models\CourseTopic;
use App\Models\Faculty;
use App\Models\Syllabus;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

class ClassScheduleController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('class-schedule-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('class-schedule-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('class-schedule-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('class-schedule-delete'), only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $schedules = ClassSchedule::withTrashed()->where('branch_id', Session::get('branch'))->whereDate('date', '>=', Carbon::now())->latest()->get();
        return view('schedule.class.index', compact('schedules'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $batches = Batch::where('branch_id', Session::get('branch'))->orderBy('name')->pluck('name', 'id');
        $faculties = Faculty::orderBy('name')->pluck('name', 'id');
        return view('schedule.class.create', compact('batches', 'faculties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date' => 'required|date',
            'batch_id' => 'required',
            'syllabus_id' => 'required',
            'faculty_id' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
        ]);
        try {
            $input = $request->all();
            $input['branch_id'] = Session::get('branch');
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            ClassSchedule::create($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('class.schedule.register')
            ->with('success', 'Class Scheduled successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = ClassSchedule::findOrFail(decrypt($id));
        $batches = Batch::where('branch_id', Session::get('branch'))->orderBy('name')->pluck('name', 'id');
        $batch = Batch::find($schedule->batch_id);
        $faculties = Faculty::orderBy('name')->pluck('name', 'id');
        $syllabi = CourseTopic::where('course_id', $batch->course_id)->leftJoin('topics as t', 'course_topics.topic_id', 't.id')->leftJoin('modules as m', 'm.id', 't.module_id')->leftjoin('syllabi as s', 's.id', 'm.syllabus_id')->select('s.name', 's.id')->distinct()->pluck('s.name', 's.id');
        return view('schedule.class.edit', compact('batches', 'faculties', 'syllabi', 'schedule'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date' => 'required|date',
            'batch_id' => 'required',
            'syllabus_id' => 'required',
            'faculty_id' => 'required',
            'from_time' => 'required',
            'to_time' => 'required',
        ]);
        try {
            $input = $request->all();
            $input['updated_by'] = $request->user()->id;
            ClassSchedule::findOrFail($id)->update($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('class.schedule.register')
            ->with('success', 'Class Schedule updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        ClassSchedule::findOrFail(decrypt($id))->delete();
        return redirect()->route('class.schedule.register')
            ->with('success', 'Class Schedule deleted successfully');
    }
}
