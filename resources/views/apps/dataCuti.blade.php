@foreach ($data as $key => $v )
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $v->mulai_cuti }}</td>
    <td>{{ $v->akhir_cuti }}</td>
    <td>{{ $v->alasan }}</td>
    <td>
        <span class="badge {{ $v->status == 'diterima' || $v->status2 =='diterima' ? 'badge-success' : ($v->status=='ditolak' || $v->status2=='ditolak' ? 'badge-danger' : 'badge-warning')}}">
            @if($v->status=='diterima')
            @if($v->status2=='diterima')
            Diterima
            @elseif($v->status2=='ditolak')
            Ditolak Oleh Pimpinan
            @else
            Menunggu Persetujuan Pimpinan
            @endif
            @elseif($v->status=='ditolak')
            Ditolak Oleh Admin
            @else
            Menunggu Persetujuan Admin
            @endif
        </span>
    </td>
</tr>
@endforeach