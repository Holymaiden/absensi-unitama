<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Keterangan</th>
            <th>Status</th>
            <th>Tempat</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $v)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $v->user->nik }}</td>
            <td>{{ $v->tanggal }}</td>
            <td>{{ $v->jam_masuk }}</td>
            <td>{{ $v->jam_keluar }}</td>
            <td>{{ $v->ket }}</td>
            <td>{{ $v->status }}</td>
            <th>{{ Helper::getDistance($v->lat,$v->long) >= 50 ? 'Diluar Kampus' : 'Didalam Kampus' }}</th>
        </tr>
        @endforeach
    </tbody>
</table>