<?php
namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class LaporanPerbandinganTahunLaluExport implements FromView
{
    use Exportable;
    public function __construct($data, $tahun, $tanggal, $pilihan, $dataprev, $periodeprev){
        $this->data = $data;
        $this->tahun = $tahun;
        $this->tanggal = $tanggal;
        $this->pilihan = $pilihan;
        $this->dataprev = $dataprev;
        $this->periodeprev = $periodeprev;
    }
    public function view(): View
    {
        if($this->periodeprev){
            return view('excel.perbandingan-tahun-lalu-new', [
                'data' => $this->data,
                'tahun' => $this->tahun,
                'tanggal' => $this->tanggal,
                'pilihan' => $this->pilihan,
                'dataprev' => $this->dataprev
            ]);
        }else{
            return view('excel.perbandingan-tahun-lalu', [
                'data' => $this->data,
                'tahun' => $this->tahun,
                'tanggal' => $this->tanggal,
                'pilihan' => $this->pilihan,
                'dataprev' => $this->dataprev
            ]);
        }
    }
}