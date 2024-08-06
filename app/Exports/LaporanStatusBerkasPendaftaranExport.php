<?php
namespace App\Exports;
use App\Models\MasterProdi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class LaporanStatusBerkasPendaftaranExport implements FromView
{
    use Exportable;
    public function __construct($data, $tahun, $file){
        $this->data = $data;
        $this->tahun = $tahun;
        $this->file = $file;
    }
    public function view(): View
    {
        return view('excel.status-berkas-pendaftaran', [
            'data' => $this->data,
            'tahun' => $this->tahun,
            'file' => $this->file
        ]);
    }
}