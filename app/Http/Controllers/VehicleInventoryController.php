<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\MotorPool;
use App\Models\Vehicle;
use App\Models\VehicleInventory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleInventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:vehicles.view')->only('index');
        $this->middleware('permission:vehicles.manage')->except('index');
    }

    public function index(Request $request): View
    {
        $query = VehicleInventory::with(['vehicle', 'motorPool'])->orderByDesc('created_at');

        if ($search = $request->string('search')->toString()) {
            $query->where('asset_number', 'like', '%' . $search . '%');
        }

        $inventories = $query->paginate(20)->withQueryString();

        return view('vehicles.inventory.index', compact('inventories'));
    }

    public function create(): View
    {
        $vehicles = $this->vehicleOptions();
        $motorPools = MotorPool::orderBy('name')->pluck('name', 'id');

        return view('vehicles.inventory.form', compact('vehicles', 'motorPools'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'asset_number' => ['required', 'string', 'max:100', 'unique:vehicle_inventories,asset_number'],
            'acquired_on' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'current_motor_pool_id' => ['nullable', 'exists:motor_pools,id'],
            'last_serviced_at' => ['nullable', 'date'],
            'condition_notes' => ['nullable', 'string'],
        ]);

        VehicleInventory::create($data);

        return redirect()->route('vehicles.inventory.index')->with('message', 'Vehicle asset created.')->with('alert-type', 'success');
    }

    public function edit(VehicleInventory $vehicleInventory): View
    {
        $vehicles = $this->vehicleOptions();
        $motorPools = MotorPool::orderBy('name')->pluck('name', 'id');

        return view('vehicles.inventory.form', [
            'vehicleInventory' => $vehicleInventory,
            'vehicles' => $vehicles,
            'motorPools' => $motorPools,
        ]);
    }

    public function update(Request $request, VehicleInventory $vehicleInventory): RedirectResponse
    {
        $data = $request->validate([
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'asset_number' => ['required', 'string', 'max:100', 'unique:vehicle_inventories,asset_number,' . $vehicleInventory->id],
            'acquired_on' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'current_motor_pool_id' => ['nullable', 'exists:motor_pools,id'],
            'last_serviced_at' => ['nullable', 'date'],
            'condition_notes' => ['nullable', 'string'],
        ]);

        $vehicleInventory->update($data);

        return redirect()->route('vehicles.inventory.index')->with('message', 'Vehicle asset updated.')->with('alert-type', 'success');
    }

    public function destroy(VehicleInventory $vehicleInventory): RedirectResponse
    {
        $vehicleInventory->delete();

        return redirect()->route('vehicles.inventory.index')->with('message', 'Vehicle asset removed.')->with('alert-type', 'success');
    }

    private function vehicleOptions()
    {
        return Vehicle::orderBy('name')
            ->get()
            ->mapWithKeys(function (Vehicle $vehicle) {
                $label = $vehicle->name;

                if (! empty($vehicle->variant)) {
                    $label .= ' (' . $vehicle->variant . ')';
                }

                return [$vehicle->id => $label];
            });
    }
}
