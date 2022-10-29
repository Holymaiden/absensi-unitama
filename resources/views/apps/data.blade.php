@foreach ($data as $key => $v )
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $v->tanggal }}</td>
    <td>{{ $v->jam_masuk }}</td>
    <td>{{ $v->jam_keluar }}</td>
    <td>{{ $v->status }}</td>
    <td>{{ $v->ket }}</td>
    <td>
        @if ($v->surat_sakit)
        <a href="{{ url('public/uploads/izin') }}/{{$v->surat_sakit}}"><button class="btn btn-warning btn-icon icon-left"><i class="fas fa-eye"></i> Lihat</button></a>
        @endif
    </td>
</tr>
@endforeach
