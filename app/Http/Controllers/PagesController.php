<?php
namespace App\Http\Controllers;

use App\Mail\OtpMail;
use App\Models\User;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class PagesController extends Controller
{
    public function Log_in(Request $request)
    {
        // Validate the login credentials
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);
        $email = $request->email;
        $password = $request->password;
        $now = Carbon::now();
        $todayDate = $now->toDateTimeString();
        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            $user = Auth::user();
            if ($user->status == 1) {
                // Log the activity
                $activityLog = [
                    'uuid' => Str::uuid(),
                    'name' => $user->name,
                    'email' => $user->email,
                    'description' => 'has logged in',
                    'date_time' => $todayDate,
                ];
                DB::table('activity_logs')->insert($activityLog);
                // Generate a random 6-digit OTP
                $otp = rand(100000, 999999);
                Session::put('otp_code', $otp);
                Session::put('otp_verified', false);
                // Send OTP email to the authenticated user
                Mail::to($user->email)->send(new OtpMail($otp));
                // Redirect to the OTP verification page
                return redirect()->route('verify.otp');
            } else {
                Auth::logout();
                return redirect()->route('login')->withErrors(['error' => 'Your account is deactivated. Please contact the Admin.']);
            }
        }
        return redirect()->route('login')->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }
    // public function Log_in(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|string|email',
    //         'password' => 'required|string',
    //     ]);
    //     $email = $request->email;
    //     $password = $request->password;
    //     $user = User::where('email', $email)->first();
    //     if ($user) {
    //         if ($user->status == 0) {
    //             return back()->withErrors(['login' => 'Your account is inactive. Please contact the administrator.']);
    //         }
    //         // Check if the user has an active session
    //         $activeSession = $this->isUserLoggedIn($user->id);
    //         if ($activeSession) {
    //             return back()->withErrors(['login' => 'Your account is already logged in. Please sign out before logging in again.']);
    //         }
    //     }
    //     if (Auth::attempt(['email' => $email, 'password' => $password])) {
    //         $user = Auth::user();
    //         $dt = Carbon::now();
    //         $todayDate = $dt->toDayDateTimeString();
    //         $activityLog = [
    //             'name' => $user->name,
    //             'email' => $user->email,
    //             'description' => 'has logged in',
    //             'date_time' => $todayDate,
    //         ];
    //         $user->save();
    //         DB::table('activity_logs')->insert($activityLog);
    //         Session::put('user_id', $user->id);
    //         return redirect()->intended('dashboard');
    //     } else {
    //         // Authentication failed.
    //         return back()->withErrors(['login' => 'Invalid email or password.']);
    //     }
    // }
    public function Logout()
    {
        $user = Auth::user();

        if ($user) {
            // $user->is_logged_in = 0;
            $user->save();
            $name = $user->name;
            $email = $user->email;
            $dt = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();
            $activityLog = [
                'name' => $name,
                'email' => $email,
                'description' => 'has logged out',
                'date_time' => $todayDate,
            ];

            DB::table('activity_logs')->insert($activityLog);
        }
        Auth::logout();
        Session::forget('user_id');
        return redirect()->route('login.dashboard')->with('success', 'User Logout Successfully');
    }
    private function isUserLoggedIn($userId)
    {
        // Retrieve the user from the database
        $user = User::find($userId);
        if ($user) {
            // Check if the user's login status is true
            return $user->is_logged_in;
        }
        return false;
    }
    public function Inactive($id)
    {
        $activeandinactive = User::findOrFail($id);
        if ($activeandinactive) {
            $activeandinactive->status = 1;
            $activeandinactive->save();
            $notification = array(
                'message' => 'Changed Made Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('users.index')->with($notification);
        }
    }
    public function Active($id)
    {
        $activeandinactive = User::findOrFail($id);
        if ($activeandinactive) {
            $activeandinactive->status = 0;
            $activeandinactive->save();
            $notification = array(
                'message' => 'Change Made Successfully',
                'alert-type' => 'success',
            );
            return redirect()->route('users.index')->with($notification);
        }
    }
    public function Resetpassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'password_confirmation' => 'required|string',
        ]);
        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if ($user) {
            // Check if the user has an active session
            $activeSession = $this->isUserLoggedIn($user->id);
            if ($activeSession) {
                return back()->withErrors(['login' => 'Your account is already logged in. Please sign out before logging in again.']);
            }
            // Resetting the password
            $user->password = Hash::make($password);
            $user->save();
            return redirect()->route('login')->with('success', 'Password reset successfully. You can now log in with your new password.');
        }
        return back()->withErrors(['email' => 'Invalid email address.']);
    }

    public function verifyaccount()
    {
        return view('auth.verifypasswordforcechange');
    }
}
