@foreach ($data as $key => $v )
<tr>
    <td>{{ ++$i }}</td>
    <td>{{ $v->user->nik }}</td>
    <td>{{ $v->mulai_cuti }}</td>
    <td>{{ $v->akhir_cuti }}</td>
    <td>{{ $v->alasan }}</td>
    <td>
        @if (Auth::user()->role->role_name == 'admin')
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
        @elseif($v->status=='ditolak')
        <span class="badge badge-danger">
            Ditolak
        </span>
        @else
        @if($v->status2=='pengajuan')
        <span class="badge badge-warning">
            Menunggu Persetujuan Pempinan
        </span>
        @else
        <span class="badge {{ $v->status2 == 'diterima' ? 'badge-success' : 'badge-danger'}}">
            {{$v->status2=='diterima' ? 'Diterima' : 'Ditolak'}}
        </span>
        @endif
        @endif
        @elseif (Auth::user()->role->role_name == 'pimpinan')
        @if($v->status=='diterima')
        @if ($v->status2=='pengajuan')
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
        <span class="badge {{ $v->status2 == 'diterima' ? 'badge-success' : 'badge-danger'}}">
            {{$v->status2=='diterima' ? 'Diterima' : 'Ditolak'}}
        </span>
        @endif
        @elseif($v->status=='ditolak')
        <span class="badge badge-danger">
            Ditolak Oleh Admin
        </span>
        @else
        <span class="badge badge-warning">
            Menunggu Persetujuan Admin
        </span>
        @endif
        @endif
    </td>
    <td>
        @if ($v->status == 'diterima' && $v->status2 == 'diterima')
        <a href="{{route('cuti.printCuti',$v->id)}}"><button class="btn btn-warning btn-icon icon-left"><i class="fas fa-print"></i> Print</button></a>
    </td>
    @endif
</tr>
@endforeach