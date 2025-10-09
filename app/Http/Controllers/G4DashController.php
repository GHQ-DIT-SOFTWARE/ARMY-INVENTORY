<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DashboardLinks;
use App\Support\DashboardMetrics;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class G4DashController extends Controller
{
    public function index(): View
    {
        $data = DashboardMetrics::globalSummary();
        $data['quickLinks'] = Auth::user() ? DashboardLinks::forGlobal(Auth::user()) : [];

        return view('admin.g4_dash', $data);
    }
}
