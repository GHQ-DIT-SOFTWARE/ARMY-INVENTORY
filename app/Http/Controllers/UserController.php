<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Session;
class UserController extends Controller
{
    public $user;
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            $this->user = Auth::guard('web')->user();
            return $next($request);
        });
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (is_null($this->user) || !$this->user->can('superadmin.view')) {
            abort(403, 'Sorry !! You are Unauthorized to view any user !');
        }
        $users = User::all();
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (is_null($this->user) || !$this->user->can('superadmin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any user !');
        }
        $roles  = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (is_null($this->user) || !$this->user->can('superadmin.create')) {
            abort(403, 'Sorry !! You are Unauthorized to create any user !');
        }
        // Validation Data
        $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|max:100|email|unique:users',

        ]);
        // Create New Admin
        $user = new User();
        $code = rand(0000,9999);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = '1';
        $user->password = bcrypt($code);
        $user->code = $code;
        $user->save();
        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }
        session()->flash('success', 'User has been created !!');
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if (is_null($this->user) || !$this->user->can('superadmin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        }
        $user = User::find($id);
        $roles  = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if (is_null($this->user) || !$this->user->can('superadmin.edit')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        }
         // Create New User
         $user = User::find($id);
         // Validation Data
         $request->validate([
             'name' => 'required|max:50',
             'email' => 'required|max:100|email|unique:users,email,' . $id,
             'password' => 'nullable|min:6|confirmed',
         ]);
         $user->name = $request->name;
         $user->email = $request->email;
         if ($request->password) {
             $user->password = Hash::make($request->password);
         }
         $user->save();
         $user->roles()->detach();
         if ($request->roles) {
             $user->assignRole($request->roles);
         }
         session()->flash('success', 'User has been updated !!');
         return back();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (is_null($this->user) || !$this->user->can('superadmin.delete')) {
            abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        }
        $user = User::find($id);
        if (!is_null($user)) {
            $user->delete();
        }
        session()->flash('success', 'User has been deleted !!');
        return back();
    }
}
