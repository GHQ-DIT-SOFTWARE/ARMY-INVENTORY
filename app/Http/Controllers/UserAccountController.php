<?php
declare (strict_types = 1);
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class UserAccountController extends Controller
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
        // if (is_null($this->user) || !$this->user->can('useraccount.view')) {
        //     abort(403, 'Sorry !! You are Unauthorized to view any user !');
        // }
        $inactiveUsers = User::where('status', 0)->get();
        if ($inactiveUsers->isNotEmpty()) {
            $alertMessage = 'The following user account is  inactive: ';
            foreach ($inactiveUsers as $user) {
                $alertMessage .= $user->name . ', ';
            }
            $alertMessage = rtrim($alertMessage, ', ');
            $alertMessage .= '.Please take necessary actions.';
            session()->flash('alert', $alertMessage);
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
        // if (is_null($this->user) || !$this->user->can('useraccount.create')) {
        //     abort(403, 'Sorry !! You are Unauthorized to create any user !');
        // }
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:users',
            'email' => 'required|max:100|email|unique:users',
        ]);
        // Create New Admin
        $user = new User();
        $code = rand(0000, 9999);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->status = '1';
        $user->password = bcrypt($code);
        $user->code = $code;
        $user->phone_number = $request->phone_number;
        $user->save();
        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }
        session()->flash('success', 'User has been created !!');
        return redirect()->route('index-user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($uuid)
    {
        // if (is_null($this->user) || !$this->user->can('useraccount.edit')) {
        //     abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        // }
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            abort(404);
        }
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $uuid = $request->input('uuid');
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            abort(404);
        }
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone_number = $request->phone_number;
        $user->save();
        $user->roles()->detach();
        if ($request->roles) {
            $user->assignRole($request->roles);
        }
        session()->flash('success', 'User has been updated !!');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($uuid)
    {
        // if (is_null($this->user) || !$this->user->can('useraccount.delete')) {
        //     abort(403, 'Sorry !! You are Unauthorized to delete any user !');
        // }
        $user = User::where('uuid', $uuid)->first();
        if (!$user) {
            abort(404);
        }
        $user->delete();
        session()->flash('success', 'User has been deleted !!');
        return back();
    }
}
