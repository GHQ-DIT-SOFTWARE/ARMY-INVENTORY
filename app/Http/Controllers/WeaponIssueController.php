<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Armory;
use App\Models\WeaponInventory;
use App\Models\WeaponIssueLog;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class WeaponIssueController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:weapons.issue')->only(['create', 'store']);
        $this->middleware('permission:weapons.return')->only(['returnForm', 'processReturn', 'search']);
        $this->middleware('permission:weapons.view')->only('track');
    }

    public function create(): View
    {
        $armories = Armory::orderBy('name')->pluck('name', 'id');
        $availableWeapons = WeaponInventory::with('weapon')
            ->where('status', 'in_store')
            ->orderBy('weapon_number')
            ->get();

        return view('weapons.issues.issue-form', compact('armories', 'availableWeapons'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'armory_id' => ['required', 'exists:armories,id'],
            'weapon_inventory_ids' => ['required', 'array'],
            'weapon_inventory_ids.*' => ['exists:weapon_inventories,id'],
            'expected_return_at' => ['nullable', 'date'],
            'issue_notes' => ['nullable', 'string'],
        ]);

        foreach ($data['weapon_inventory_ids'] as $inventoryId) {
            $inventory = WeaponInventory::findOrFail($inventoryId);
            $inventory->update([
                'status' => 'issued',
                'current_armory_id' => $data['armory_id'],
                'last_audited_at' => Carbon::now(),
            ]);

            WeaponIssueLog::create([
                'weapon_inventory_id' => $inventory->id,
                'armory_id' => $data['armory_id'],
                'issued_by' => Auth::id(),
                'issued_at' => Carbon::now(),
                'expected_return_at' => isset($data['expected_return_at']) ? Carbon::parse($data['expected_return_at']) : null,
                'status' => 'issued',
                'issue_notes' => $data['issue_notes'] ?? null,
            ]);
        }

        return redirect()->route('weapons.issues.create')->with('message', 'Weapons issued successfully.')->with('alert-type', 'success');
    }

    public function search(Request $request): JsonResponse
    {
        $term = trim((string) $request->get('q', ''));

        if ($term === '') {
            return response()->json([]);
        }

        $results = WeaponInventory::query()
            ->with(['weapon', 'armory', 'issueLogs' => function ($query) {
                $query->whereNull('returned_at')->latest('issued_at')->take(1);
            }])
            ->where('status', 'issued')
            ->where('weapon_number', 'like', $term . '%')
            ->orderBy('weapon_number')
            ->limit(10)
            ->get();

        $payload = $results->map(function (WeaponInventory $inventory) {
            $log = $inventory->issueLogs->first();
            $issuedAt = optional($log)->issued_at;

            return [
                'id' => $inventory->id,
                'weapon_number' => $inventory->weapon_number,
                'weapon_name' => optional($inventory->weapon)->name,
                'weapon_variant' => optional($inventory->weapon)->variant,
                'armory' => optional($inventory->armory)->name,
                'issued_at' => $issuedAt instanceof Carbon ? $issuedAt->format('d M Y H:i') : null,
            ];
        })->values();

        return response()->json($payload);
    }

    public function returnForm(): View
    {
        return view('weapons.issues.return-form');
    }

    public function processReturn(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'weapon_numbers' => ['required', 'string'],
            'return_notes' => ['nullable', 'string'],
        ]);

        $weaponNumbers = collect(preg_split('/[\s,\n]+/', $data['weapon_numbers'], -1, PREG_SPLIT_NO_EMPTY));
        $processed = 0;

        foreach ($weaponNumbers as $weaponNumber) {
            $inventory = WeaponInventory::where('weapon_number', $weaponNumber)->first();
            if (! $inventory) {
                continue;
            }

            $issueLog = $inventory->issueLogs()->whereNull('returned_at')->latest('issued_at')->first();
            if (! $issueLog) {
                continue;
            }

            $inventory->update([
                'status' => 'in_store',
                'last_audited_at' => Carbon::now(),
            ]);

            $issueLog->update([
                'returned_at' => Carbon::now(),
                'status' => 'returned',
                'return_notes' => $data['return_notes'] ?? null,
            ]);

            $processed++;
        }

        if ($processed === 0) {
            return redirect()->back()->with('message', 'No active issues matched the provided weapon numbers.')->with('alert-type', 'warning');
        }

        return redirect()->route('weapons.returns.form')->with('message', 'Return processed for ' . $processed . ' weapon(s).')->with('alert-type', 'success');
    }

    public function track(Request $request): View
    {
        $result = null;
        $search = $request->string('weapon_number')->toString();
        if ($search) {
            $result = WeaponInventory::with(['weapon', 'armory', 'issueLogs.armory', 'issueLogs.issuer'])
                ->where('weapon_number', $search)
                ->first();
        }

        return view('weapons.issues.track', compact('result', 'search'));
    }
}
