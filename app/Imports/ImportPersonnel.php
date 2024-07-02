<?php

namespace App\Imports;

use App\Models\Personnel;
use Illuminate\Support\Facades\Auth;
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
        // Check if all required fields are present and not empty
        if (
            empty($row['svcnumber']) || empty($row['surname']) || empty($row['first_name']) ||
            empty($row['othernames']) || empty($row['gender']) ||
            empty($row['arm_of_service']) || is_null($row['service_category'])
        ) {
            // Skip the row if any required field is missing or empty
            return null;
        }

        // Initialize variables
        $firstLetterFirstName = '';
        $firstLettersOthernames = '';

        // Calculate initials based on service_category
        if (!empty($row['first_name'])) {
            $firstLetterFirstName = substr($row['first_name'], 0, 1);
        }
        if (!empty($row['othernames'])) {
            $othernames = explode(' ', $row['othernames']);
            foreach ($othernames as $othername) {
                $firstLettersOthernames .= substr($othername, 0, 1);
            }
        }

        $initials = '';
        if ($row['service_category'] === 'OFFICER') {
            $initials = strtoupper($firstLetterFirstName . $firstLettersOthernames) . ' ' . strtoupper($row['surname']);
        } elseif ($row['service_category'] === 'SOLDIER') {
            $initials = strtoupper($row['surname']) . ' ' . strtoupper($firstLetterFirstName . $firstLettersOthernames);
        }

        // Adjust mobile number format if necessary
        if (!empty($row['mobile_no']) && strlen($row['mobile_no']) === 9 && is_numeric($row['mobile_no'])) {
            $row['mobile_no'] = '0' . $row['mobile_no'];
        }

        // Map gender values
        $mappedGender = '';
        if ($row['gender'] == 'MALE' || $row['gender'] == 'FEMALE') {
            $mappedGender = $row['gender'];
        } elseif ($row['gender'] == 'M') {
            $mappedGender = 'MALE';
        } elseif ($row['gender'] == 'F') {
            $mappedGender = 'FEMALE';
        } else {
            $mappedGender = $row['gender'];
        }

        // Set default email if not provided
        $row['email'] = $row['email'] ?? '';

        // Set arm_of_service based on the value
        $armOfService = 0; // Default value if not matched
        if (strtoupper($row['arm_of_service']) == 'ARMY') {
            $armOfService = 1;
        } elseif (strtoupper($row['arm_of_service']) == 'NAVY') {
            $armOfService = 2;
        } elseif (strtoupper($row['arm_of_service']) == 'AIRFORCE') {
            $armOfService = 3;
        }

        // Create Personnel object
        return new Personnel([
            'svcnumber' => $row['svcnumber'],
            'surname' => $row['surname'],
            'first_name' => $row['first_name'],
            'othernames' => $row['othernames'],
            'rank_id' => $row['rank_id'], // Ensure rank_id is provided in your data
            'initial' => $initials,
            'gender' => $mappedGender,
            'blood_group' => $row['blood_group'],
            'arm_of_service' => $armOfService,
            'mobile_no' => $row['mobile_no'],
            'email' => $row['email'],
            'service_category' => $row['service_category'],
            'created_at' => now(),
            'created_by' => Auth::user() ? Auth::user()->id : null,
        ]);
    }

    // public function model(array $row)
    // {
    //     return new Personnel([
    //         'svcnumber' => $row['svcnumber'],
    //         'rank_name' => $row['rank_name'],
    //         'personnel_name' => $row['personnel_name'],
    //         'unit_name' => $row['unit_name'],
    //     ]);
    // }
    public function chunkSize(): int
    {
        return 2000;
    }
}
