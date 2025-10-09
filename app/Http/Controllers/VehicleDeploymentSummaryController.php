<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\VehicleDeployment;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Carbon;

class VehicleDeploymentSummaryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:vehicles.view');
    }

    public function __invoke(): View
    {
        $now = Carbon::now();
        $startOfMonth = (clone $now)->startOfMonth();

        $metrics = [
            'totalDeployments' => VehicleDeployment::count(),
            'activeDeployments' => VehicleDeployment::whereNull('returned_at')->count(),
            'returnedThisMonth' => VehicleDeployment::whereNotNull('returned_at')
                ->whereBetween('returned_at', [$startOfMonth, $now])
                ->count(),
            'overdueDeployments' => VehicleDeployment::whereNull('returned_at')
                ->whereNotNull('expected_return_at')
                ->where('expected_return_at', '<', $now)
                ->count(),
        ];

        $motorPoolBreakdown = VehicleDeployment::query()
            ->leftJoin('motor_pools', 'motor_pools.id', '=', 'vehicle_deployments.motor_pool_id')
            ->selectRaw("COALESCE(motor_pools.name, 'Unassigned') as pool, COUNT(*) as total")
            ->whereNull('vehicle_deployments.returned_at')
            ->groupBy('pool')
            ->orderByDesc('total')
            ->get();

        $activeDeployments = VehicleDeployment::with([
            'inventory.vehicle',
            'motorPool',
            'issuer',
            'operator',
        ])
            ->whereNull('returned_at')
            ->latest('deployed_at')
            ->get();

        return view('vehicles.deployments.summary', [
            'metrics' => $metrics,
            'motorPoolBreakdown' => $motorPoolBreakdown,
            'activeDeployments' => $activeDeployments,
        ]);
    }
}

