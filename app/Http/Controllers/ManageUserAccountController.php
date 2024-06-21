<?php

declare (strict_types = 1);

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password;

class ManageUserAccountController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => [
                'required',
                'string',
                Password::min(8)
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised(),
                'confirmed',
            ],
        ], [
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = Auth::user();
        $user->password = bcrypt($request->password);
        $user->password_changed_at = now();
        // $user->password_expiry = now()->addMonths(3);
        $user->password_expiry = Carbon::parse($user->password_changed_at)->addDays(90);
        $user->save();
        // Set session variable if password has expired
        if ($user->password_expiry < now()) {
            session()->flash('expired', true);
        }
        // Set session variable if it's the user's first login
        if (!$user->password_changed_at) {
            session()->flash('first_login', true);
        }

        return redirect()->route('login')->with('info', 'Password changed successfully.');
    }
}
