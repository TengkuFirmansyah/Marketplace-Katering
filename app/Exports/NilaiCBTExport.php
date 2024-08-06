<?php
namespace App\Exports;
use App\Models\MasterProdi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class NilaiCBTExport implements FromView
{
    use Exportable;
    public function __construct(){
        
    }
    public function view(): View
    {
        return view('template-excel.nilai-cbt');
    }
}