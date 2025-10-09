<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\VehicleCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VehicleCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:vehicles.manage');
    }

    public function index(): View
    {
        $categories = VehicleCategory::orderBy('name')->paginate(20);

        return view('vehicles.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('vehicles.categories.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'unit_scope' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['unit_scope'] = $data['unit_scope'] ?? 'G4';
        $data['is_active'] = $request->boolean('is_active', true);

        VehicleCategory::create($data);

        return redirect()->route('vehicles.categories.index')->with('message', 'Vehicle category created successfully.')->with('alert-type', 'success');
    }

    public function edit(VehicleCategory $vehicleCategory): View
    {
        return view('vehicles.categories.form', compact('vehicleCategory'));
    }

    public function update(Request $request, VehicleCategory $vehicleCategory): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'unit_scope' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['unit_scope'] = $data['unit_scope'] ?? 'G4';
        $data['is_active'] = $request->boolean('is_active', true);

        $vehicleCategory->update($data);

        return redirect()->route('vehicles.categories.index')->with('message', 'Vehicle category updated.')->with('alert-type', 'success');
    }

    public function destroy(VehicleCategory $vehicleCategory): RedirectResponse
    {
        $vehicleCategory->delete();

        return redirect()->route('vehicles.categories.index')->with('message', 'Vehicle category removed.')->with('alert-type', 'success');
    }
}
