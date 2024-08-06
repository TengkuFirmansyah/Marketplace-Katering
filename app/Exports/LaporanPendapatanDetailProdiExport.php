<?php
namespace App\Exports;
use App\Models\MasterProdi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class LaporanPendapatanDetailProdiExport implements FromView
{
    use Exportable;
    public function __construct($data, $mahasiswa1, $mahasiswa8, $tahun){
        $this->data = $data;
        $this->mahasiswa1 = $mahasiswa1;
        $this->mahasiswa8 = $mahasiswa8;
        $this->tahun = $tahun;
    }
    public function view(): View
    {
        return view('excel.pendapatan-detail-prodi', [
            'data' => $this->data,
            'mahasiswa1' => $this->mahasiswa1,
            'mahasiswa8' => $this->mahasiswa8,
            'tahun' => $this->tahun
        ]);
    }
}