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
                            <input type="text" class="form-control datepicker" name="mulai_cuti" value="" id="mulai_cuti">
                        </div>
                        <div class="form-group col-md-6">
                            <label>Akhir Cuti</label>
                            <input type="text" class="form-control datepicker" name="akhir_cuti" value="" id="akhir_cuti">
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
</script>
@endpush
