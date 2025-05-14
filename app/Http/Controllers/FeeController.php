<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Fee;
use App\Models\Month;
use App\Models\PaymentMode;
use App\Models\Student;
use App\Models\StudentBatch;
use App\Models\Year;
use Carbon\Carbon;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

use Illuminate\Http\Request;

class FeeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('fee-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('fee-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('fee-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('fee-delete'), only: ['destroy'])
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $fees = Fee::where('branch_id', Session::get('branch'))->whereMonth('created_at', Carbon::today())->whereYear('created_at', Carbon::today())->withTrashed()->latest()->get();
        return view('fee.index', compact('fees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(String $category, String $student)
    {
        $pmodes = PaymentMode::all();
        $month = Month::all();
        $year = Year::all();
        $student = Student::findOrFail(decrypt($student));
        $activeBatches = Batch::whereIn('id', StudentBatch::where('student_id', $student->id)->pluck('batch_id'))->pluck('name', 'id');
        return view('fee.create', compact('category', 'pmodes', 'month', 'year', 'student', 'activeBatches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'payment_date' => 'required|date',
            'batch_id' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'payment_mode' => 'required',
        ]);
        $input = $request->all();
        $input['student_id'] = decrypt($request->student_id);
        $input['branch_id'] = Student::find(decrypt($request->student_id))->branch_id;
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        Fee::create($input);
        return redirect()->route('fee.register')->with("success", "Fee recorded successfully!");
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
        $fee = Fee::findOrFail(decrypt($id));
        $pmodes = PaymentMode::all();
        $month = Month::all();
        $year = Year::all();
        $student = Student::findOrFail($fee->student_id);
        $activeBatches = Batch::whereIn('id', StudentBatch::where('student_id', $student->id)->pluck('batch_id'))->pluck('name', 'id');
        return view('fee.edit', compact('pmodes', 'month', 'year', 'student', 'activeBatches', 'fee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'payment_date' => 'required|date',
            'batch_id' => 'required',
            'type' => 'required',
            'amount' => 'required',
            'payment_mode' => 'required',
        ]);
        $input = $request->all();
        $input['student_id'] = decrypt($request->student_id);
        $input['updated_by'] = $request->user()->id;
        Fee::findOrFail(decrypt($id))->update($input);
        return redirect()->route('fee.register')->with("success", "Fee updated successfully!");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Fee::findOrFail(decrypt($id))->delete();
        return redirect()->route('fee.register')
            ->with('success', 'Fee deleted successfully');
    }
}
