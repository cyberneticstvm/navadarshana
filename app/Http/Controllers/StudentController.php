<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

class StudentController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('student-delete'), only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $students = Student::where('branch_id', Session::get('branch'))->withTrashed()->latest()->get();
        return view('student.index', compact('students'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('student.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'date_of_admission' => 'required|date',
            'name' => 'required',
            'email' => 'required|unique:students,email',
            'dob' => 'required|date',
            'mobile' => 'required|numeric|digits:10',
            'alt_mobile' => 'nullable|numeric|digits:10',
            'address' => 'required',
            'qualification' => 'required',
            'reservation_category' => 'required',
            'photo' => 'nullable|max:10000|mimes:jpg,png,jpeg,webp',
            'enrollment_type' => 'required',
        ]);
        try {
            $input = $request->all();
            $input['photo'] = null;
            $input['branch_id'] = Session::get('branch');
            $input['current_status'] = 'active';
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            $student = Student::create($input);
            if ($request->file('photo')):
                $photo = $request->file('photo');
                $path = '/student/photos/' . Session::get('branch') . '/' . $student->id;
                $fname = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs($path, $fname, 'public');
                $url = '/storage' . $path . '/' . $fname;
                $student->update([
                    'photo' => $url,
                ]);
            endif;
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('student.register')->with("success", "Student created successfully!");
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
        $student = Student::findOrFail(decrypt($id));
        return view('student.edit', compact('student'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'date_of_admission' => 'required|date',
            'name' => 'required',
            'email' => 'required|unique:students,email,' . decrypt($id),
            'dob' => 'required|date',
            'mobile' => 'required|numeric|digits:10',
            'alt_mobile' => 'nullable|numeric|digits:10',
            'address' => 'required',
            'qualification' => 'required',
            'reservation_category' => 'required',
            'photo' => 'nullable|max:10000|mimes:jpg,png,jpeg,webp',
            'enrollment_type' => 'required',
        ]);
        try {
            $student = Student::findOrFail(decrypt($id));
            $input = $request->all();
            $input['updated_by'] = $request->user()->id;
            if ($request->file('photo')):
                $photo = $request->file('photo');
                $path = '/student/photos/' . Session::get('branch') . '/' . $student->id;
                $fname = time() . '_' . $photo->getClientOriginalName();
                $photo->storeAs($path, $fname, 'public');
                $url = '/storage' . $path . '/' . $fname;
                $input['photo'] = $url;
            endif;
            $student->update($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('student.register')->with("success", "Student updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Student::findOrFail(decrypt($id))->delete();
        return redirect()->route('student.register')
            ->with('success', 'Student deleted successfully');
    }
}
