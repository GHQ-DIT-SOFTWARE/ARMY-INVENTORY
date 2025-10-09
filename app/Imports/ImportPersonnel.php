<?php

namespace App\Imports;

use App\Models\Personnel;
use App\Models\Service;
use App\Models\Unit;
use App\Models\rank;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportPersonnel implements ToModel, WithChunkReading, WithHeadingRow
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
        'AIRFORCE' => ['AIRFORCE', 'AIR FORCE'],
    ];

    protected static ?array $rankCache = null;
    protected static ?array $serviceCache = null;
    protected static ?array $unitCache = null;

    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $svcNumber = trim((string) Arr::get($row, 'svcnumber', ''));
        $surname = trim((string) Arr::get($row, 'surname', ''));
        $firstName = trim((string) Arr::get($row, 'first_name', ''));

        if ($svcNumber === '' || $surname === '' || $firstName === '') {
            return null;
        }

        $otherNames = trim((string) Arr::get($row, 'othernames', ''));
        $serviceCategory = strtoupper(trim((string) Arr::get($row, 'service_category', '')));
        if ($serviceCategory === '') {
            $serviceCategory = 'SOLDIER';
        }

        $initials = $this->buildInitials($firstName, $otherNames, $surname, $serviceCategory);

        $mobile = $this->normaliseMobile(Arr::get($row, 'mobile_no'));
        $gender = $this->normaliseGender(Arr::get($row, 'gender'));
        $rankIdentifier = Arr::get($row, 'rank') ?? Arr::get($row, 'rank_id');
        $serviceIdentifier = Arr::get($row, 'arm_of_service') ?? Arr::get($row, 'service');
        $unitIdentifier = Arr::get($row, 'unit') ?? Arr::get($row, 'unit_name');

        $rankId = $this->resolveRankId($rankIdentifier);
        $serviceId = $this->resolveServiceId($serviceIdentifier);
        $unitAssignment = $this->resolveUnitAssignment($unitIdentifier);

        $payload = [
            'surname' => $surname,
            'first_name' => $firstName,
            'othernames' => $otherNames,
            'initial' => $initials,
            'gender' => $gender,
            'blood_group' => Arr::get($row, 'blood_group'),
            'mobile_no' => $mobile,
            'email' => Arr::get($row, 'email', ''),
            'service_category' => $serviceCategory,
            'created_by' => Auth::id(),
        ];

        if ($rankId !== null) {
            $payload['rank_id'] = $rankId;
        }

        if ($serviceId !== null) {
            $payload['arm_of_service'] = $serviceId;
        }

        if (! empty($unitAssignment['unit_id']) && Schema::hasColumn('personnels', 'unit_id')) {
            $payload['unit_id'] = $unitAssignment['unit_id'];
        }

        if (! empty($unitAssignment['unit_name']) && Schema::hasColumn('personnels', 'unit_name')) {
            $payload['unit_name'] = $unitAssignment['unit_name'];
        }

        if (Schema::hasColumn('personnels', 'height')) {
            $payload['height'] = Arr::get($row, 'height');
        }

        if (Schema::hasColumn('personnels', 'virtual_mark')) {
            $payload['virtual_mark'] = Arr::get($row, 'virtual_mark');
        }

        return Personnel::updateOrCreate(
            ['svcnumber' => $svcNumber],
            $payload
        );
    }

    protected function buildInitials(string $firstName, string $otherNames, string $surname, string $serviceCategory): string
    {
        $firstLetter = $firstName !== '' ? substr($firstName, 0, 1) : '';
        $otherLetters = '';

        if ($otherNames !== '') {
            $segments = preg_split('/\s+/', $otherNames) ?: [];
            foreach ($segments as $segment) {
                $segment = trim($segment);
                if ($segment !== '') {
                    $otherLetters .= substr($segment, 0, 1);
                }
            }
        }

        $base = strtoupper($firstLetter . $otherLetters);
        $surnameUpper = strtoupper($surname);

        if ($serviceCategory === 'OFFICER') {
            return trim($base . ' ' . $surnameUpper);
        }

        return trim($surnameUpper . ' ' . $base);
    }

    protected function normaliseMobile($value): ?string
    {
        if (! $value) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', (string) $value);
        if ($digits === '') {
            return null;
        }

        if (Str::startsWith($digits, '233') && strlen($digits) === 12) {
            return '0' . substr($digits, 3);
        }

        if (strlen($digits) === 9) {
            return '0' . $digits;
        }

        return $digits;
    }

    protected function normaliseGender($value): ?string
    {
        $value = strtoupper(trim((string) $value));
        return match ($value) {
            'M' => 'MALE',
            'F' => 'FEMALE',
            'MALE', 'FEMALE' => $value,
            default => $value !== '' ? $value : null,
        };
    }

    protected function resolveRankId($identifier): ?int
    {
        if ($identifier === null || $identifier === '') {
            return null;
        }

        if (is_numeric($identifier)) {
            return (int) $identifier;
        }

        $key = strtoupper(trim((string) $identifier));
        $aliases = $this->rankMap[$key] ?? [$key];

        foreach ($aliases as $alias) {
            $rank = $this->getRanks()->first(function ($item) use ($alias) {
                return strtoupper((string) $item->rank_name) === strtoupper($alias);
            });
            if ($rank) {
                return $rank->id;
            }
        }

        $fallback = $this->getRanks()->first(function ($item) use ($key) {
            return str_contains(strtoupper((string) $item->rank_name), $key);
        });
        if ($fallback) {
            return $fallback->id;
        }

        $rank = rank::firstOrCreate(
            ['rank_name' => $key],
            ['created_by' => Auth::id()]
        );
        self::$rankCache = null;

        return $rank->id;
    }

    protected function resolveServiceId($identifier): ?int
    {
        if ($identifier === null || $identifier === '') {
            return null;
        }

        if (is_numeric($identifier)) {
            return (int) $identifier;
        }

        $key = strtoupper(trim((string) $identifier));
        $aliases = $this->serviceMap[$key] ?? [$key];

        foreach ($aliases as $alias) {
            $service = $this->getServices()->first(function ($item) use ($alias) {
                return strtoupper((string) $item->arm_of_service) === strtoupper($alias);
            });
            if ($service) {
                return $service->id;
            }
        }

        $service = $this->getServices()->first(function ($item) use ($key) {
            return str_contains(strtoupper((string) $item->arm_of_service), $key);
        });

        if ($service) {
            return $service->id;
        }

        $service = Service::firstOrCreate(
            ['arm_of_service' => $key],
            ['created_by' => Auth::id()]
        );
        self::$serviceCache = null;

        return $service->id;
    }

    protected function resolveUnitAssignment($identifier): array
    {
        $result = [
            'unit_id' => null,
            'unit_name' => null,
        ];

        if ($identifier === null || $identifier === '') {
            return $result;
        }

        if (is_numeric($identifier)) {
            $unit = $this->getUnits()->firstWhere('id', (int) $identifier);
            if ($unit) {
                $result['unit_id'] = $unit->id;
                $result['unit_name'] = $unit->unit_name;
            }

            return $result;
        }

        $key = strtoupper(trim((string) $identifier));
        $unit = $this->getUnits()->first(function ($item) use ($key) {
            return strtoupper((string) $item->unit_name) === $key;
        }) ?: $this->getUnits()->first(function ($item) use ($key) {
            return str_contains(strtoupper((string) $item->unit_name), $key);
        });

        if ($unit) {
            $result['unit_id'] = $unit->id;
            $result['unit_name'] = $unit->unit_name;
        } else {
            $result['unit_name'] = $identifier;
        }

        return $result;
    }

    protected function getRanks()
    {
        if (self::$rankCache === null) {
            self::$rankCache = rank::all();
        }

        return self::$rankCache;
    }

    protected function getServices()
    {
        if (self::$serviceCache === null) {
            self::$serviceCache = Service::all();
        }

        return self::$serviceCache;
    }

    protected function getUnits()
    {
        if (self::$unitCache === null) {
            self::$unitCache = Unit::all();
        }

        return self::$unitCache;
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
