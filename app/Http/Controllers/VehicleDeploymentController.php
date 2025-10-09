<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\MotorPool;
use App\Models\Personnel;
use App\Models\VehicleDeployment;
use App\Models\VehicleInventory;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VehicleDeploymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:vehicles.deploy')->only(['create', 'store']);
        $this->middleware('permission:vehicles.return')->only(['returnForm', 'processReturn']);
        $this->middleware('permission:vehicles.view')->only('track');
    }

    public function create(): View
    {
        $motorPools = MotorPool::orderBy('name')->pluck('name', 'id');
        $availableVehicles = VehicleInventory::with('vehicle')
            ->where('status', 'in_pool')
            ->orderBy('asset_number')
            ->get();
        $operators = Personnel::orderBy('surname')->get();

        return view('vehicles.deployments.deploy-form', compact('motorPools', 'availableVehicles', 'operators'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'motor_pool_id' => ['required', 'exists:motor_pools,id'],
            'vehicle_inventory_ids' => ['required', 'array'],
            'vehicle_inventory_ids.*' => ['exists:vehicle_inventories,id'],
            'operator_id' => ['nullable', 'exists:personnels,id'],
            'expected_return_at' => ['nullable', 'date'],
            'deployment_notes' => ['nullable', 'string'],
        ]);

        foreach ($data['vehicle_inventory_ids'] as $inventoryId) {
            $inventory = VehicleInventory::findOrFail($inventoryId);
            $inventory->update([
                'status' => 'deployed',
                'current_motor_pool_id' => $data['motor_pool_id'],
                'last_serviced_at' => $inventory->last_serviced_at,
            ]);

            VehicleDeployment::create([
                'vehicle_inventory_id' => $inventory->id,
                'motor_pool_id' => $data['motor_pool_id'],
                'issued_by' => Auth::id(),
                'operator_id' => $data['operator_id'] ?? null,
                'deployed_at' => Carbon::now(),
                'expected_return_at' => isset($data['expected_return_at']) ? Carbon::parse($data['expected_return_at']) : null,
                'status' => 'deployed',
                'deployment_notes' => $data['deployment_notes'] ?? null,
            ]);
        }

        return redirect()->route('vehicles.deployments.create')->with('message', 'Vehicles deployed successfully.')->with('alert-type', 'success');
    }

    public function returnForm(): View
    {
        return view('vehicles.deployments.return-form');
    }

    public function processReturn(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'asset_numbers' => ['required', 'string'],
            'return_notes' => ['nullable', 'string'],
        ]);

        $assetNumbers = collect(preg_split('/[\s,\n]+/', $data['asset_numbers'], -1, PREG_SPLIT_NO_EMPTY));
        $processed = 0;

        foreach ($assetNumbers as $assetNumber) {
            $inventory = VehicleInventory::where('asset_number', $assetNumber)->first();
            if (! $inventory) {
                continue;
            }

            $deployment = $inventory->deployments()->whereNull('returned_at')->latest('deployed_at')->first();
            if (! $deployment) {
                continue;
            }

            $inventory->update([
                'status' => 'in_pool',
            ]);

            $deployment->update([
                'returned_at' => Carbon::now(),
                'status' => 'returned',
                'return_notes' => $data['return_notes'] ?? null,
            ]);

            $processed++;
        }

        if ($processed === 0) {
            return redirect()->back()->with('message', 'No matching deployments found.')->with('alert-type', 'warning');
        }

        return redirect()->route('vehicles.returns.form')->with('message', 'Return processed for ' . $processed . ' vehicle(s).')->with('alert-type', 'success');
    }

    public function track(Request $request): View
    {
        $result = null;
        $search = $request->string('asset_number')->toString();
        if ($search) {
            $result = VehicleInventory::with(['vehicle', 'motorPool', 'deployments.motorPool', 'deployments.issuer', 'deployments.operator'])
                ->where('asset_number', $search)
                ->first();
        }

        return view('vehicles.deployments.track', compact('result', 'search'));
    }
}
