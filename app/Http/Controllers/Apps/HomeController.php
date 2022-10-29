<?php

namespace App\Http\Controllers\Apps;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Cuti;
use App\Models\Kehadiran;
use Illuminate\Http\Request;
use App\Services\Contracts\CutiContract;
use App\Services\Contracts\KehadiranContract;
use Carbon\Carbon;

class HomeController extends Controller
{

    protected $cutiContract, $kehadiranContract,  $response;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(CutiContract $cutiContract, KehadiranContract $kehadiranContract)
    {
        $this->kehadiranContract = $kehadiranContract;
        $this->cutiContract = $cutiContract;
        $this->middleware('auth');
        $this->response = [
            'code' => config('constants.HTTP.CODE.FAILED'),
            'message' => __('error.public')
        ];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('apps.dashboard');
    }

    public function data(Request $request)
    {
        try {
            $jml = $request->jml == '' ? config('constants.PAGINATION') : $request->jml;
            $data = Kehadiran::where('user_id', auth()->user()->id)->when($request->input('cari'), function ($query) use ($request) {
                $query->where('status', 'like', "%{$request->input('cari')}%")
                    ->orWhere("jam_masuk", "like", "%{$request->input('cari')}%")
                    ->orWhere("jam_keluar", "like", "%{$request->input('cari')}%");
            })
                ->orderBy('id', 'desc')
                ->paginate($jml);

            $view = view('apps.data', compact('data'))->with('i', ($request->input('page', 1) -
                1) * $jml)->render();
            return response()->json([
                "total_page" => $data->lastpage(),
                "total_data" => $data->total(),
                "html"       => $view,
            ]);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return response()->json($this->response);
        }
    }

    public function pengajuanCuti(Request $request)
    {
        try {
            $request['user_id'] = auth()->user()->id;
            $data = $this->cutiContract->store($request);
            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }

    public function dataCuti(Request $request)
    {
        try {
            $jml = $request->jml == '' ? config('constants.PAGINATION') : $request->jml;
            $data = Cuti::where('user_id', auth()->user()->id)->when($request->input('cari'), function ($query) use ($request) {
                $query->where('mulai_cuti', 'like', "%{$request->input('cari')}%")
                    ->orWhere("akhir_cuti", "like", "%{$request->input('cari')}%")
                    ->orWhere("alasan", "like", "%{$request->input('cari')}%");
            })
                ->orderBy('id', 'desc')
                ->paginate($jml);

            $view = view('apps.dataCuti', compact('data'))->with('i', ($request->input('page', 1) -
                1) * $jml)->render();
            return response()->json([
                "total_page" => $data->lastpage(),
                "total_data" => $data->total(),
                "html"       => $view,
            ]);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return response()->json($this->response);
        }
    }

    public function absensi(Request $request)
    {
        try {
            if (Helper::getKehadiranHariIni() == 0) {
                $request['user_id'] = auth()->user()->id;
                $request['tanggal'] = Carbon::now()->format('Y-m-d');
                $request['jam_masuk'] = Carbon::now()->format('H:i:s');
                $data = $this->kehadiranContract->store($request);
            } else {
                $absen = Kehadiran::where('user_id', auth()->user()->id)->where('tanggal', date('Y-m-d'))->first();
                $absen->jam_keluar = Carbon::now()->format('H:i:s');
                $absen->save();
                $data = [
                    'code' => config('constants.HTTP.CODE.SUCCESS'),
                    'message' => 'Berhasil Absen Keluar'
                ];
            }

            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }


    public function izinSakit(Request $request)
    {
        try {
            $absen = Kehadiran::where('user_id', auth()->user()->id)->where('tanggal', date('Y-m-d'))->first();
            if ($absen) {
                $absen->status = 'izin';
                $request['jam_keluar'] = Carbon::now()->format('H:i:s');
                $absen->surat_sakit = $this->kehadiranContract->izinSakitUpdate($request);
                $absen->save();
                $data = [
                    'code' => config('constants.HTTP.CODE.SUCCESS'),
                    'message' => 'Berhasil Mengajukan Izin'
                ];
            } else {
                $request['user_id'] = auth()->user()->id;
                $request['tanggal'] = Carbon::now()->format('Y-m-d');
                $request['jam_masuk'] = Carbon::now()->format('H:i:s');
                $request['jam_keluar'] = Carbon::now()->format('H:i:s');
                $data = $this->kehadiranContract->izinSakit($request);
            }
            return response()->json($data);
        } catch (\Exception $e) {
            $this->response['message'] = $e->getMessage() . ' in file :' . $e->getFile() . ' line: ' . $e->getLine();
            return view('errors.message', ['message' => $this->response]);
        }
    }
}
