<?php

namespace App\Exports;

use App\Models\Kehadiran;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class KaryawanExport implements FromView
{

    public function view(): View
    {
        return view('admin.kehadiran.excel', [
            'data' => Kehadiran::all()
        ]);
    }
}
