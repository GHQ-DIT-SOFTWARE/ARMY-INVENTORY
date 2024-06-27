<?php

namespace App\Imports;

use App\Models\Personnel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportPersonnel implements ToModel, WithChunkReading, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new Personnel([
            'svcnumber' => $row['svcnumber'],
            'rank_name' => $row['rank_name'],
            'personnel_name' => $row['personnel_name'],
            'unit_name' => $row['unit_name'],
        ]);
    }
    public function chunkSize(): int
    {
        return 1000;
    }
}
