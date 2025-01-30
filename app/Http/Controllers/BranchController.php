<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;
use \Illuminate\Routing\Controllers\HasMiddleware;
use \Illuminate\Routing\Controllers\middleware;

class BranchController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('branch-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('branch-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('branch-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('branch-delete'), only: ['destroy'])
        ];
    }

    public function index()
    {
        $branches = Branch::withTrashed()->get();
        return view('branch.index', compact('branches'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branch.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:branches,name',
            'code' => 'required|unique:branches,code',
            'contact_number' => 'required|numeric|digits:10',
            'address' => 'required',
        ]);
        $input = $request->all();
        $input['created_by'] = $request->user()->id;
        $input['updated_by'] = $request->user()->id;
        Branch::create($input);
        return redirect()->route('branch.register')
            ->with('success', 'Branch created successfully');
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
        $branch = Branch::findOrFail(decrypt($id));
        return view('branch.edit', compact('branch'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);
        $request->validate([
            'name' => 'required|unique:branches,name,' . $id,
            'code' => 'required|unique:branches,code,' . $id,
            'contact_number' => 'required',
            'address' => 'required',
        ]);
        $input = $request->all();
        $input['updated_by'] = $request->user()->id;
        $branch = Branch::findOrFail($id);
        $branch->update($input);
        return redirect()->route('branch.register')
            ->with('success', 'Branch updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Branch::findOrFail(decrypt($id))->delete();
        return redirect()->route('branch.register')
            ->with('success', 'Branch deleted successfully');
    }
}
