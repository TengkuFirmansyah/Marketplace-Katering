<?php
namespace App\Exports;
use App\Models\MasterProdi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class LaporanUkuranAlmamaterExport implements FromView
{
    use Exportable;
    public function __construct($data, $tahun, $program){
        $this->data = $data;
        $this->tahun = $tahun;
        $this->program = $program;
    }
    public function view(): View
    {
        return view('excel.ukuran-almamater', [
            'data' => $this->data,
            'tahun' => $this->tahun,
            'program' => $this->program
        ]);
    }
}