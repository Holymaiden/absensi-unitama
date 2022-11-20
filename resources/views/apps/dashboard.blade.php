@extends('apps._layouts.index')

@push('cssScript')
@include('apps._layouts.css.css')
@include('apps._layouts.css.css-table')
@endpush

@section('content')


<section class="section">
    <div class="section-header">
        <h1>Selamat Datang {{ auth()->user()->nama_staf }}</h1>
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Absen</h4>
                    </div>
                    <div class="card-body mt-2">
                        @if (Helper::CekCutiHariIni()==1 )
                        <a onclick="" class="btn btn-primary text-white">Hari Ini Cuti</a>
                        @elseif(Helper::getKehadiranHariIni()==2)
                        <a onclick="" class="btn btn-primary text-white">Sudah Absen</a>
                        @else
                        <a onclick="absenForm()" class="btn btn-primary text-white">{{Helper::getKehadiranHariIni()==1 ? 'Keluar' : (Helper::getKehadiranHariIni()==0 ? 'Masuk' : 'Sudah Absen')}}</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="far fa-newspaper"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pengajuan Cuti</h4>
                    </div>
                    <div class="card-body mt-2">
                        <a onclick="cutiForm()" class="btn btn-danger text-white">Ajukan</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @if(Helper::cekCutiDiTerima()>=1)
    <div class="row mb-4">
        <div class="col-12">
            <button style="width:100%" type="button" class="btn btn-success btn-icon icon-left">
                <i class="fas fa-bell"></i> Cuti Anda Diterima <span class="badge badge-transparent"></span>
            </button>
        </div>
    </div>
    @endif
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Riwayat Absen</h4>
                    <div class="card-header-action">
                        <!-- <a href="{{route('kehadiran')}}" class="btn btn-primary">Lihat Semua</a> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Jam Masuk</th>
                                    <th>Jam Keluar</th>
                                    <th>Keterangan</th>
                                    <th>Status</th>
                                    <th>Dokument</th>
                                </tr>
                            </thead>
                            <tbody class="datatabel">
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="text-center">
                            <div id="contentx"></div>
                        </div>
                        <div class="text-center">
                            <ul class="pagination twbs-pagination">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4>Riwayat Cuti</h4>
                    <div class="card-header-action">
                        <!-- <a href="{{route('kehadiran')}}" class="btn btn-primary">Lihat Semua</a> -->
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Mulai Cuti</th>
                                    <th>Akhir Cuti</th>
                                    <th>Alasan</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody class="datatabel2">
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-between flex-wrap">
                        <div class="text-center">
                            <div id="contentx2"></div>
                        </div>
                        <div class="text-center">
                            <ul class="pagination twbs-pagination2">
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('apps._formCuti')
@include('apps._formAbsen')
@endsection

@push('jsScript')
@include('apps._layouts.js.js')
@include('apps._layouts.js.js-table')
<script type="text/javascript">

</script>
<script type="text/javascript">
    $(document).ready(function() {
        let urlx = "";
        loadpage2('', "{{ config('constants.PAGINATION') }}");
        var $pagination2 = $('.twbs-pagination2');
        var defaultOpts2 = {
            totalPages: 1,
            prev: '&#8672;',
            next: '&#8674;',
            first: '&#8676;',
            last: '&#8677;',
        };
        $pagination2.twbsPagination(defaultOpts2);

        function loaddata2(page, cari, jml) {
            $.ajax({
                url: urlx + '/dataCuti',
                data: {
                    "page": page,
                    "cari": cari,
                    "jml": jml
                },
                type: "GET",
                datatype: "json",
                success: function(data) {
                    console.log("anuuuu")
                    $(".datatabel2").html(data.html);
                }
            });
        }

        function loadpage2(cari, jml) {
            $.ajax({
                url: urlx + '/dataCuti',
                data: {
                    "cari": cari,
                    "jml": jml
                },
                type: "GET",
                datatype: "json",
                success: function(response) {
                    if ($pagination2.data("twbs-pagination")) {
                        $pagination2.twbsPagination('destroy');
                        $(".datatabel2").html('<tr><td colspan="8">Data not found</td></tr>');
                    }

                    $pagination2.twbsPagination($.extend({}, defaultOpts2, {
                        startPage: 1,
                        totalPages: response.total_page,
                        visiblePages: 8,
                        prev: '&#8672;',
                        next: '&#8674;',
                        first: '&#8676;',
                        last: '&#8677;',
                        onPageClick: function(event, page) {
                            if (page == 1) {
                                var to = 1;
                            } else {
                                var to = page * jml - (jml - 1);
                            }
                            if (page == response.total_page) {
                                var end = response.total_data;
                            } else {
                                var end = page * jml;
                            }
                            $('#contentx2').text('Showing ' + to + ' to ' + end +
                                ' of ' + response.total_data + ' entries');
                            loaddata2(page, cari, jml);
                        }
                    }));
                }
            });
        }

        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $.ajax({
                data: $('#formInput').serialize(),
                url: "{{route('home.pengajuanCuti')}}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#formInput').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    loaddata2('', "{{config('constants.PAGINATION')}}");
                    iziToast.success({
                        title: 'Successfull.',
                        message: 'Save it data!',
                        position: 'topRight',
                        timeout: 1500
                    });
                },
                error: function(data) {
                    console.log('Error:', data);
                    $('#formInput').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    iziToast.error({
                        title: 'Failed,',
                        message: 'Save it data!',
                        position: 'topRight',
                        timeout: 1500
                    });
                }
            });
        });
    });
</script>
@endpush