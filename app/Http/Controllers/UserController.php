<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

class UserController extends Controller implements HasMiddleware
{
    /**
     * Display a listing of the resource.
     */

    public static function middleware(): array
    {
        return [
            /*new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-delete'), only: ['destroy']),*/];
    }

    public function index()
    {
        $users = User::withTrashed()->get();
        return view('user.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('user.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'roles' => 'required',
        ]);
        try {
            $input = $request->all();
            $input['password'] = Hash::make($request->password);
            $user = User::create($input);
            $user->assignRole($request->input('roles'));
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('user.register')->with("success", "User created successfully");
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user, string $id)
    {
        $user = User::findOrFail(decrypt($id));
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        return view('user.edit', compact('user', 'roles', 'userRole'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user, string $id)
    {
        //$id = decrypt($id);
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|unique:users,email,' . $id,
            'roles' => 'required',
        ]);
        try {
            $user = User::findOrFail($id);
            $input = $request->all();
            if ($request->password) :
                $input['password'] = Hash::make($request->password);
            else :
                $input = Arr::except($input, array('password'));
            endif;
            $user->update($input);
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            $user->assignRole($request->input('roles'));
        } catch (Exception $e) {
            return redirect()->back()->with("error", $e->getMessage())->withInput($request->all());
        }
        return redirect()->route('user.register')->with("success", "User updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user, string $id)
    {
        User::findOrFail(decrypt($id))->delete();
        return redirect()->route('user.register')->with("success", "User deleted successfully");
    }
}
