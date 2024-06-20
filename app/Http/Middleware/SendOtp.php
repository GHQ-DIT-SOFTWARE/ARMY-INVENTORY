<?php

namespace App\Http\Middleware;

use App\Mail\OtpMail;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class SendOtp
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    // public function handle(Request $request, Closure $next)
    // {
    //     return $next($request);
    // }

    public function handle(Request $request, Closure $next)
    {
        // Generate a random 6-digit OTP
        $otp = rand(100000, 999999);
        Session::put('otp_code', $otp);
        Mail::to($request->user()->email)->send(new OtpMail($otp));
        return redirect()->route('verify.otp');
    }
}
