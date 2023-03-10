<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaduan Masyarakat</title>
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
</head>
<body>
    <h2 class="title-table">Laporan Keluhan (Petugas)</h2>
<div style="display: flex; justify-content: center; margin-bottom: 30px">
    <a href="/logout" style="text-align: center">Logout</a> 
    <div style="margin: 0 10px"> | </div>
    <a href="/" style="text-align: center">Home</a>
</div>

    <div style="display: flex; justify-content: flex-end; align-items: center; padding: 0 30px">
        {{-- pakai method get karena untuk masuk ke halaman menggunakan ::get --}}
        <form action="" method="GET">
            <input type="text" name="search" placeholder="Cari berdasarkan nama">
            <button type="submit" class="btn-login" style="margin-top: -1px">Cari</button>
        </form>

        <a href="{{route('data')}}" style="margin-left: 10px; margin-top: -10px">Refresh</a>

        {{-- yg d panggil sm route itu ->name() --}}
    </div>


<div style="padding: 0 30px">
    <table>
        <thead>
        <tr>
            <th width="5%">No</th>
            <th>NIK</th>
            <th>Nama</th>
            <th>Telp</th>
            <th>Pengaduan</th>
            <th>Gambar</th>
            <th>Keadaaan Laporan</th>
            <th>Pesan</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($reports as $lapor)
            <tr>    
                <td>{{$no++}}</td>
                <td>{{$lapor['nik']}}</td>
                <td>{{$lapor['nama']}}</td>
                <td>{{$lapor['no_telp']}}</td>
                <td>{{$lapor['pengaduan']}}</td>
                <td>
                    <img src="{{asset('assets/image/'.$lapor->foto)}}" width="120">
                </td>
                <td>
                    {{-- cek apakah data report sdh berrelasi dgn data dr with('response') --}}
                    @if ($lapor->response)
                    {{-- kalau ada relasi tampilkan bagian status --}}
                        {{$lapor->response['keadaan']}}
                    @else
                    {{-- kalau tdk ada relasi tampilkan tanda --}}
                        -
                    @endif
                </td>
                <td>
                    {{-- cek apakah data report sdh berrelasi dgn data dr with('response') --}}
                    @if ($lapor->response)
                    {{-- kalau ada relasi tampilkan bagian status --}}
                        {{$lapor->response['pesan']}}
                    @else
                    {{-- kalau tdk ada relasi tampilkan tanda --}}
                        Tidak ada pesan
                    @endif
                </td>
                <td style="display: flex; justify-content: center;">
                    <a href="{{route('response.edit', $lapor->id)}}" class="back-btn">Kirim</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>