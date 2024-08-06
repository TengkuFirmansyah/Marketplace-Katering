<?php
namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class JadwalTestExport implements FromView
{
    use Exportable;
    public function __construct($data){
        $this->data = $data;
    }
    public function view(): View
    {
        return view('template-excel.jadwal-test', [
            'data' => $this->data
        ]);
    }
}