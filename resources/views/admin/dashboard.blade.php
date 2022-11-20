@extends('admin._layouts.index')

@push('cssScript')
@include('admin._layouts.css.css')
@endpush

@push('dashboard')
active
@endpush

@section('content')


<section class="section">
    <div class="section-header">
        <h1>Dashboard</h1>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Karyawan</h4>
                    </div>
                    <div class="card-body">
                        {!! Helper::get_data('users')->where('active',1)->count() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Hadir Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        {!! Helper::get_data('kehadirans')->where('created_at', '>=', Carbon::today())->where('surat_sakit','')->count() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="far fa-file"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Sakit Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        {!! Helper::get_data('kehadirans')->where('created_at', '>=', Carbon::today())->where('surat_sakit','<>','')->count() !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-circle"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Total Cuti Hari Ini</h4>
                    </div>
                    <div class="card-body">
                        {!! Helper::get_data('cutis')->where('akhir_cuti', '>=', Carbon::today())->where(Carbon::today(),'<=','mulai_cuti')->where('status','diterima')->count() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Absen Hari Ini</h4>
                    <div class="card-header-action">
                        <a href="{{route('kehadiran')}}" class="btn btn-primary">Lihat Semua</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>NIK</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(Helper::getKehadiran() as $v)
                                <tr>
                                    <td>{{$v->user->nik}}</td>
                                    <td>{{$v->jam_masuk}}</td>
                                    <td>{{$v->jam_keluar}}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@push('jsScript')
@include('admin._layouts.js.js')
@endpush