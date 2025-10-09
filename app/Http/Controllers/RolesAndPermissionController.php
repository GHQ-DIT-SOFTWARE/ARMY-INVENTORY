<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Rbac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionController extends Controller
{
    public $user;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();

            return $next($request);
        });
    }

    public function index()
    {
        $this->authorizeRolesMaintenance();

        $roles = Role::all();

        return view('roles.index', compact('roles'));
    }

    public function create_role()
    {
        $this->authorizeRolesMaintenance();

        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();

        return view('roles.create', compact('permissions', 'permission_groups'));
    }

    public function store(Request $request)
    {
        $this->authorizeRolesMaintenance();

        $request->validate([
            'name' => 'required|max:100|unique:roles',
        ], [
            'name.required' => 'Please give a role name',
        ]);

        $role = Role::create([
            'uuid' => (string) Str::uuid(),
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        $permissions = $request->input('permissions', []);
        if (! empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role has been created !!');

        return redirect()->route('index-roles');
    }

    public function edit($uuid)
    {
        $this->authorizeRolesMaintenance();

        $role = Role::where('uuid', $uuid)->firstOrFail();
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();

        return view('roles.edit', compact('role', 'permissions', 'permission_groups'));
    }

    public function update(Request $request)
    {
        $this->authorizeRolesMaintenance();

        $request->validate([
            'uuid' => ['required', 'exists:roles,uuid'],
            'name' => ['required', 'max:100'],
        ]);

        $role = Role::where('uuid', $request->input('uuid'))->firstOrFail();
        if ($role->name !== $request->name) {
            $request->validate([
                'name' => 'unique:roles,name',
            ]);
        }

        $role->name = $request->name;
        $role->save();

        $permissions = $request->input('permissions', []);
        $role->syncPermissions($permissions);

        session()->flash('success', 'Role has been updated !!');

        return back();
    }

    public function destroy($uuid)
    {
        $this->authorizeRolesMaintenance();

        $role = Role::where('uuid', $uuid)->firstOrFail();
        $role->delete();

        session()->flash('success', 'Role has been deleted !!');

        return back();
    }

    private function authorizeRolesMaintenance(): void
    {
        if (is_null($this->user) || ! $this->user->can(Rbac::PERMISSION_USERS_MANAGE_ALL)) {
            abort(403, 'Sorry !! You are Unauthorized to manage roles !');
        }
    }
}
