@foreach ($data as $key => $v )
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $v->nik }}</td>
    <td>{{ $v->nama_staf }}</td>
    <td>{{ $v->jabatan }}</td>
    <td>{{ $v->jurusan }}</td>
    <td>{{ $v->golongan }}</td>
    <td>{{ $v->notelp }}</td>
    <td>{{ $v->role->role_name }}</td>
    <td><img class="mr-3 rounded" width="55" src="{{ url('public/public/uploads/karyawan') }}/{{$v->image}}" alt="{{ $v->nik }}"></td>
    <td>
        <span class="badge {{ $v->active == 1 ? 'badge-success' : 'badge-danger'}}">
            {{$v->active=='1' ? 'Active' : 'Inactive'}}
        </span>
    </td>
    <td>
        {!! Helper::btn_action($v->id, '1','1') !!}
    </td>
</tr>
@endforeach