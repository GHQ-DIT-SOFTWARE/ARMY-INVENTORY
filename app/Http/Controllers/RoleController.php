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

class RoleController extends Controller
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

        $roles = Role::with('permissions')
            ->orderBy('name')
            ->paginate(12)
            ->withQueryString();

        $permissionsCount = Permission::count();

        return view('roles.index', [
            'roles' => $roles,
            'permissionsCount' => $permissionsCount,
        ]);
    }

    public function create()
    {
        $this->authorizeRolesMaintenance();

        $permissions  = Permission::all();
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
            'name' => $request->name,
            'guard_name' => 'web',
            'uuid' => (string) Str::uuid(),
        ]);

        $permissions = $request->input('permissions', []);
        if (! empty($permissions)) {
            $role->syncPermissions($permissions);
        }

        session()->flash('success', 'Role has been created !!');

        return back();
    }

    public function edit($id)
    {
        $this->authorizeRolesMaintenance();

        $role = Role::findById((int) $id, 'web');
        $permissions = Permission::all();
        $permission_groups = User::getpermissionGroups();

        return view('roles.edit', compact('role', 'permissions', 'permission_groups'));
    }

    public function update(Request $request, $id)
    {
        $this->authorizeRolesMaintenance();

        $request->validate([
            'name' => 'required|max:100|unique:roles,name,' . $id,
        ], [
            'name.required' => 'Please give a role name',
        ]);

        $role = Role::findById((int) $id, 'web');
        $permissions = $request->input('permissions', []);

        $role->name = $request->name;
        $role->save();
        $role->syncPermissions($permissions);

        session()->flash('success', 'Role has been updated !!');

        return back();
    }

    public function destroy($id)
    {
        $this->authorizeRolesMaintenance();

        $role = Role::findById((int) $id, 'web');
        if ($role) {
            $role->delete();
        }

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
