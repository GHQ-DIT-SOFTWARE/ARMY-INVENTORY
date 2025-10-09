<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Rbac;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /** @var \App\Models\User|null */
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
        $this->ensureCanManageUsers();

        if ($this->user->can(Rbac::PERMISSION_USERS_MANAGE_ALL)) {
            $users = User::with('roles')->get();
        } else {
            $manageableRoles = $this->manageableRoleNames();
            $users = User::with('roles')
                ->whereHas('roles', function ($query) use ($manageableRoles) {
                    $query->whereIn('name', $manageableRoles);
                })
                ->get();
        }

        return view('users.index', compact('users'));
    }

    public function create()
    {
        $this->ensureCanManageUsers();

        $roles = $this->availableRoles();
        abort_if($roles->isEmpty(), 403, 'You do not have permission to create users for any role.');

        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $this->ensureCanManageUsers();

        $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:100', 'email', 'unique:users'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string'],
        ]);

        $rolesToAssign = $this->filterAssignableRoles($request->input('roles', []));
        if (empty($rolesToAssign)) {
            return back()->withErrors(['roles' => 'You are not allowed to assign the selected role(s).'])->withInput();
        }

        $user = new User();
        $code = rand(1000, 9999);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = '1';
        $user->password = bcrypt($code);
        $user->code = $code;
        if ($request->filled('phone_number')) {
            $user->phone_number = $request->phone_number;
        }
        $user->save();

        $user->syncRoles($rolesToAssign);

        session()->flash('success', 'User has been created.');

        return redirect()->route('users.index');
    }

    public function edit($id)
    {
        $this->ensureCanManageUsers();

        $user = User::findOrFail($id);
        $this->ensureTargetWithinScope($user);

        $roles = $this->availableRoles();
        abort_if($roles->isEmpty(), 403, 'You do not have permission to manage user roles.');

        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, $id)
    {
        $this->ensureCanManageUsers();

        $user = User::findOrFail($id);
        $this->ensureTargetWithinScope($user);

        $request->validate([
            'name' => ['required', 'max:50'],
            'email' => ['required', 'max:100', 'email', 'unique:users,email,' . $id],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'min:6', 'confirmed'],
            'roles' => ['required', 'array', 'min:1'],
            'roles.*' => ['string'],
        ]);

        $rolesToAssign = $this->filterAssignableRoles($request->input('roles', []));
        if (empty($rolesToAssign)) {
            return back()->withErrors(['roles' => 'You are not allowed to assign the selected role(s).'])->withInput();
        }

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->filled('phone_number')) {
            $user->phone_number = $request->phone_number;
        }
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
        $user->save();

        $user->syncRoles($rolesToAssign);

        session()->flash('success', 'User has been updated.');

        return back();
    }

    public function destroy($id)
    {
        $this->ensureCanManageUsers();

        $user = User::findOrFail($id);
        $this->ensureTargetWithinScope($user);

        $user->delete();

        session()->flash('success', 'User has been deleted.');

        return back();
    }

    private function ensureCanManageUsers(): void
    {
        if (! $this->user || ! Rbac::canManageUsers($this->user)) {
            abort(403, 'Sorry, you are not authorised to manage user accounts.');
        }
    }

    private function manageableRoleNames(): array
    {
        if (! $this->user) {
            return [];
        }

        if ($this->user->can(Rbac::PERMISSION_USERS_MANAGE_ALL)) {
            return Rbac::allRoles();
        }

        return Rbac::manageableRoleNames($this->user);
    }

    private function availableRoles()
    {
        $roleNames = $this->manageableRoleNames();

        return Role::whereIn('name', $roleNames)->orderBy('name')->get();
    }

    private function filterAssignableRoles(array $requested): array
    {
        $allowed = $this->manageableRoleNames();

        $requested = array_filter(array_map('strval', $requested));

        return array_values(array_intersect($requested, $allowed));
    }

    private function ensureTargetWithinScope(User $target): void
    {
        if ($this->user && $this->user->can(Rbac::PERMISSION_USERS_MANAGE_ALL)) {
            return;
        }

        $allowedRoles = $this->manageableRoleNames();
        $hasOverlap = $target->roles()->whereIn('name', $allowedRoles)->exists();

        if (! $hasOverlap) {
            abort(403, 'You are not authorised to manage this user.');
        }
    }
}
