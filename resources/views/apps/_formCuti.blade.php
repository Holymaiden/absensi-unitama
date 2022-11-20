<div class="modal fade" id="ajaxModel" role="dialog" aria-labelledby="exampleModalSizeLg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="formInput" name="formInput" action="">
                @csrf
                <input type="hidden" name="id" id="formId">
                <input type="hidden" id="_method" name="_method" value="">
                <div class="modal-header">
                    <h5 class="modal-title"> <label id="headForm"></label> Pengajuan Cuti </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Sisa Cuti : {{ Helper::getSisaCuti() }}</label>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Mulai Cuti</label>
                            <input type="text" class="form-control datepicker" value="2022-11-01" name="mulai_cuti" id="mulai_cuti">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Akhir Cuti</label>
                            <input type="text" class="form-control datepicker" value="2022-11-01" name="akhir_cuti" id="akhir_cuti">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Alasan</label>
                            <textarea class="form-control" name="alasan" id="alasan" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="saveBtn" value="create" {{ Helper::getSisaCuti() == 0 ? 'disabled' :'' }}>Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('jsScriptAjax')
<script type="text/javascript">

    function cutiForm() {
        $('#formInput').trigger("reset");
        $("#headForm").empty();
        $("#headForm").append("Form ");
        $('#saveBtn').show();
        $('#formId').val('');
        $('#ajaxModel').modal('show');
        $('#_method').val('POST');
    }

    $("#mulai_cuti").on("change", function() {
        var mulai_cuti = $(this).val();
        var akhir_cuti = $("#akhir_cuti").val();
        if (akhir_cuti != '') {
            if (mulai_cuti > akhir_cuti) {
                iziToast.error({
                    title: 'Failed,',
                    message: 'Tanggal Mulai Cuti Tidak Boleh Lebih Besar Dari Tanggal Akhir Cuti!',
                    position: 'topRight',
                    timeout: 1500
                });
                $("#mulai_cuti").val('');
            }
        }

        $.ajax({
            url: urlx + '/validateSunday',
            data: {
                "date": mulai_cuti,
            },
            type: "GET",
            datatype: "json",
            success: function(response) {
                console.log(response);
                if (response == true) {
                    iziToast.error({
                        title: 'Failed,',
                        message: 'Tidak Boleh Cuti Hari Minggu!',
                        position: 'topRight',
                        timeout: 1500
                    });
                    $("#mulai_cuti").val('');
                }

            }
        })
    });

    $("#akhir_cuti").on("change", function() {
        var akhir_cuti = $(this).val();
        var mulai_cuti = $("#mulai_cuti").val();
        if (mulai_cuti != '') {
            if (mulai_cuti > akhir_cuti) {
                iziToast.error({
                    title: 'Failed,',
                    message: 'Tanggal Akhir Cuti Tidak Boleh Lebih Kecil Dari Tanggal Mulai Cuti!',
                    position: 'topRight',
                    timeout: 1500
                });
                $("#akhir_cuti").val('');
            }
        }

        $.ajax({
            url: urlx + '/validateSunday',
            data: {
                "date": akhir_cuti,
            },
            type: "GET",
            datatype: "json",
            success: function(response) {
                if (response == true) {
                    iziToast.error({
                        title: 'Failed,',
                        message: 'Tidak Boleh Cuti Hari Minggu!',
                        position: 'topRight',
                        timeout: 1500
                    });
                    $("#akhir_cuti").val('');
                }
            }
        })
    });
</script>
@endpush