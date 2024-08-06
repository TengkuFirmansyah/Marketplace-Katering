<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class NpmMahasiswaExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'Code Pendaftaran',
            'Nama Camaba',
            'NPM',
        ];
    }
}
