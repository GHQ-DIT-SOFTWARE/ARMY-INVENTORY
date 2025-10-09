<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\VehicleCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class VehicleController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:vehicles.view')->only('index');
        $this->middleware('permission:vehicles.manage')->only(['create', 'store', 'edit', 'update']);
        $this->middleware('permission:vehicles.delete')->only('destroy');
    }

    public function index(): View
    {
        $vehicles = Vehicle::with('category')->orderBy('name')->paginate(15);

        return view('vehicles.platforms.index', compact('vehicles'));
    }

    public function create(): View
    {
        $categories = VehicleCategory::where('is_active', true)->orderBy('name')->pluck('name', 'id');

        return view('vehicles.platforms.form', compact('categories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('vehicles', 'public');
        }

        Vehicle::create($data);

        return redirect()->route('vehicles.platforms.index')->with('message', 'Vehicle created successfully.')->with('alert-type', 'success');
    }

    public function edit(Vehicle $vehicle): View
    {
        $categories = VehicleCategory::where('is_active', true)->orderBy('name')->pluck('name', 'id');

        return view('vehicles.platforms.form', compact('vehicle', 'categories'));
    }

    public function update(Request $request, Vehicle $vehicle): RedirectResponse
    {
        $data = $this->validatedData($request, (int) $vehicle->id);

        if ($request->hasFile('image')) {
            if ($vehicle->image_path) {
                Storage::disk('public')->delete($vehicle->image_path);
            }
            $data['image_path'] = $request->file('image')->store('vehicles', 'public');
        }

        $vehicle->update($data);

        return redirect()->route('vehicles.platforms.index')->with('message', 'Vehicle updated successfully.')->with('alert-type', 'success');
    }

    public function destroy(Vehicle $vehicle): RedirectResponse
    {
        if ($vehicle->image_path) {
            Storage::disk('public')->delete($vehicle->image_path);
        }
        $vehicle->delete();

        return redirect()->route('vehicles.platforms.index')->with('message', 'Vehicle removed.')->with('alert-type', 'success');
    }

    private function validatedData(Request $request, int $vehicleId = 0): array
    {
        return $request->validate([
            'vehicle_category_id' => ['required', 'exists:vehicle_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'variant' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'country_of_origin' => ['nullable', 'string', 'max:255'],
            'engine_type' => ['nullable', 'string', 'max:255'],
            'engine_power_hp' => ['nullable', 'numeric'],
            'max_speed_kph' => ['nullable', 'numeric'],
            'range_km' => ['nullable', 'numeric'],
            'fuel_capacity_l' => ['nullable', 'numeric'],
            'weight_tons' => ['nullable', 'numeric'],
            'crew_capacity' => ['nullable', 'integer'],
            'passenger_capacity' => ['nullable', 'integer'],
            'armament' => ['nullable', 'string'],
            'armor' => ['nullable', 'string'],
            'communication_systems' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);
    }
}
