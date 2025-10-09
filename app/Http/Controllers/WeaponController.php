<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Weapon;
use App\Models\WeaponCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class WeaponController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:weapons.view')->only('index');
        $this->middleware('permission:weapons.manage')->only(['create', 'store', 'edit', 'update']);
        $this->middleware('permission:weapons.delete')->only('destroy');
    }

    public function index(): View
    {
        $weapons = Weapon::with('category')->orderBy('name')->paginate(15);

        return view('weapons.platforms.index', compact('weapons'));
    }

    public function create(): View
    {
        $categories = WeaponCategory::where('is_active', true)->orderBy('name')->pluck('name', 'id');

        return view('weapons.platforms.form', [
            'categories' => $categories,
            'configurationOptions' => $this->configurationOptions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('weapons', 'public');
        }

        $data['configuration'] = $this->prepareConfigurationPayload($request);
        unset($data['configuration_items'], $data['configuration_custom']);

        Weapon::create($data);

        return redirect()->route('weapons.platforms.index')->with('message', 'Weapon created successfully.')->with('alert-type', 'success');
    }

    public function edit(Weapon $weapon): View
    {
        $categories = WeaponCategory::where('is_active', true)->orderBy('name')->pluck('name', 'id');

        return view('weapons.platforms.form', [
            'weapon' => $weapon,
            'categories' => $categories,
            'configurationOptions' => $this->configurationOptions(),
        ]);
    }

    public function update(Request $request, Weapon $weapon): RedirectResponse
    {
        $data = $this->validatedData($request, (int) $weapon->id);

        if ($request->hasFile('image')) {
            if ($weapon->image_path) {
                Storage::disk('public')->delete($weapon->image_path);
            }
            $data['image_path'] = $request->file('image')->store('weapons', 'public');
        }

        $data['configuration'] = $this->prepareConfigurationPayload($request);
        unset($data['configuration_items'], $data['configuration_custom']);

        $weapon->update($data);

        return redirect()->route('weapons.platforms.index')->with('message', 'Weapon updated successfully.')->with('alert-type', 'success');
    }

    public function destroy(Weapon $weapon): RedirectResponse
    {
        if ($weapon->image_path) {
            Storage::disk('public')->delete($weapon->image_path);
        }
        $weapon->delete();

        return redirect()->route('weapons.platforms.index')->with('message', 'Weapon removed.')->with('alert-type', 'success');
    }

    private function configurationOptions(): array
    {
        return [
            'Optical Sight',
            'Tripod Stand',
            'Bipod',
            'Sling',
            'Bayonet',
            'Laser Designator',
            'Weapon Light',
            'Night Vision Adapter',
            'Suppressor',
            'Under-Barrel Grenade Launcher',
        ];
    }

    private function validatedData(Request $request, int $weaponId = 0): array
    {
        return $request->validate([
            'weapon_category_id' => ['required', 'exists:weapon_categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'variant' => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'max:2048'],
            'caliber' => ['nullable', 'string', 'max:100'],
            'manufacturer' => ['nullable', 'string', 'max:255'],
            'country_of_origin' => ['nullable', 'string', 'max:255'],
            'barrel_length_mm' => ['nullable', 'numeric'],
            'overall_length_mm' => ['nullable', 'numeric'],
            'weight_kg' => ['nullable', 'numeric'],
            'muzzle_velocity_mps' => ['nullable', 'numeric'],
            'rate_of_fire_rpm' => ['nullable', 'numeric'],
            'effective_range_m' => ['nullable', 'numeric'],
            'maximum_range_m' => ['nullable', 'numeric'],
            'configuration_items' => ['nullable', 'array'],
            'configuration_items.*' => ['nullable', 'string', 'max:255'],
            'configuration_custom' => ['nullable', 'string', 'max:255'],
            'ammunition_types' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],
        ]);
    }

    private function prepareConfigurationPayload(Request $request): ?string
    {
        $selections = collect($request->input('configuration_items', []))
            ->map(fn ($value) => trim((string) $value))
            ->filter();

        $customInput = trim((string) $request->input('configuration_custom', ''));
        if ($customInput !== '') {
            $customValues = collect(preg_split('/[,;]+/', $customInput))
                ->map(fn ($value) => trim($value))
                ->filter();

            $selections = $selections->merge($customValues);
        }

        $unique = $selections->unique()->filter();

        if ($unique->isEmpty()) {
            return null;
        }

        return $unique->implode(', ');
    }
}
