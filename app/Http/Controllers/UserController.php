<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\User;
use App\Models\UserBranch;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller implements HasMiddleware
{

    protected $branches;
    public function __construct()
    {
        $this->branches = Branch::when(!in_array(Auth::user()->roles->first()->name, ['Administrator']), function ($q) {
            return $q->where('id', Session::get('branch'));
        })->pluck('name', 'id');
    }

    public static function middleware(): array
    {
        return [
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-list'), only: ['index']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-create'), only: ['create', 'store']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-edit'), only: ['edit', 'update']),
            new Middleware(\Spatie\Permission\Middleware\PermissionMiddleware::using('user-delete'), only: ['destroy']),
        ];
    }

    function dashboard()
    {
        $branches = Branch::whereIn('id', UserBranch::where('user_id', Auth::id())->pluck('branch_id'))->pluck('name', 'id');
        return view('dashboard', compact('branches'));
    }

    public function updateBranch(Request $request)
    {
        $branch = Branch::findOrFail($request->branch);
        Session::put('branch', $branch->id);
        Session::put('bname', $branch->name);
        if (Session::has('branch')) :
            return redirect()->route('dashboard')
                ->withSuccess('User branch updated successfully!');
        else :
            return redirect()->route('dashboard')
                ->withError('Please update branch!');
        endif;
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
        $branches = $this->branches;
        return view('user.create', compact('roles', 'branches'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6',
            'roles' => 'required',
            'branches' => 'required',
        ]);
        try {
            $input = $request->except(array('branches', 'roles'));
            $input['password'] = Hash::make($input['password']);
            $input['created_by'] = $request->user()->id;
            $input['updated_by'] = $request->user()->id;
            $user = User::create($input);
            $user->assignRole($request->input('roles'));
            $data = [];
            foreach ($request->branches as $key => $br) :
                $data[] = [
                    'user_id' => $user->id,
                    'branch_id' => $br,
                ];
            endforeach;
            UserBranch::insert($data);
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
        $branches = $this->branches;
        return view('user.edit', compact('user', 'roles', 'userRole', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required',
            'branches' => 'required',
        ]);
        try {
            $input = $request->except(array('branches', 'roles'));
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            } else {
                $input = Arr::except($input, array('password'));
            }

            $user = User::findOrFail($id);
            $user->update($input);
            $data = [];
            foreach ($request->branches as $key => $br) :
                $data[] = [
                    'user_id' => $user->id,
                    'branch_id' => $br,
                ];
            endforeach;
            DB::table('model_has_roles')->where('model_id', $id)->delete();
            DB::table('user_branches')->where('user_id', $id)->delete();
            $user->assignRole($request->input('roles'));
            UserBranch::insert($data);
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
        UserBranch::where('user_id', decrypt($id))->delete();
        return redirect()->route('user.register')->with("success", "User deleted successfully");
    }
}
