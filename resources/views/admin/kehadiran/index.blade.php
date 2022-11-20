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

                        <div class="card-sub">
                            <div class="btn-toolbar justify-content-between">
                                <div class="form-row">
                                    <div class="form-group mr-2">
                                        <select class="form-control form-control-sm selectric" name="" id="jumlah">
                                            <option selected="selected">5</option>
                                            <option>10</option>
                                            <option>15</option>
                                            <option>25</option>
                                            <option>50</option>
                                            <option>100</option>
                                        </select>
                                    </div>
                                    <div class="form-group mr-4">
                                        <select class="form-control form-control-sm selectric" name="" id="statusFilter">
                                            <option value="" selected="selected">Status</option>
                                            <option value="Hadir">Hadir</option>
                                            <option value="Sakit">Sakit</option>
                                        </select>
                                    </div>
                                    <div class="mt-2">Mulai : </div>
                                    <div class="form-group ml-1 mr-2">
                                        <input type="text" class="form-control form-control datepicker" id="dateFilter" value="" placeholder="Tanggal Mulai">
                                    </div>
                                    <div class="mt-2">Akhir : </div>
                                    <div class="form-group ml-1">
                                        <input type="text" class="form-control form-control datepicker" id="dateFilter2" value="" placeholder="Tanggal Akhir">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="text" name="" placeholder="Search..." class="form-control" id="pencarian">
                                </div>
                            </div>
                        </div>

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

<script type="text/javascript">
    $(document).ready(function() {
        let urlx = "{{ $title }}";

        $("#pilihan").on('change', function(event) {
            let pilih = $('#pilihan').val();
            if (pilih == '0') {
                $('#option').show();
            } else {
                $('#option').hide();
            }
        });

        loadpage('', "{{config('constants.PAGINATION')}}", '', '', '');

        var $pagination = $('.twbs-pagination');
        var defaultOpts = {
            totalPages: 1,
            prev: '&#8672;',
            next: '&#8674;',
            first: '&#8676;',
            last: '&#8677;',
        };
        $pagination.twbsPagination(defaultOpts);

        function loaddata(page, cari, jml, status = '', date = '', date2 = '') {
            $.ajax({
                url: urlx + '/data',
                data: {
                    "page": page,
                    "cari": cari,
                    "jml": jml,
                    'status': status,
                    'date': date,
                    'date2': date2
                },
                type: "GET",
                datatype: "json",
                success: function(data) {
                    $(".datatabel").html(data.html);
                }
            });
        }

        function loadpage(cari, jml, status = '', date = '', date2 = '') {
            $.ajax({
                url: urlx + '/data',
                data: {
                    "cari": cari,
                    "jml": jml,
                    'status': status,
                    'date': date,
                    'date2': date2
                },
                type: "GET",
                datatype: "json",
                success: function(response) {
                    console.log(response);
                    if ($pagination.data("twbs-pagination")) {
                        $pagination.twbsPagination('destroy');
                        $(".datatabel").html('<tr><td colspan="8">Data not found</td></tr>');
                    }
                    $pagination.twbsPagination($.extend({}, defaultOpts, {
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
                            $('#contentx').text('Showing ' + to + ' to ' + end + ' of ' + response.total_data + ' entries');
                            loaddata(page, cari, jml, status, date, date2);
                        }

                    }));
                }
            });
        }

        $("#pencarian, #jumlah, #statusFilter, #dateFilter, #dateFilter2").on('keyup change', function(event) {
            let cari = $('#pencarian').val();
            let jml = $('#jumlah').val();
            let status = $('#statusFilter').val();
            let date = $('#dateFilter').val();
            let date2 = $('#dateFilter2').val();
            loadpage(cari, jml, status, date, date2);
        });

        // proses simpan
        $('#saveBtn').click(function(e) {
            e.preventDefault();
            $.ajax({
                data: $('#formInput').serialize(),
                url: "{{ route($title.'.store') }}",
                type: "POST",
                dataType: 'json',
                success: function(data) {
                    $('#formInput').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    loadpage('', "{{config('constants.PAGINATION')}}", '', '', '');
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

        // proses update
        $('#updateBtn').click(function(e) {
            let id = $('#formId').val();
            e.preventDefault();
            $.ajax({
                data: $('#formInput').serialize(),
                url: urlx + '/' + id,
                type: "PUT",
                dataType: 'json',
                success: function(data) {
                    $('#formInput').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    loadpage('', "{{config('constants.PAGINATION')}}", '', '', '');
                    iziToast.success({
                        title: 'Successfull,',
                        message: 'Update it data!',
                        position: 'topRight',
                        timeout: 1500
                    });
                },
                error: function(data) {
                    $('#formInput').trigger("reset");
                    $('#ajaxModel').modal('hide');
                    iziToast.error({
                        title: 'Failed.',
                        message: 'Update it data!',
                        position: 'topRight',
                        timeout: 1500
                    });
                }
            });
        });

        $('body').on('click', '.deleteData', function() {
            var id = $(this).data("id");
            swal({
                    title: 'Are you sure?',
                    text: 'You want to delete this data!',
                    icon: 'warning',
                    dangerMode: true,
                    buttons: {
                        confirm: {
                            text: 'Yes, delete it!',
                            className: 'btn btn-success'
                        },
                        cancel: {
                            visible: true,
                            className: 'btn btn-danger'
                        }
                    }
                })
                .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            type: "DELETE",
                            url: urlx + '/' + id,
                            success: function(data) {
                                loadpage('', "{{config('constants.PAGINATION')}}", '', '', '');
                                iziToast.success({
                                    title: 'Successfull.',
                                    message: 'Delete it data!',
                                    position: 'topRight',
                                    timeout: 1500
                                });
                            },
                            error: function(data) {
                                iziToast.error({
                                    title: 'Failed,',
                                    message: 'Delete it data!',
                                    position: 'topRight',
                                    timeout: 1500
                                });
                            }
                        });
                    } else {
                        swal.close();
                    }
                });
        });

    });
</script>
@endpush