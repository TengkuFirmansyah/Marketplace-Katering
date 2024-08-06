<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\BeforeExport;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\DataValidation;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class KonfirmasiKelulusanExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithEvents
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function headings(): array
    {
        return [
            'Code Pendaftaran',
            'Nama Camaba',
            'Keterangan',
            'Beasiswa',
        ];
    }

    public function map($row): array
    {
        return [
            $row->code,
            $row->mahasiswa->nama,
            $row->keterangan,
            $row->beasiswa,
        ];
    }
    public function registerEvents(): array
    {
        return [
            // handle by a closure.
            AfterSheet::class => function(AfterSheet $event) {

                // get layout counts (add 1 to rows for heading row)
                $row_count = $this->data->count() + 1;
                $column_count = count($this->data[0]->toArray());

                // set dropdown column
                $drop_column = 'C';
                $drop_column1 = 'D';

                // set dropdown options
                $options = [
                    'Waiting',
                    'Menunggu Hasil Seleksi',
                    'Diterima',
                    'Cadangan',
                    'Tidak Diterima',
                ];
                $options1 = [
                    'Tidak',
                    'Penuh 8 Semester',
                    'Diterima Beasiswa KIP Kuliah',
                    'Potongan 100% Semester 1',
                    'Potongan 50% Semester 1',
                    'Tidak Diterima Jalur Beasiswa (Ditawarkan Jalur Reguler)',
                    'Diterima Jalur Reguler (Non Beasiswa)',
                ];

                // set dropdown list for first data row
                $validation = $event->sheet->getCell("{$drop_column}2")->getDataValidation();
                $validation->setType(DataValidation::TYPE_LIST );
                $validation->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $validation->setAllowBlank(false);
                $validation->setShowInputMessage(true);
                $validation->setShowErrorMessage(true);
                $validation->setShowDropDown(true);
                $validation->setErrorTitle('Input error');
                $validation->setError('Value is not in list.');
                $validation->setPromptTitle('Pick from list');
                $validation->setPrompt('Please pick a value from the drop-down list.');
                $validation->setFormula1(sprintf('"%s"',implode(',',$options)));

                // clone validation to remaining rows
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$drop_column}{$i}")->setDataValidation(clone $validation);
                }

                // set columns to autosize
                for ($i = 1; $i <= $column_count; $i++) {
                    $column = Coordinate::stringFromColumnIndex($i);
                    $event->sheet->getColumnDimension($column)->setAutoSize(true);
                }

                // set dropdown list for first data row
                $validation1 = $event->sheet->getCell("{$drop_column1}2")->getDataValidation();
                $validation1->setType(DataValidation::TYPE_LIST );
                $validation1->setErrorStyle(DataValidation::STYLE_INFORMATION );
                $validation1->setAllowBlank(false);
                $validation1->setShowInputMessage(true);
                $validation1->setShowErrorMessage(true);
                $validation1->setShowDropDown(true);
                $validation1->setErrorTitle('Input error');
                $validation1->setError('Value is not in list.');
                $validation1->setPromptTitle('Pick from list');
                $validation1->setPrompt('Please pick a value from the drop-down list.');
                $validation1->setFormula1(sprintf('"%s"',implode(',',$options1)));

                // clone validation to remaining rows
                for ($i = 3; $i <= $row_count; $i++) {
                    $event->sheet->getCell("{$drop_column1}{$i}")->setDataValidation(clone $validation1);
                }

                // set columns to autosize
                for ($i = 1; $i <= $column_count; $i++) {
                    $column1 = Coordinate::stringFromColumnIndex($i);
                    $event->sheet->getColumnDimension($column1)->setAutoSize(true);
                }
            },
        ];
    }
}
