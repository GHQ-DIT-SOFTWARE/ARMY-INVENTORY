<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PersonnelTemplateExport implements FromArray, WithHeadings
{
    public function headings(): array
    {
        return [
            'svcnumber',
            'surname',
            'first_name',
            'othernames',
            'rank',
            'arm_of_service',
            'service_category',
            'gender',
            'mobile_no',
            'email',
            'height',
            'virtual_mark',
            'unit_name',
        ];
    }

    public function array(): array
    {
        return [
            [
                '12345678',
                'Bloggs',
                'Joe',
                'Anthony',
                'PTE',
                'ARMY',
                'SOLDIER',
                'MALE',
                '0244000000',
                'joe.bloggs@example.test',
                '5.8',
                'SCAR LEFT ARM',
                '1 MECH BN',
            ],
        ];
    }
}
