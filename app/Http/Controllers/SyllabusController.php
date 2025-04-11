<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\SyllabiModule;
use App\Models\Syllabus;
use App\Models\SyllabusSubject;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class SyllabusController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('syllabus-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('syllabus-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('syllabus-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('syllabus-delete'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('syllabus-restore'), only: ['restore']),
        ];
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $syllabuses = Syllabus::withTrashed()->latest()->get();
        return view('syllabus.index', compact('syllabuses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::pluck('name', 'id');
        return view('syllabus.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            $input = $request->all();
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            Syllabus::create($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('syllabus.register')
            ->with('success', 'Syllabus created successfully');
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
        $syllabus = Syllabus::findOrFail(decrypt($id));
        $courses = Course::pluck('name', 'id');
        return view('syllabus.edit', compact('syllabus', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
        ]);
        try {
            $syllabus = Syllabus::findOrFail(decrypt($id));
            $input = $request->all();
            $input['updated_by'] = $request->user()->id;
            $syllabus->update($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('syllabus.register')
            ->with('success', 'Syllabus updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Syllabus::findOrFail(decrypt($id))->delete();
        return redirect()->route('syllabus.register')
            ->with('success', 'Syllabus deleted successfully');
    }

    public function restore(string $id)
    {
        Syllabus::withTrashed()->find(decrypt($id))->restore();
        return redirect()->route('syllabus.register')
            ->with('success', 'Syllabus restored successfully');
    }

    public function save()
    {
        //
    }

    public function syllabusModuleRemove(String $id)
    {
        SyllabiModule::findOrFail(decrypt($id))->delete();
        return redirect()->route('syllabus.register')
            ->with('success', 'Subject removed successfully');
    }

    public function syllabusModuleRestore(String $id)
    {
        SyllabiModule::withTrashed()->findOrFail(decrypt($id))->restore();
        return redirect()->route('syllabus.register')
            ->with('success', 'Subject restored successfully');
    }
}
