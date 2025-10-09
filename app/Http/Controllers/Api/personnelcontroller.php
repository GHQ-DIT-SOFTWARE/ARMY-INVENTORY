<?php

declare (strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\Service;
use App\Models\rank;
use App\Models\Unit;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class personnelcontroller extends Controller
{
    protected array $rankMap = [
        'PTE' => ['PTE', 'PRIVATE'],
        'L/CPL' => ['L/CPL', 'LANCE CORPORAL'],
        'CPL' => ['CPL', 'CORPORAL'],
        'SGT' => ['SGT', 'SERGEANT'],
        'S/SGT' => ['S/SGT', 'STAFF SERGEANT'],
        'WO II' => ['WO II', 'WARRANT OFFICER II'],
        'WO I' => ['WO I', 'WARRANT OFFICER I'],
        'SWO II' => ['SWO II', 'SENIOR WARRANT OFFICER II'],
        'SWO I' => ['SWO I', 'SENIOR WARRANT OFFICER I'],
        'SUB LT' => ['SUB LT', 'SUB LIEUTENANT'],
        'LT' => ['LT', 'LIEUTENANT'],
        'CAPT' => ['CAPT', 'CAPTAIN'],
        'MAJ' => ['MAJ', 'MAJOR'],
        'LT COL' => ['LT COL', 'LIEUTENANT COLONEL'],
        'COL' => ['COL', 'COLONEL'],
        'BRIG GEN' => ['BRIG GEN', 'BRIGADIER GENERAL'],
        'MAJ GEN' => ['MAJ GEN', 'MAJOR GENERAL'],
        'LT GEN' => ['LT GEN', 'LIEUTENANT GENERAL'],
        'GEN' => ['GEN', 'GENERAL'],
        'FIELD MARSHAL' => ['FIELD MARSHAL'],
    ];

    protected array $serviceMap = [
        'ARMY' => ['ARMY'],
        'NAVY' => ['NAVY'],
        'AIRFORCE' => ['AIR FORCE', 'AIRFORCE'],
    ];

    protected function getRankAliasMap(): array
    {
        static $map = null;
        if ($map === null) {
            $map = [];
            foreach ($this->rankMap as $label => $aliases) {
                $map[strtoupper($label)] = $label;
                foreach ($aliases as $alias) {
                    $map[strtoupper($alias)] = $label;
                }
            }
        }

        return $map;
    }

    protected function getServiceAliasMap(): array
    {
        static $map = null;
        if ($map === null) {
            $map = [];
            foreach ($this->serviceMap as $label => $aliases) {
                $pretty = ucfirst(strtolower($label));
                $map[strtoupper($label)] = $pretty;
                foreach ($aliases as $alias) {
                    $map[strtoupper($alias)] = $pretty;
                }
            }
        }

        return $map;
    }

    protected function getRanks()
    {
        static $ranks = null;
        if ($ranks === null) {
            $ranks = rank::all();
        }

        return $ranks;
    }

    protected function getServices()
    {
        static $services = null;
        if ($services === null) {
            $services = Service::all();
        }

        return $services;
    }

    protected function resolveRankLabel(Personnel $record): string
    {
        $aliasMap = $this->getRankAliasMap();

        if ($record->relationLoaded('rank') && $record->rank && $record->rank->rank_name) {
            $key = strtoupper((string) $record->rank->rank_name);
            return $aliasMap[$key] ?? $record->rank->rank_name;
        }

        $value = $record->rank_id;
        if (! empty($value)) {
            if (is_numeric($value)) {
                $rank = $this->getRanks()->firstWhere('id', (int) $value);
                if ($rank) {
                    $key = strtoupper((string) $rank->rank_name);
                    return $aliasMap[$key] ?? $rank->rank_name;
                }
            }

            $key = strtoupper(trim((string) $value));
            if (isset($aliasMap[$key])) {
                return $aliasMap[$key];
            }
        }

        return '';
    }

    protected function resolveServiceLabel(Personnel $record): string
    {
        $aliasMap = $this->getServiceAliasMap();

        if ($record->relationLoaded('service') && $record->service && $record->service->arm_of_service) {
            $key = strtoupper((string) $record->service->arm_of_service);
            return $aliasMap[$key] ?? ucfirst(strtolower($record->service->arm_of_service));
        }

        $value = $record->arm_of_service;
        if (! empty($value)) {
            if (is_numeric($value)) {
                $service = $this->getServices()->firstWhere('id', (int) $value);
                if ($service) {
                    $key = strtoupper((string) $service->arm_of_service);
                    return $aliasMap[$key] ?? ucfirst(strtolower($service->arm_of_service));
                }
            }

            $key = strtoupper(trim((string) $value));
            if (isset($aliasMap[$key])) {
                return $aliasMap[$key];
            }

            return ucfirst(strtolower((string) $value));
        }

        return '';
    }

    // public function index(Request $request)
    // {
    //     $query = Personnel::query();
    //     $result = DataTables::of($query)
    //         ->addColumn('action', function ($record) {
    //             return '<a class="btn btn-primary btn-sm" href="' . route('personal-edit', $record->uuid) . '"><i class="feather icon-edit"></i></a>
    //                     <a class="btn btn-danger btn-sm" href="' . route('personal-delete', $record->uuid) . '" title="Delete Data" id="delete"><i class="feather icon-trash-2"></i></a>';
    //         })
    //         ->make(true);
    //     return $result;
    // }

    public function index(Request $request)
    {
        $query = Personnel::with(['rank', 'service']);

        $serviceCategories = collect((array) $request->input('service_categories'))
            ->filter();
        if ($serviceCategories->isNotEmpty()) {
            $query->whereIn('service_category', $serviceCategories->all());
        }

        $services = collect((array) $request->input('services'))->filter()->map(function ($value) {
            if (is_numeric($value)) {
                return (int) $value;
            }

            $key = strtoupper(trim((string) $value));
            $aliasMap = $this->getServiceAliasMap();
            $label = $aliasMap[$key] ?? null;
            $services = $this->getServices();

            if ($label) {
                $service = $services->first(function ($item) use ($label) {
                    return strtoupper((string) $item->arm_of_service) === strtoupper($label);
                });
                if ($service) {
                    return $service->id;
                }
            }

            $service = $services->first(function ($item) use ($key) {
                return strtoupper((string) $item->arm_of_service) === $key;
            });
            if ($service) {
                return $service->id;
            }

            $service = $services->first(function ($item) use ($key) {
                return str_contains(strtoupper((string) $item->arm_of_service), $key);
            });

            return $service?->id;
        })->filter()->unique();
        if ($services->isNotEmpty()) {
            $query->whereIn('arm_of_service', $services->all());
        }

        $genders = collect((array) $request->input('genders'))->filter();
        if ($genders->isNotEmpty()) {
            $query->whereIn('gender', $genders->all());
        }

        $ranks = collect((array) $request->input('ranks'))->filter()->map(function ($value) {
            if (is_numeric($value)) {
                return (int) $value;
            }

            $key = strtoupper(trim((string) $value));
            $aliasMap = $this->getRankAliasMap();
            $label = $aliasMap[$key] ?? null;
            $ranks = $this->getRanks();

            if ($label) {
                $rank = $ranks->first(function ($item) use ($label) {
                    return strtoupper((string) $item->rank_name) === strtoupper($label);
                });
                if ($rank) {
                    return $rank->id;
                }
            }

            $rank = $ranks->first(function ($item) use ($key) {
                return strtoupper((string) $item->rank_name) === $key;
            });
            if ($rank) {
                return $rank->id;
            }

            $rank = $ranks->first(function ($item) use ($key) {
                return str_contains(strtoupper((string) $item->rank_name), $key);
            });

            return $rank?->id;
        })->filter()->unique();
        if ($ranks->isNotEmpty()) {
            $query->whereIn('rank_id', $ranks->all());
        }

        $units = collect((array) $request->input('units'))->filter();
        if ($units->isNotEmpty()) {
            $unitNames = Unit::whereIn('id', $units->all())
                ->pluck('unit_name')
                ->map(function ($name) {
                    return strtoupper($name);
                })
                ->all();
            if (! empty($unitNames)) {
                $query->whereIn('unit_name', $unitNames);
            }
        }

        if ($request->filled('has_email')) {
            $hasEmail = filter_var($request->input('has_email'), FILTER_VALIDATE_BOOLEAN);
            $query->where(function ($innerQuery) use ($hasEmail) {
                if ($hasEmail) {
                    $innerQuery->whereNotNull('email')
                        ->where('email', '!=', '');
                } else {
                    $innerQuery->whereNull('email')
                        ->orWhere('email', '=', '');
                }
            });
        }

        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->input('created_from'));
        }

        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->input('created_to'));
        }

        if ($request->filled('search_term')) {
            $term = $request->input('search_term');
            $query->where(function ($innerQuery) use ($term) {
                $likeTerm = '%' . $term . '%';
                $innerQuery->where('svcnumber', 'like', $likeTerm)
                    ->orWhere('surname', 'like', $likeTerm)
                    ->orWhere('first_name', 'like', $likeTerm)
                    ->orWhere('othernames', 'like', $likeTerm)
                    ->orWhere('initial', 'like', $likeTerm)
                    ->orWhere('mobile_no', 'like', $likeTerm);
            });
        }

        $query->orderByRaw("FIELD(service_category, 'OFFICER') DESC")
            ->orderBy('service_category')
            ->orderBy('arm_of_service')
            ->orderBy('created_at', 'desc');

        return DataTables::of($query)
            ->addColumn('rank_label', function (Personnel $record) {
                return $this->resolveRankLabel($record);
            })
            ->addColumn('service_label', function (Personnel $record) {
                return $this->resolveServiceLabel($record);
            })
            ->addColumn('action', function ($record) {
                return '<a class="btn btn-primary btn-sm" href="' . route('personal-edit', $record->uuid) . '"><i class="feather icon-edit"></i></a>
                        <a class="btn btn-danger btn-sm" href="' . route('personal-delete', $record->uuid) . '" title="Delete Data" id="delete"><i class="feather icon-trash-2"></i></a>';
            })
            ->make(true);
    }
}
