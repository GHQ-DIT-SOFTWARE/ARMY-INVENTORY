<?php

namespace App\Http\Controllers;

use App\Imports\ImportPersonnel;
use App\Exports\PersonnelTemplateExport;
use App\Models\Personnel;
use App\Models\rank;
use App\Models\Service;
use App\Models\Unit;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\Facades\DataTables;

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

    protected ?Collection $rankCache = null;
    protected ?Collection $serviceCache = null;

    public function __construct()
    {
        $this->middleware('auth');
    }

    protected function resolveRankId($identifier): ?int
    {
        if (empty($identifier)) {
            return null;
        }
        if (is_numeric($identifier)) {
            return (int) $identifier;
        }

        $key = strtoupper(trim((string) $identifier));
        $candidates = $this->rankMap[$key] ?? [$key];

        $ranks = $this->getRankCollection();

        foreach ($candidates as $candidate) {
            $rank = $ranks->get(strtoupper($candidate));
            if ($rank) {
                return $rank->id;
            }
        }

        $fallback = $ranks->first(function ($rank) use ($key) {
            return str_contains(strtoupper((string) $rank->rank_name), $key);
        });

        return $fallback?->id;
    }

    protected function resolveServiceId($identifier): ?int
    {
        if (empty($identifier)) {
            return null;
        }
        if (is_numeric($identifier)) {
            return (int) $identifier;
        }

        $key = strtoupper(trim((string) $identifier));
        $candidates = $this->serviceMap[$key] ?? [$key];

        $services = $this->getServiceCollection();

        foreach ($candidates as $candidate) {
            $service = $services->get(strtoupper($candidate));
            if ($service) {
                return $service->id;
            }
        }

        $fallback = $services->first(function ($service) use ($key) {
            return str_contains(strtoupper((string) $service->arm_of_service), $key);
        });

        return $fallback?->id;
    }

    protected function resolveOrCreateRankId($identifier): ?int
    {
        $resolved = $this->resolveRankId($identifier);
        if ($resolved !== null || $identifier === null || $identifier === '') {
            return $resolved;
        }

        $normalised = $this->normaliseReferenceValue($identifier);
        if ($normalised === null) {
            return null;
        }

        $rank = rank::firstOrCreate(
            ['rank_name' => $normalised],
            ['created_by' => Auth::id()]
        );

        $this->resetRankCache();

        return $rank->id;
    }

    protected function resolveOrCreateServiceId($identifier): ?int
    {
        $resolved = $this->resolveServiceId($identifier);
        if ($resolved !== null || $identifier === null || $identifier === '') {
            return $resolved;
        }

        $normalised = $this->normaliseReferenceValue($identifier);
        if ($normalised === null) {
            return null;
        }

        $service = Service::firstOrCreate(
            ['arm_of_service' => $normalised],
            ['created_by' => Auth::id()]
        );

        $this->resetServiceCache();

        return $service->id;
    }

    protected function normaliseReferenceValue($identifier): ?string
    {
        if (is_string($identifier)) {
            $value = trim($identifier);
            return $value === '' ? null : strtoupper($value);
        }

        if (is_numeric($identifier)) {
            return null;
        }

        return null;
    }

    protected function resetRankCache(): void
    {
        $this->rankCache = null;
    }

    protected function resetServiceCache(): void
    {
        $this->serviceCache = null;
    }

    protected function getRankOptions(): array
    {
        $options = [];
        foreach ($this->rankMap as $label => $aliases) {
            $id = $this->resolveOrCreateRankId($label);
            $options[] = [
                'label' => $label,
                'value' => $id ?? $label,
                'aliases' => array_unique(array_map('strtoupper', array_merge([$label], $aliases))),
            ];
        }

        return $options;
    }

    protected function getRankCollection(): Collection
    {
        if ($this->rankCache === null) {
            $this->rankCache = rank::all()->keyBy(function ($rank) {
                return strtoupper((string) $rank->rank_name);
            });
        }

        return $this->rankCache;
    }

    protected function getServiceCollection(): Collection
    {
        if ($this->serviceCache === null) {
            $this->serviceCache = Service::all()->keyBy(function ($service) {
                return strtoupper((string) $service->arm_of_service);
            });
        }

        return $this->serviceCache;
    }

    protected function getServiceOptions(): array
    {
        $options = [];
        foreach ($this->serviceMap as $key => $aliases) {
            $id = $this->resolveOrCreateServiceId($key);
            $label = ucfirst(strtolower($key));
            $options[] = [
                'label' => $label,
                'value' => $id ?? $key,
                'aliases' => array_unique(array_map('strtoupper', array_merge([$key], $aliases))),
            ];
        }

        return $options;
    }

    public function index(): View
    {
        $totals = [
            'all' => Personnel::count(),
            'officers' => Personnel::where('service_category', 'OFFICER')->count(),
            'otherRanks' => Personnel::where(function ($query) {
                $query->whereNull('service_category')
                    ->orWhere('service_category', '!=', 'OFFICER');
            })->count(),
            'withEmail' => Personnel::whereNotNull('email')
                ->where('email', '!=', '')
                ->count(),
        ];

        $serviceLookup = Service::orderBy('arm_of_service')->get()->keyBy('id');

        $hasUnitIdColumn = Schema::hasColumn('personnels', 'unit_id');
        $hasUnitNameColumn = Schema::hasColumn('personnels', 'unit_name');

        if ($hasUnitIdColumn) {
            $unitBreakdown = Personnel::leftJoin('units', 'units.id', '=', 'personnels.unit_id')
                ->selectRaw("COALESCE(units.unit_name, 'UNSPECIFIED') as label, COUNT(*) as value")
                ->groupByRaw("COALESCE(units.unit_name, 'UNSPECIFIED')")
                ->orderBy('label')
                ->get();
        } elseif ($hasUnitNameColumn) {
            $unitBreakdown = Personnel::selectRaw("COALESCE(unit_name, 'UNSPECIFIED') as label, COUNT(*) as value")
                ->groupByRaw("COALESCE(unit_name, 'UNSPECIFIED')")
                ->orderBy('label')
                ->get();
        } else {
            $unitBreakdown = collect([
                (object) [
                    'label' => 'UNSPECIFIED',
                    'value' => Personnel::count(),
                ],
            ]);
        }

        $unitBreakdown = $unitBreakdown->map(function ($row) {
            $label = trim((string) $row->label);
            $row->label = $label !== '' ? $label : 'UNSPECIFIED';
            return $row;
        });

        $genderBreakdown = Personnel::selectRaw('gender, COUNT(*) as value')
            ->groupBy('gender')
            ->orderBy('gender')
            ->get()
            ->map(function ($row) {
                $label = $row->gender ?? 'UNSPECIFIED';
                $label = strtoupper((string) $label);
                $row->label = $label === 'UNSPECIFIED' ? 'Unspecified' : ucfirst(strtolower($label));
                return $row;
            });

        $unitChartData = [
            'labels' => $unitBreakdown->pluck('label')->toArray(),
            'values' => $unitBreakdown->pluck('value')->toArray(),
        ];

        $genderChartData = [
            'labels' => $genderBreakdown->pluck('label')->toArray(),
            'values' => $genderBreakdown->pluck('value')->toArray(),
        ];

        $serviceCategories = Personnel::select('service_category')
            ->whereNotNull('service_category')
            ->distinct()
            ->orderBy('service_category')
            ->pluck('service_category');

        $rankOptions = $this->getRankOptions();
        $serviceOptions = $this->getServiceOptions();
        $units = Unit::orderBy('unit_name')->get();

        $recentlyAdded = Personnel::with(['rank', 'service'])
            ->latest()
            ->take(6)
            ->get();

        return view('personnel.index', compact(
            'totals',
            'serviceCategories',
            'rankOptions',
            'serviceOptions',
            'units',
            'recentlyAdded',
            'unitChartData',
            'genderChartData'
        ));
    }

    public function create()
    {
        $unit = Unit::all();
        $rankOptions = $this->getRankOptions();
        $serviceOptions = $this->getServiceOptions();

        return view('personnel.create', compact('unit', 'rankOptions', 'serviceOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'personnel_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
            'svcnumber' => ['required', 'unique:personnels,svcnumber'],
            'surname' => 'required',
            'othernames' => 'required',
            'mobile_no' => 'required|digits:10',
        ]);
        $save_url = null;
        if ($request->hasFile('personnel_image')) {
            $image = $request->file('personnel_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $manager = new ImageManager(new Driver());
            $img = $manager->read($image)->resize(200, 200);
            $img->save(public_path('upload/personnel/' . $name_gen));

            $save_url = 'upload/personnel/' . $name_gen;
        }
        $firstLetterFirstName = substr($request->first_name, 0, 1);
        $firstLettersOthernames = '';

        if (!empty($request->othernames)) {
            $othernames = explode(' ', $request->othernames);

            foreach ($othernames as $othername) {
                $firstLettersOthernames .= substr($othername, 0, 1);
            }
        }
        $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($request->surname);
        $personnelData = [
            'rank_id' => null,
            'arm_of_service' => null,
            'svcnumber' => $request->svcnumber,
            'surname' => $request->surname,
            'first_name' => $request->first_name,
            'othernames' => $request->othernames,
            'initial' => $initials,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'service_category' => $request->service_category,
            'personnel_image' => $save_url,
            'created_by' => Auth::user()->id,
            'created_at' => now(),
        ];

        if (Schema::hasColumn('personnels', 'height')) {
            $personnelData['height'] = $request->height;
        }

        if (Schema::hasColumn('personnels', 'virtual_mark')) {
            $personnelData['virtual_mark'] = $request->virtual_mark;
        }

        $rankId = $this->resolveOrCreateRankId($request->rank_id);
        $serviceId = $this->resolveOrCreateServiceId($request->arm_of_service);

        $unitIdentifier = $request->unit_id ?? $request->unit_name;
        $unitName = null;
        if (! empty($unitIdentifier)) {
            if (is_numeric($unitIdentifier)) {
                $unitModel = Unit::find($unitIdentifier);
                $unitName = optional($unitModel)->unit_name;
            } else {
                $unitName = $unitIdentifier;
                $unitModel = Unit::where('unit_name', $unitIdentifier)->first();
            }
            $unitIdentifier = optional($unitModel)->id ?? null;
            if (Schema::hasColumn('personnels', 'unit_id')) {
                $personnelData['unit_id'] = $unitIdentifier;
            }
        }

        $personnelData['rank_id'] = $rankId;
        $personnelData['arm_of_service'] = $serviceId;
        if (Schema::hasColumn('personnels', 'unit_name')) {
            $personnelData['unit_name'] = $unitName;
        }

        Personnel::create($personnelData);
        $notification = [
            'message' => 'Personnel Inserted Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('personal-view')->with($notification);
    }

    public function edit($uuid)
    {
        $personel = Personnel::where('uuid', $uuid)->first();
        if (!$personel) {
            abort(404);
        }
        $unit = Unit::all();
        $rankOptions = $this->getRankOptions();
        $serviceOptions = $this->getServiceOptions();
        return view('personnel.edit', compact('personel', 'unit', 'rankOptions', 'serviceOptions'));
    }

    public function update(Request $request)
    {
        $uuid = $request->uuid;
        // Calculate initials
        $firstLetterFirstName = substr($request->first_name, 0, 1);
        $firstLettersOthernames = '';
        if (!empty($request->othernames)) {
            $othernames = explode(' ', $request->othernames);

            foreach ($othernames as $othername) {
                $firstLettersOthernames .= substr($othername, 0, 1);
            }
        }
        $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($request->surname);
        // Prepare update data
        $rankId = $this->resolveOrCreateRankId($request->rank_id);
        $serviceId = $this->resolveOrCreateServiceId($request->arm_of_service);

        $unitIdentifier = $request->unit_id ?? $request->unit_name;
        $unitName = null;
        if (! empty($unitIdentifier)) {
            if (is_numeric($unitIdentifier)) {
                $unitModel = Unit::find($unitIdentifier);
                $unitName = optional($unitModel)->unit_name;
            } else {
                $unitName = $unitIdentifier;
                $unitModel = Unit::where('unit_name', $unitIdentifier)->first();
            }
            $unitIdentifier = optional($unitModel)->id ?? $unitIdentifier;
        }

        $updateData = [
            'rank_id' => $rankId,
            'arm_of_service' => $serviceId,
            'svcnumber' => $request->svcnumber,
            'surname' => $request->surname,
            'first_name' => $request->first_name,
            'othernames' => $request->othernames,
            'initial' => $initials,
            'mobile_no' => $request->mobile_no,
            'email' => $request->email,
            'gender' => $request->gender,
            'blood_group' => $request->blood_group,
            'service_category' => $request->service_category,
            'updated_by' => Auth::user()->id,
            'created_at' => Carbon::now(),
        ];

        if (Schema::hasColumn('personnels', 'unit_name') && $unitName !== null) {
            $updateData['unit_name'] = $unitName;
        }

        if (Schema::hasColumn('personnels', 'height')) {
            $updateData['height'] = $request->height;
        }

        if (Schema::hasColumn('personnels', 'virtual_mark')) {
            $updateData['virtual_mark'] = $request->virtual_mark;
        }
        // Check if a new image is uploaded
        if ($request->hasFile('personnel_image')) {
            $image = $request->file('personnel_image');
            $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();

            $manager = new ImageManager(new Driver());
            $img = $manager->read($image)->resize(200, 200);
            $img->save(public_path('upload/personnel/' . $name_gen));

            $save_url = 'upload/personnel/' . $name_gen;
            $updateData['personnel_image'] = $save_url;
        }
        $updateDat = Personnel::where('uuid', $uuid)->firstOrFail();
        // Retain existing image if no new image is uploaded
        if (!$request->hasFile('personnel_image')) {
            unset($updateData['personnel_image']);
        }
        $updateDat->update($updateData);
        $notification = [
            'message' => $request->hasFile('personnel_image')
            ? 'Personnel Updated with Image Successfully'
            : 'Personnel Updated Successfully',
            'alert-type' => 'success',
        ];
        return redirect()->route('personal-view')->with($notification);
    }

//     public function update(Request $request)
// {
//     $uuid = $request->uuid;

//     // Calculate initials
//     $firstLetterFirstName = substr($request->first_name, 0, 1);
//     $firstLettersOthernames = '';
//     if (!empty($request->othernames)) {
//         $othernames = explode(' ', $request->othernames);
//         foreach ($othernames as $othername) {
//             $firstLettersOthernames .= substr($othername, 0, 1);
//         }
//     }
//     $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($request->surname);

//     // Prepare update data for Personnel
//     $updateData = [
//         'unit_id' => $request->unit_id,
//         'rank_id' => $request->rank_id,
//         'arm_of_service' => $request->arm_of_service,
//         'svcnumber' => $request->svcnumber,
//         'surname' => $request->surname,
//         'first_name' => $request->first_name,
//         'othernames' => $request->othernames,
//         'initial' => $initials,
//         'mobile_no' => $request->mobile_no,
//         'email' => $request->email,
//         'gender' => $request->gender,
//         'height' => $request->height,
//         'virtual_mark' => $request->virtual_mark,
//         'service_category' => $request->service_category,
//         'updated_by' => Auth::user()->id,
//         'created_at' => Carbon::now(),
//     ];

//     // Check if a new image is uploaded
//     if ($request->hasFile('personnel_image')) {
//         $image = $request->file('personnel_image');
//         $name_gen = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
//         Image::make($image)->resize(200, 200)->save('upload/personnel/' . $name_gen);
//         $save_url = 'upload/personnel/' . $name_gen;
//         $updateData['personnel_image'] = $save_url;
//     }

//     // Update the Personnel record
//     $personnel = Personnel::where('uuid', $uuid)->firstOrFail();
//     $personnel->update($updateData);

//     // If the image is updated, update associated records in GafMissionRecord
//     if ($request->hasFile('personnel_image')) {
//         GafMissionRecord::where('svcnumber', $request->svcnumber)
//             ->update(['personnel_image' => $save_url]);
//     }

//     $notification = [
//         'message' => $request->hasFile('personnel_image')
//             ? 'Personnel Updated with Image Successfully'
//             : 'Personnel Updated Successfully',
//         'alert-type' => 'success',
//     ];
//     return redirect()->route('personal-view')->with($notification);
// }

    public function delete($uuid)
    {
        $personel = Personnel::where('uuid', $uuid)->first();
        if (!$personel) {
            abort(404);
        }
        $personel->delete();
        $notification = [
            'message' => 'Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,xls,xlsx',
        ]);
        Excel::import(new ImportPersonnel, $request->file('file'));
        $notification = [
            'message' => 'Imported Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }

    public function downloadSampleExcel()
    {
        return Excel::download(new PersonnelTemplateExport(), 'personnel-template.xlsx');
    }

    public function showSizeReport(): View
    {
        return view('personnel.size-report');
    }

    public function getSizeReportData(Request $request): JsonResponse
    {
        if (! $request->ajax()) {
            abort(404);
        }

        $query = Personnel::query()
            ->with(['rank', 'unit'])
            ->select('personnels.*');

        return DataTables::eloquent($query)->toJson();
    }

    public function showProfile($uuid): View
    {
        $personnel = Personnel::with(['rank', 'service', 'unit'])->where('uuid', $uuid)->firstOrFail();

        return view('personnel.profile', compact('personnel'));
    }
}
