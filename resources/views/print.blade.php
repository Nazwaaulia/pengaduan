<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cetak Data Pengaduan</title>
</head>
    <body>
        <h2 style="text-align: center; margin-bottom: 20px;">Data Keseluruhan Pengaduan</h2>
        <table style="width: 100%">
            <tr>
                <th>No</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>No. Telp</th>
                <th>Waktu</th>
                <th>Pengaduan</th>
                <th>Gambar</th>
                <th>Status response</th>
                <th>Pesan response</th>
            </tr>

            @php
                $no = 1;
            @endphp

            @foreach ($reports as $lapor)
                <tr>
                    <td>{{$no++}}</td>
                    <td>{{$lapor['nik']}}</td>
                    <td>{{$lapor['nama']}}</td>
                    <td>{{$lapor['no_telp']}}</td>
                    <td>{{\Carbon\Carbon::parse($lapor['created_at'])->format('j F, Y')}}</td>
                    <td>{{$lapor['pengaduan']}}</td>
                    <td><img src="assets/image/{{$lapor['foto']}}" width="80"></td>
                    <td>{{$lapor['response']}}</td>
                    <td>
                    @if ($lapor['response'])
                        {{$lapor->response['keadaan']}}
                    @else
                        -
                    @endif
                </td>
                    @if ($lapor['response'])
                    {{-- kalau ada relasi tampilkan bagian status --}}
                        {{$lapor['response']['pesan']}}
                    @else
                    {{-- kalau tdk ada relasi tampilkan tanda --}}
                        Tidak ada pesan
                    @endif
                </td>
                </tr>
            @endforeach
        </table>
    </body>
</html>