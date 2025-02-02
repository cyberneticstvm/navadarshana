<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Course;
use App\Models\StudentBatch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

class BatchController extends Controller implements HasMiddleware
{

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('batch-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('batch-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('batch-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('batch-delete'), only: ['destroy']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-batch-create'), only: ['save']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-batch-delete'), only: ['delete']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $batches = Batch::where('branch_id', Session::get('branch'))->withTrashed()->latest()->get();
        return view('batch.index', compact('batches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::pluck('name', 'id');
        return view('batch.create', compact('courses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'name' => 'required',
            'category' => 'required',
            'admission_fee' => 'required',
            'monthly_fee' => 'required',
            'course_id' => 'required',
        ]);
        try {
            $input = $request->all();
            $input['branch_id'] = Session::get('branch');
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            Batch::create($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('batch.register')
            ->with('success', 'Batch created successfully');
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
        $batch = Batch::findOrFail(decrypt($id));
        $courses = Course::pluck('name', 'id');
        return view('batch.edit', compact('batch', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'name' => 'required',
            'category' => 'required',
            'admission_fee' => 'required',
            'monthly_fee' => 'required',
            'course_id' => 'required',
        ]);
        try {
            $batch = Batch::findOrFail(decrypt($id));
            $input = $request->all();
            $input['updated_by'] = $request->user()->id;
            $batch->update($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('batch.register')
            ->with('success', 'Batch updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Batch::findOrFail(decrypt($id))->delete();
        return redirect()->route('batch.register')
            ->with('success', 'Batch deleted successfully');
    }

    public function save(Request $request)
    {
        try {
            $data = [];
            foreach ($request->students as $key => $student):
                $data[] = [
                    'batch_id' => decrypt($request->batch_id),
                    'student_id' => $student[$key],
                ];
            endforeach;
            StudentBatch::insert($data);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('batch.register')
            ->with('success', 'Student Batch added successfully');
    }

    public function delete(String $id)
    {
        //
    }
}
