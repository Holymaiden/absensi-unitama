@foreach ($data as $key => $v )
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $v->mulai_cuti }}</td>
    <td>{{ $v->akhir_cuti }}</td>
    <td>{{ $v->alasan }}</td>
    <td>
        <span class="badge {{ $v->status == 'diterima' ? 'badge-success' : ($v->status=='ditolak' ? 'badge-danger' : 'badge-warning')}}">
            {{$v->status=='diterima' ? 'Diterima' : ($v->status=='ditolak' ? 'Ditolak' : 'Menunggu')}}
        </span>
    </td>
</tr>
@endforeach
