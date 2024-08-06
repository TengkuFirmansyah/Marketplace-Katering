<?php
namespace App\Exports;
use App\Models\MasterProdi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class LaporanJumlahPendaftaranExport implements FromView
{
    use Exportable;
    public function __construct($data, $tahun){
        $this->data = $data;
        $this->tahun = $tahun;
    }
    public function view(): View
    {
        return view('excel.jumlah-pendaftaran', [
            'data' => $this->data,
            'tahun' => $this->tahun
        ]);
    }
}