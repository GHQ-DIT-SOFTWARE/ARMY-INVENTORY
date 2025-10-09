<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DashboardLinks;
use App\Support\DashboardMetrics;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;

class WeaponDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:weapons.view');
    }

    public function __invoke(): View
    {
        $data = DashboardMetrics::weaponSummary();
        $data['quickLinks'] = Auth::user() ? DashboardLinks::forWeapons(Auth::user()) : [];

        return view('weapons.dashboard', $data);
    }
}
