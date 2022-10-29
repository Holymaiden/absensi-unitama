<?php

namespace App\Helpers;

use App\Models\Cuti;
use App\Models\Kehadiran;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Session;

class Helper
{

    public static function title($value)
    {
        return Str::remove(' ', ucwords(Str::of($value)->replace('_', ' ')));
    }

    // get data icon
    public static function icon()
    {
        $data = [
            'flaticon-squares-1', 'flaticon-technology', 'flaticon-squares', 'flaticon-menu-1', 'flaticon-menu-2', 'flaticon-settings-1', 'flaticon-folder-1', 'flaticon-folder-2', 'flaticon-folder-3',
            'flaticon-users', 'flaticon-users-1',
        ];
        return $data;
    }


    // get head title tabel
    public static function head($param)
    {
        return ucwords(str_replace('-', ' ', $param));
    }

    // replace spasi
    public static function replace($param)
    {
        return str_replace(' ', '', $param);
    }

    // button create
    public static function btn_create($roles)
    {
        return '<a onclick="createForm()" class="">
                        <button class="btn btn-primary btn-rounded btn-sm">
                            <span class="btn-label">
                                <i class="fa fa-plus"></i>
                            </span>
                            Add New
                        </button>
                     </a>';
    }

    // get data from tabel
    public static function btn_action($id, $edit, $delete)
    {
        if ($edit) {
            $edit = '<a onclick="editForm(' . $id . ')" class="">
                        <button type="button" class="btn btn-icon btn-round btn-warning btn-sm">
                            <i class="fa fa-pencil-alt"></i>
                        </button>
            </a> ';
        }
        if ($delete) {
            $delete = ' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $id . '"
               title="Delete" class="deleteData">
                        <button type="button" class="btn btn-icon btn-round btn-danger btn-sm">
                            <i class="fa fa-trash-alt"></i>
                        </button>
            </a>';
        }
        return $edit . $delete;
    }

    // get cek menu
    public static function count_menu($param)
    {
        $data = \DB::table('user_menus')->where('role_id', $param)->get();
        return isset($data) ? $data->count() : null;
    }

    // cek data menu role user
    public static function get_data($param)
    {
        $data = DB::table($param)->get();
        return isset($data) ? $data : null;
    }

    // get hari
    public static function getHari($hari)
    {
        switch ($hari) {
            case "Sun":
                $hari = "Minggu";
                break;
            case "Mon":
                $hari = "Senin";
                break;
            case "Tue":
                $hari = "Selasa";
                break;
            case "Wed":
                $hari = "Rabu";
                break;
            case "Thu":
                $hari = "Kamis";
                break;
            case "Fri":
                $hari = "Jumat";
                break;
            case "Sat":
                $hari = "Sabtu";
                break;
        }
        return isset($hari) ? $hari : null;
    }

    public static function getDateIndo($tgl)
    {
        $tanggal = substr($tgl, 8, 2);
        $bulan = Helper::getBulan((int)substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        $tgl = $tanggal . " " . $bulan . " " . $tahun;
        if ($tgl != "--") {
            return $tanggal . " " . $bulan . " " . $tahun;
        }
    }
    public static function getDateIndo2($tgl)
    {
        $tanggal = substr($tgl, 8, 2);
        $bulan = Helper::getBulan((int)substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        $tgl = $tanggal . " " . $bulan . " " . $tahun;
        if ($tgl != "--") {
            return $bulan . " " . $tanggal . ", " . $tahun;
        }
    }

    public static function getBulan($bln)
    {
        if ($bln == 1)
            return "Januari";
        elseif ($bln == 2)
            return "Februari";
        elseif ($bln == 3)
            return "Maret";
        elseif ($bln == 4)
            return "April";
        elseif ($bln == 5)
            return "Mei";
        elseif ($bln == 6)
            return "Juni";
        elseif ($bln == 7)
            return "Juli";
        elseif ($bln == 8)
            return "Agustus";
        elseif ($bln == 9)
            return "September";
        elseif ($bln == 10)
            return "Oktober";
        elseif ($bln == 11)
            return "November";
        elseif ($bln == 12)
            return "Desember";
    }

    public static function arrayToString($param)
    {
        $data = null;
        foreach ($param as $v) {
            if ($data == null) {
                $data = $v;
            } else {
                $data = $data . "," . $v;
            }
        }
        return $data;
    }

    public static function getKehadiran()
    {
        return Kehadiran::where('created_at', '>=', Carbon::today())->limit(5)->get();
    }

    public static function getSisaCuti()
    {
        $data =  Cuti::where('user_id', Auth::user()->id)->where('status', 'diterima')->get();
        $batas = 14;
        $total = 0;
        foreach ($data as $v) {
            $total = Carbon::parse($v->akhir_cuti)->diffInDays(Carbon::parse($v->mulai_cuti)) + $total;
        }

        return $batas - $total;
    }

    public static function getKehadiranHariIni()
    {
        $data = Kehadiran::where('user_id', auth()->user()->id)->where('tanggal', '>=', Carbon::today())->first();
        $i = 0;
        if ($data) {
            if ($data['jam_masuk'] != null && $data['jam_keluar'] == null) {
                $i = 1;
            } else if ($data['jam_masuk'] != null && $data['jam_keluar'] != null) {
                $i = 2;
            }
        }
        return $i;
    }

    public static function CekCutiHariIni()
    {
        return Cuti::where('user_id', auth()->user()->id)->where('status', 'diterima')->where('mulai_cuti', '<=', Carbon::today())->where('akhir_cuti', '>=', Carbon::today())->count();
    }

    public static function cekCutiDiTerima()
    {
        return Cuti::where('user_id', auth()->user()->id)->where('status', 'diterima')->where('akhir_cuti', '>=', Carbon::today())->count();
    }

    public static function cekPanjangCuti($id)
    {
        $cuti = Cuti::where('id', $id)->where('status', 'diterima')->first();
        return Carbon::parse($cuti->akhir_cuti)->diffInDays(Carbon::parse($cuti->mulai_cuti));
    }
}
