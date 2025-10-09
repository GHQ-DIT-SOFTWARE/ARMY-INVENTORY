<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DashboardLinks;
use App\Support\DashboardMetrics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class VehicleDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:vehicles.view');
    }

    public function __invoke(): View
    {
        $data = DashboardMetrics::vehicleSummary();
        $data['quickLinks'] = Auth::user() ? DashboardLinks::forVehicles(Auth::user()) : [];

        return view('vehicles.dashboard', $data);
    }
}
