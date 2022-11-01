@extends('admin._layouts.index')

@push('cssScript')
@include('admin._layouts.css.css-table')
@endpush

@push('user-settings')
active
@endpush

@push($title)
active
@endpush

@section('content')

<section class="section">

    @component('_card.head')
    {{ $title }}
    @endcomponent

    <div class="section-body">

        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <h4></h4>
                        <div class="card-header-form">
                            <a href="{{ route('kehadiran.exportExcel') }}" class="">
                                <button class="btn btn-success btn-rounded btn-sm">
                                    <span class="btn-label">
                                        <i class="fa fa-archive"></i>
                                    </span>
                                    Export Excel
                                </button>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">

                        @include('_card.filter')

                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th width="8%">No</th>
                                        <th>Nik</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Jam Masuk</th>
                                        <th>Jam Keluar</th>
                                        <th>Ket</th>
                                        <th>Tempat</th>
                                        <th>Surat Sakit</th>
                                        <th>Riwayat Posisi</th>
                                        <th width="12%">Aksi</th>
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
    </div>

</section>

@include('admin.'.$title.'._form')
@include('admin.'.$title.'._formAbsen')

@endsection

@push('jsScript')
@include('admin._layouts.js.js-table')

@include('_card.show_and_paging')
@endpush