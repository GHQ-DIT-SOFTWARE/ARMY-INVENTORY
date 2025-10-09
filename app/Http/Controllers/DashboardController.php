<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Support\DashboardLinks;
use App\Support\DashboardMetrics;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(): View
    {
        Auth::user()->can('dashboard.view.main');

        $user = Auth::guard('web')->user();

        $globalSummary = DashboardMetrics::globalSummary();
        $weaponSummary = DashboardMetrics::weaponSummary();
        $vehicleSummary = DashboardMetrics::vehicleSummary();
        $quickLinks = DashboardLinks::merged($user);

        return view('dashboard.index', [
            'pageTitle' => 'Operations Dashboard',
            'globalTitle' => 'Logistics Operations Overview',
            'globalSubtitle' => 'Central snapshot across stock, demand, and personnel.',
            'weaponTitle' => 'Weapons Command Center',
            'weaponSubtitle' => 'Realtime insight into weapon readiness and workflows.',
            'vehicleTitle' => 'Vehicle Fleet Command Center',
            'vehicleSubtitle' => 'Operational status of armored and tactical vehicles.',
            'globalSummary' => $globalSummary,
            'weaponSummary' => $weaponSummary,
            'vehicleSummary' => $vehicleSummary,
            'quickLinks' => $quickLinks,
        ]);
    }
}
