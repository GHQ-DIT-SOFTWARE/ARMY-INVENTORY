<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Audit;
class AuditController extends Controller
{
    public function ViewAudit(){
        $audittrail= Audit::latest()->get();
        return view('usermanage.activitylog',compact('audittrail'));
    }
}
