<?php

namespace App\Http\Controllers;

use App\Models\Head;
use App\Models\IncomeExpense;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Session;

class ExpenseController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('expense-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('expense-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('expense-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('expense-delete'), only: ['destroy']),
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $expenses = IncomeExpense::withTrashed()->where('category', 'expense')->where('branch_id', Session::get('branch'))->get();
        return view('expense.index', compact('expenses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $heads = Head::where('category', 'expense')->pluck('name', 'id');
        return view('expense.create', compact('heads'));
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
            $input['category'] = 'expense';
            $input['branch_id'] = Session::get('branch');
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            IncomeExpense::create($input);
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('expense.register')
            ->with('success', 'Expense created successfully');
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
        $heads = Head::where('category', 'expense')->pluck('name', 'id');
        $expense = IncomeExpense::findOrFail(decrypt($id));
        return view('expense.edit', compact('heads', 'expense'));
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
        return redirect()->route('expense.register')
            ->with('success', 'Expense updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        IncomeExpense::findOrFail(decrypt($id))->delete();
        return redirect()->route('expense.register')
            ->with('success', 'Expense deleted successfully');
    }
}
