<table>
    <thead>
        <tr>
            <th>No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Jabatan</th>
            <th>Jurusan</th>
            <th>Golongan</th>
            <th>No Telp</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        @foreach($data as $i => $v)
        <tr>
            <td>{{ $i+1 }}</td>
            <td>{{ $v->nik }}</td>
            <td>{{ $v->nama_staf }}</td>
            <td>{{ $v->jabatan }}</td>
            <td>{{ $v->jurusan }}</td>
            <td>{{ $v->golongan }}</td>
            <td>{{ $v->notelp }}</td>
            <td>{{ $v->role->role_name }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
