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
    <td>
        @if ($v->surat_sakit)
        <a href="{{ url('public/public/uploads/izin')}}/{{$v->surat_sakit}}"><button class="btn btn-warning btn-icon icon-left"><i class="fas fa-eye"></i></button></a>
        @else
        Tidak Ada
        @endif
    </td>
    <th><a onclick="absenForm({{ $v->lat }}, {{ $v->long }})" class="btn btn-primary btn-icon icon-left text-white"><i class="fas fa-eye"></i></a></th>
    <td>
        {!! Helper::btn_action($v->id, '1','1') !!}
    </td>
</tr>
@endforeach