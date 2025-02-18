<?php
namespace App\Exports;
use App\Models\MasterProdi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class LaporanHasilKelulusanExport implements FromView
{
    use Exportable;
    public function __construct($data, $jalur){
        $this->data = $data;
        $this->jalur = $jalur;
    }
    public function view(): View
    {
        return view('excel.hasil-kelulusan', [
            'data' => $this->data,
            'jalur' => $this->jalur
        ]);
    }
}