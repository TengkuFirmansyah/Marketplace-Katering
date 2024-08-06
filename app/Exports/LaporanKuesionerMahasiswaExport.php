<?php
namespace App\Exports;
use App\Models\MasterProdi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class LaporanKuesionerMahasiswaExport implements FromView
{
    use Exportable;
    public function __construct($sumberInformasi, $kriteriaPt, $alasanMasuk, $tahun, $program){
        $this->sumberInformasi = $sumberInformasi;
        $this->kriteriaPt = $kriteriaPt;
        $this->alasanMasuk = $alasanMasuk;
        $this->tahun = $tahun;
        $this->program = $program;
    }
    public function view(): View
    {
        return view('excel.kuesioner-mahasiswa', [
            'sumberInformasi' => $this->sumberInformasi,
            'kriteriaPt' => $this->kriteriaPt,
            'alasanMasuk' => $this->alasanMasuk,
            'tahun' => $this->tahun,
            'program' => $this->program
        ]);
    }
}