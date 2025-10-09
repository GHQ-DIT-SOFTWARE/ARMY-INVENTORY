<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Armory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ArmoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:armories.manage')->except('destroy');
        $this->middleware('permission:armories.delete')->only('destroy');
    }

    public function index(): View
    {
        $armories = Armory::orderBy('name')->paginate(15);

        return view('weapons.armories.index', compact('armories'));
    }

    public function create(): View
    {
        return view('weapons.armories.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:armories,code'],
            'location' => ['nullable', 'string', 'max:255'],
            'commanding_officer' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        Armory::create($data);

        return redirect()->route('weapons.armories.index')->with('message', 'Armory created successfully.')->with('alert-type', 'success');
    }

    public function edit(Armory $armory): View
    {
        return view('weapons.armories.form', compact('armory'));
    }

    public function update(Request $request, Armory $armory): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'code' => ['required', 'string', 'max:50', 'unique:armories,code,' . $armory->id],
            'location' => ['nullable', 'string', 'max:255'],
            'commanding_officer' => ['nullable', 'string', 'max:255'],
            'contact_number' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'notes' => ['nullable', 'string'],
        ]);

        $armory->update($data);

        return redirect()->route('weapons.armories.index')->with('message', 'Armory updated successfully.')->with('alert-type', 'success');
    }

    public function destroy(Armory $armory): RedirectResponse
    {
        $armory->delete();

        return redirect()->route('weapons.armories.index')->with('message', 'Armory removed.')->with('alert-type', 'success');
    }
}
