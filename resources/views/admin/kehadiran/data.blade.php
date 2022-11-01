@foreach ($data as $key => $v )
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $v->user->nik }}</td>
    <td>{{ $v->status }}</td>
    <td>{{ $v->tanggal }}</td>
    <td>{{ $v->jam_masuk }}</td>
    <td>{{ $v->jam_keluar }}</td>
    <td>{{ $v->ket }}</td>
    <th>{{ Helper::getDistance($v->lat,$v->long) >= 50 ? 'Diluar Kampus' : 'Didalam Kampus' }}</th>
    <td>{{ $v->surat_sakit ? $v->surat_sakit : 'Tidak Ada' }}</td>
    <th><a onclick="absenForm({{ $v->lat }}, {{ $v->long }})" class="btn btn-primary btn-icon icon-left text-white"><i class="fas fa-eye"></i></a></th>
    <td>
        {!! Helper::btn_action($v->id, '1','1') !!}
    </td>
</tr>
@endforeach