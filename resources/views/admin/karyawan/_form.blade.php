<div class="modal fade" id="ajaxModel" role="dialog" aria-labelledby="exampleModalSizeLg" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <form id="formInput" name="formInput" action="">
                @csrf
                <input type="hidden" name="id" id="formId">
                <input type="hidden" id="_method" name="_method" value="">
                <div class="modal-header">
                    <h5 class="modal-title"> <label id="headForm"></label> {{ Helper::head($title) }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Nik</label>
                            <input type="text" class="form-control" name="nik" id="nik" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Nama</label>
                            <input type="text" class="form-control" name="nama_staf" id="nama_staf" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Jabatan</label>
                            <input type="text" class="form-control" name="jabatan" id="jabatan" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Golongan</label>
                            <input type="text" class="form-control" name="golongan" id="golongan" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>No Telp</label>
                            <input type="text" class="form-control" name="notelp" id="notelp" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label>Password</label>
                            <input type="password" class="form-control" name="password" id="" required />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label>Role User</label>
                            <select class="form-control selectric" id="role_id" name="role_id" style="width:100%">
                                @foreach(Helper::get_data('roles') as $v)
                                <option value="{{$v->id}}">{{$v->role_name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label>Active</label>
                            <select class="form-control selectric" id="active" name="active" style="width:100%">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label>Image</label>
                            <input type="file" class="form-control" name="image" id="image" required />
                            <input type="hidden" name="image_old" id="image_old" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer bg-whitesmoke br">
                    <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-success" id="saveBtn" value="create">Save</button>
                    <button type="submit" class="btn btn-success" id="updateBtn" value="update">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('jsScriptAjax')
<script type="text/javascript">
    //Tampilkan form input
    function createForm() {
        $('#formInput').trigger("reset");
        $("#headForm").empty();
        $("#headForm").append("Form Input");
        $('#saveBtn').show();
        $('#updateBtn').hide();
        $('#formId').val('');
        $('#ajaxModel').modal('show');
        $('#_method').val('POST');
    }

    //Tampilkan form edit
    function editForm(id) {
        let urlx = "{{ $title }}"
        $.ajax({
            url: urlx + '/' + id + '/edit',
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                $("#headForm").empty();
                $("#headForm").append("Form Edit");
                $('#formInput').trigger("reset");
                $('#ajaxModel').modal('show');
                $('#saveBtn').hide();
                $('#updateBtn').show();
                $('#formId').val(data.id);
                $('#nik').val(data.nik);
                $('#nama_staf').val(data.nama_staf);
                $('#jabatan').val(data.jabatan);
                $('#golongan').val(data.golongan);
                $('#notelp').val(data.notelp);
                $('#role_id').val(data.role_id).trigger('change');
                $('#active').val(data.active).trigger('change');
                $('#image_old').val(data.image);
                $('#_method').val('PUT');
            },
            error: function() {
                iziToast.error({
                    title: 'Failed,',
                    message: 'Unable to display data!',
                    position: 'topRight'
                });
            }
        });
    }
</script>
@endpush
