<?php

namespace App\Http\Controllers;

use App\Models\Head;
use App\Models\IncomeExpense;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

class IncomeController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('income-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('income-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('income-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('income-delete'), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomes = IncomeExpense::withTrashed()->where('category', 'income')->where('branch_id', Session::get('branch'))->get();
        return view('income.index', compact('incomes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $heads = Head::where('category', 'income')->pluck('name', 'id');
        return view('income.create', compact('heads'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'head_id' => 'required',
        ]);
        try {
            $input = $request->all();
            $input['category'] = 'income';
            $input['branch_id'] = Session::get('branch');
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            IncomeExpense::create($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('income.register')
            ->with('success', 'Income created successfully');
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
        $heads = Head::where('category', 'income')->pluck('name', 'id');
        $income = IncomeExpense::findOrFail(decrypt($id));
        return view('income.edit', compact('heads', 'income'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'head_id' => 'required',
        ]);
        try {
            $income = IncomeExpense::findOrFail(decrypt($id));
            $input = $request->all();
            $input['updated_by'] = $request->user()->id;
            $income->update($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('income.register')
            ->with('success', 'Income updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        IncomeExpense::findOrFail(decrypt($id))->delete();
        return redirect()->route('income.register')
            ->with('success', 'Income deleted successfully');
    }
}
