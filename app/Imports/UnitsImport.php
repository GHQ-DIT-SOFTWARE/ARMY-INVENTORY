<?php

namespace App\Imports;

use App\Models\Unit;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Validator;
class UnitsImport implements ToModel, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $validator = Validator::make($row, [
            'unit_name' => 'required|string|max:255',
        ]);
        return new Unit([
            'unit_name' => trim($row['unit_name']),
        ]);
    }

    public function chunkSize(): int
    {
        return 1000;
    }
}
// php artisan make:import ImportUser --model=User
