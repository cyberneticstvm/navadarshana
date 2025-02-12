<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use App\Models\CourseSyllabus;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

class CourseController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('course-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('course-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('course-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('course-delete'), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::where('branch_id', Session::get('branch'))->withTrashed()->latest()->get();
        return view('course.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('course.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:courses,name',
        ]);
        try {
            $input = $request->all();
            $input['branch_id'] = Session::get('branch');
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            Course::create($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('course.register')
            ->with('success', 'Course created successfully');
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
        $course = Course::findOrFail(decrypt($id));
        return view('course.edit', compact('course'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:courses,name,' . decrypt($id),
        ]);
        try {
            $course = Course::findOrFail(decrypt($id));
            $input = $request->all();
            $input['updated_by'] = $request->user()->id;
            $course->update($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('course.register')
            ->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Course::findOrFail(decrypt($id))->delete();
        Batch::where('course_id', decrypt($id))->delete();
        CourseSyllabus::where('course_id', decrypt($id))->delete();
        return redirect()->route('course.register')
            ->with('success', 'Course deleted successfully');
    }

    public function courseSyllabusSave(Request $request)
    {
        $request->validate([
            'syllabus_id' => 'required',
        ]);
        try {
            CourseSyllabus::insert([
                'course_id' => decrypt($request->course_id),
                'syllabus_id' => $request->syllabus_id,
                'created_by' => $request->user()->id,
                'updated_by' => $request->user()->id,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage());
        }

        return redirect()->route('course.register')
            ->with('success', 'Syllabus added successfully');
    }

    public function courseSyllabusRemove(String $id)
    {
        CourseSyllabus::findOrFail(decrypt($id))->delete();
        return redirect()->route('course.register')
            ->with('success', 'Syllabus removed successfully');
    }

    public function courseSyllabusRestore(String $id)
    {
        CourseSyllabus::withTrashed()->findOrFail(decrypt($id))->restore();
        return redirect()->route('course.register')
            ->with('success', 'Syllabus restored successfully');
    }
}
