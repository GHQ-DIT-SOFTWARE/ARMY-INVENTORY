<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\activityLog;
class LogactivityController extends Controller
{
    public function login_and_logout_activities(){
        $login_and_logout=activityLog::orderBy('id', 'desc')->get();
        return view('usermanage.login_and_logout_activties',compact('login_and_logout'));
    }

}
