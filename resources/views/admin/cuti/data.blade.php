@foreach ($data as $key => $v )
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $v->user->nik }}</td>
    <td>{{ $v->mulai_cuti }}</td>
    <td>{{ $v->akhir_cuti }}</td>
    <td>{{ $v->alasan }}</td>
    <td>
        @if ($v->status=='pengajuan')
        <a ref="javascript:void(0)" data-toggle="tooltip" data-id="{{$v->id}}" title="Terima" class="terimaData">
            <button type="button" class="btn btn-icon btn-round btn-success btn-sm">
                <i class="fa fa-check"></i>
            </button>
        </a>
        <a ref="javascript:void(0)" data-toggle="tooltip" data-id="{{$v->id}}" title="Tolak" class="tolakData">
            <button type="button" class="btn btn-icon btn-round btn-danger btn-sm">
                <i class="fa fa-ban"></i>
            </button>
        </a>
        @else
        <span class="badge {{ $v->status == 'diterima' ? 'badge-success' : 'badge-danger'}}">
            {{$v->status=='diterima' ? 'Diterima' : 'Ditolak'}}
        </span>
        @endif
    </td>
    <td>
        @if ($v->status == 'diterima')
        <a href="{{route('cuti.printCuti',$v->id)}}"><button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button></a>
    </td>
    @endif
</tr>
@endforeach
