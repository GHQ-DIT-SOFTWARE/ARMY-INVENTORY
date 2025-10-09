<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\MotorPool;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MotorPoolController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:vehicles.manage');
    }

    public function index(): View
    {
        $motorPools = MotorPool::orderBy('name')->paginate(15);

        return view('vehicles.motor-pools.index', compact('motorPools'));
    }

    public function create(): View
    {
        return view('vehicles.motor-pools.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:motor_pools,code'],
            'location' => ['nullable', 'string', 'max:255'],
            'fleet_manager' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        MotorPool::create($data);

        return redirect()->route('vehicles.motor-pools.index')->with('message', 'Motor pool created successfully.')->with('alert-type', 'success');
    }

    public function edit(MotorPool $motorPool): View
    {
        return view('vehicles.motor-pools.form', compact('motorPool'));
    }

    public function update(Request $request, MotorPool $motorPool): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:motor_pools,code,' . $motorPool->id],
            'location' => ['nullable', 'string', 'max:255'],
            'fleet_manager' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $motorPool->update($data);

        return redirect()->route('vehicles.motor-pools.index')->with('message', 'Motor pool updated successfully.')->with('alert-type', 'success');
    }

    public function destroy(MotorPool $motorPool): RedirectResponse
    {
        $motorPool->delete();

        return redirect()->route('vehicles.motor-pools.index')->with('message', 'Motor pool removed.')->with('alert-type', 'success');
    }
}
