<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KirimInformasiExport implements FromCollection, WithHeadings
{
    protected $data;

    public function __construct()
    {
    }

    public function collection()
    {
        return collect();
    }

    public function headings(): array
    {
        return [
            'No Whatsapp',
            'Nama',
        ];
    }
}
