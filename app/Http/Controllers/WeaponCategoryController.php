<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\WeaponCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WeaponCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:weapons.manage');
    }

    public function index(): View
    {
        $categories = WeaponCategory::with('category')->orderBy('name')->paginate(20);

        return view('weapons.categories.index', compact('categories'));
    }

    public function create(): View
    {
        $baseCategories = $this->baseCategoryOptions();

        return view('weapons.categories.form', compact('baseCategories'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'unit_scope' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['unit_scope'] = $data['unit_scope'] ?? 'G4';
        $data['is_active'] = $request->boolean('is_active', true);

        WeaponCategory::create($data);

        return redirect()->route('weapons.categories.index')->with('message', 'Weapon category created successfully.')->with('alert-type', 'success');
    }

    public function edit(WeaponCategory $weaponCategory): View
    {
        $baseCategories = $this->baseCategoryOptions();

        return view('weapons.categories.form', [
            'weaponCategory' => $weaponCategory,
            'baseCategories' => $baseCategories,
        ]);
    }

    public function update(Request $request, WeaponCategory $weaponCategory): RedirectResponse
    {
        $data = $request->validate([
            'category_id' => ['nullable', 'exists:categories,id'],
            'name' => ['required', 'string', 'max:255'],
            'unit_scope' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $data['unit_scope'] = $data['unit_scope'] ?? 'G4';
        $data['is_active'] = $request->boolean('is_active', true);

        $weaponCategory->update($data);

        return redirect()->route('weapons.categories.index')->with('message', 'Weapon category updated.')->with('alert-type', 'success');
    }

    public function destroy(WeaponCategory $weaponCategory): RedirectResponse
    {
        $weaponCategory->delete();

        return redirect()->route('weapons.categories.index')->with('message', 'Weapon category removed.')->with('alert-type', 'success');
    }
    private function baseCategoryOptions(): array
    {
        $names = ['ARTILLERY WEAPON', 'INFANTRY WEAPON'];

        $existing = Category::whereIn('category_name', $names)->get()->keyBy('category_name');

        foreach ($names as $name) {
            if (! isset($existing[$name])) {
                $existing[$name] = Category::create(['category_name' => $name]);
            }
        }

        return Category::whereIn('category_name', $names)
            ->orderBy('category_name')
            ->pluck('category_name', 'id')
            ->toArray();
    }
}
