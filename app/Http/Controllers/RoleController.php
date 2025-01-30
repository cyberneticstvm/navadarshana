<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;


class RoleController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */
    public static function middleware(): array
    {
        return [
            new middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('role-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('role-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('role-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('role-delete'), only: ['destroy'])
        ];
    }

    public function index()
    {
        $roles = Role::orderBy('id', 'DESC')->paginate(5);
        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required',
        ]);

        $role = Role::create(['name' => $request->input('name')]);
        $permissions = Permission::whereIn('id', $request->permission)->where('guard_name', $role->guard_name)->get();
        $role->syncPermissions($permissions);

        return redirect()->route('role.register')
            ->with('success', 'Role created successfully');
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
        $role = Role::findOrFail(decrypt($id));
        $permissions = Permission::all();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id", decrypt($id))
            ->pluck('role_has_permissions.permission_id', 'role_has_permissions.permission_id')
            ->all();

        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $id,
            'permission' => 'required',
        ]);

        $role = Role::findOrFail($id);
        $role->name = $request->input('name');
        $role->save();

        $permissions = Permission::whereIn('id', $request->permission)->where('guard_name', $role->guard_name)->get();

        $role->syncPermissions($permissions);

        return redirect()->route('role.register')
            ->with('success', 'Role updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::table("roles")->where('id', decrypt($id))->delete();
        return redirect()->route('role.register')
            ->with('success', 'Role deleted successfully');
    }
}
