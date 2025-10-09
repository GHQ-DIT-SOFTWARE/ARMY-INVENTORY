<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Armory;
use App\Models\Weapon;
use App\Models\WeaponInventory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WeaponInventoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:weapons.view')->only('index');
        $this->middleware('permission:weapons.manage')->except('index');
    }

    public function index(Request $request): View
    {
        $query = WeaponInventory::with(['weapon', 'armory'])->orderByDesc('created_at');

        if ($search = $request->string('search')->toString()) {
            $query->where('weapon_number', 'like', '%' . $search . '%');
        }

        $inventories = $query->paginate(20)->withQueryString();

        return view('weapons.inventory.index', compact('inventories'));
    }

    public function create(): View
    {
        $weapons = Weapon::orderBy('name')->pluck('name', 'id');
        $armories = Armory::orderBy('name')->pluck('name', 'id');

        return view('weapons.inventory.form', compact('weapons', 'armories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'weapon_id' => ['required', 'exists:weapons,id'],
            'weapon_number' => ['required', 'string', 'max:100', 'unique:weapon_inventories,weapon_number'],
            'acquired_on' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'current_armory_id' => ['nullable', 'exists:armories,id'],
            'last_audited_at' => ['nullable', 'date'],
            'condition_notes' => ['nullable', 'string'],
        ]);

        WeaponInventory::create($data);

        return redirect()->route('weapons.inventory.index')->with('message', 'Weapon inventory record created.')->with('alert-type', 'success');
    }

    public function edit(WeaponInventory $weaponInventory): View
    {
        $weapons = Weapon::orderBy('name')->pluck('name', 'id');
        $armories = Armory::orderBy('name')->pluck('name', 'id');

        return view('weapons.inventory.form', [
            'weaponInventory' => $weaponInventory,
            'weapons' => $weapons,
            'armories' => $armories,
        ]);
    }

    public function update(Request $request, WeaponInventory $weaponInventory): RedirectResponse
    {
        $data = $request->validate([
            'weapon_id' => ['required', 'exists:weapons,id'],
            'weapon_number' => ['required', 'string', 'max:100', 'unique:weapon_inventories,weapon_number,' . $weaponInventory->id],
            'acquired_on' => ['nullable', 'date'],
            'status' => ['nullable', 'string', 'max:50'],
            'current_armory_id' => ['nullable', 'exists:armories,id'],
            'last_audited_at' => ['nullable', 'date'],
            'condition_notes' => ['nullable', 'string'],
        ]);

        $weaponInventory->update($data);

        return redirect()->route('weapons.inventory.index')->with('message', 'Weapon inventory updated.')->with('alert-type', 'success');
    }

    public function destroy(WeaponInventory $weaponInventory): RedirectResponse
    {
        $weaponInventory->delete();

        return redirect()->route('weapons.inventory.index')->with('message', 'Weapon inventory removed.')->with('alert-type', 'success');
    }
}
