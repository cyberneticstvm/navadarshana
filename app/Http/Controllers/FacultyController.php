<?php

namespace App\Http\Controllers;

use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

class FacultyController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('faculty-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('faculty-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('faculty-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('faculty-delete'), only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculties = Faculty::withTrashed()->latest()->get();
        return view('faculty.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('faculty.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric|digits:10|unique:faculties,mobile',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        Faculty::create($input);
        return redirect()->route('faculty.register')
            ->with('success', 'Faculty created successfully');
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
        $faculty = Faculty::findOrFail(decrypt($id));
        return view('faculty.edit', compact('faculty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'mobile' => 'required|numeric|digits:10|unique:faculties,mobile,' . $id,
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        Faculty::findOrFail($id)->update($input);
        return redirect()->route('faculty.register')
            ->with('success', 'Faculty updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Faculty::findOrFail(decrypt($id))->delete();
        return redirect()->route('faculty.register')
            ->with('success', 'Faculty deleted successfully');
    }
}
