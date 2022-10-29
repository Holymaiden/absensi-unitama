@foreach ($data as $key => $v )
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $v->user->nik }}</td>
    <td>{{ $v->status }}</td>
    <td>{{ $v->tanggal }}</td>
    <td>{{ $v->jam_masuk }}</td>
    <td>{{ $v->jam_keluar }}</td>
    <td>{{ $v->ket }}</td>
    <td>{{ $v->surat_sakit ? $v->surat_sakit : 'Tidak Ada' }}</td>
    <td>
        {!! Helper::btn_action($v->id, '1','1') !!}
    </td>
</tr>
@endforeach
