<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Permohonan Cuti</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
</head>

<body>
    <img src="data:image/png;base64,{{ $image }}" style="max-width: 500px;" alt="...">
    <table style="width:100%">
        <tr>
            <th colspan="4">SURAT PERMOHONAN CUTI</th>
        </tr>
        <tr>
            <td style="width:15%">NAMA</td>
            <td style="width:50%">: {{$data->user->nama_staf}}</td>
            <td style="width:17%" style='border-right:none;'>Izin cuti selama </td>
            <td style="width:18%" style='border-left:none;'>{{Helper::cekPanjangCuti($data->id)}} Hari Kerja</td>
        </tr>
        <tr>
            <td>NIK</td>
            <td>: {{$data->user->nik}}</td>
            <td style='border-right:none;'>Terhitung mulai tanggal</td>
            <td style='border-left:none;'>: {{$data->mulai_cuti}} s/d {{$data->akhir_cuti}}</td>
        </tr>
        <tr>
            <td>JABATAN</td>
            <td>: {{$data->user->jabatan}}</td>
            <td style='border-right:none;'>Alasan</td>
            <td style='border-left:none;'>: {{$data->alasan}}</td>
        </tr>
        <tr>
            <td>TTD Permohonan</td>
            <td style="height:100px">: </td>
            <td style='border-right:none;'>Tgl Permohonan</td>
            <td style='border-left:none;'>: {{$data->created_at}}</td>
        </tr>
        <tr>
            <td colspan="2" style="text-align: center;">YANG MEMBERI IZIN</td>
            <td colspan="2" style="text-align: center;">MENGETAHUI</td>
        </tr>
        <tr>
            <td>NAMA</td>
            <td>: Drs. Ratnawati, M.Si.</td>
            <td style='border-right:none;'>NAMA</td>
            <td style='border-left:none;'>: Dr. H. Askar Taliang, M.Si</td>
        </tr>
        <tr>
            <td>JABATAN</td>
            <td>: Wakil Rektor 2 Universitas Teknologi AKBA</td>
            <td style='border-right:none;'>JABATAN</td>
            <td style='border-left:none;'>: Rektor Universitas Teknologi AKBA</td>
        </tr>
        <tr>
            <td>TTD</td>
            <td style="height:100px">: </td>
            <td style='border-right:none;'>TTD</td>
            <td style='border-left:none;'>: </td>
        </tr>
        <tr>
            <td>TGL</td>
            <td>: </td>
            <td style='border-right:none;'>TGL</td>
            <td style='border-left:none;'>: </td>
        </tr>
        <tr>
            <th>KEPUTUSAN PERSONALIA</th>
            <td colspan="3">Cuti diberikan selama : {{Helper::cekPanjangCuti($data->id)}} Hari Kerja
                <br>
                Sisa Cuti tahunan : {{14 - Helper::cekPanjangCuti($data->id)}} Hari Kerja
            </td>
        </tr>
    </table>
</body>

</html>
