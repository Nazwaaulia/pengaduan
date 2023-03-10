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
    <h2 class="title-table">Laporan Keluhan</h2>
<div style="display: flex; justify-content: center; margin-bottom: 30px">
    <a href="/logout" style="text-align: center">Logout</a> 
    <div style="margin: 0 10px"> | </div>
    <a href="/" style="text-align: center">Home</a>
    <div style="margin: 0 10px"> | </div>
    <a href="{{route('export-pdf')}}">Cetak PDF</a>
    <div style="margin: 0 10px"> | </div>
    <a href="{{route('export-excel')}}">Cetak Excel</a>
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
            <th>Status Response</th>
            <th>Pesan Response</th>
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
                @php
                    // substr_replace = mengubah karakter string
                    // punya 3 argumen:
                    // argumen 1 = data yg mau d masukin ke string
                    // argumen 2 = mulai dr index mana ubahnya
                    // argumen 3 = sampai index mana diubahnya
                    $telp = substr_replace($lapor->no_telp, "62", 0, 1)
                @endphp

                {{-- yg  dtampilkan tag a dalam $telp (data no_telp) sudah d ubah menjadi format 628 --}}
                {{-- %20 untuk spasi --}}
                {{-- target="_blank" untuk membuka halaman baru --}}
                @php
                //kalau uda di response data report nya, chat wa nya data dari response di tampilin
                if ($lapor->response) {
                $pesanWA = 'Hallo ' . $lapor->nama . '! pengaduan anda di ' . $lapor->response['keadaan'] . '. Berikut pesan untuk anda : ' . $lapor->response['pesan'];
                }
                //kalu belum di response pengaduan,chat wa nya kaya gini
                else {
                    $pesanWA = 'Belum ada data response!';
                }
                @endphp
                <td><a href="https://wa.me/{{$telp}}?text={{$pesanWA}}" target="_blank">{{$telp}}</a></td>
                <td><a href="https://wa.me/{{$telp}}/?text=Hallo!%20Saudara/i%20{{$lapor->nama}},%20pengaduan%20anda%20akan%20kami%20proses" target="_blank">{{$telp}}</a></td>
                <td>{{$lapor['pengaduan']}}</td>
                <td>
                    {{-- menampilkan gambar full screen di tab baru --}}
                    <a href="../assets/image/{{$lapor->foto}}" target="_blank">
                        <img src="{{asset('assets/image/'.$lapor->foto)}}" width="120">
                    </a>
                </td>
                <td>
                    @if ($lapor->response)
                        {{$lapor->response['keadaan']}}
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if ($lapor->response)
                    {{-- kalau ada relasi tampilkan bagian status --}}
                        {{$lapor->response['pesan']}}
                    @else
                    {{-- kalau tdk ada relasi tampilkan tanda --}}
                        Tidak ada pesan
                    @endif
                </td>
                <td style="display: flex; justify-content: center;">
                    <form action="{{route('destroy', $lapor->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-delete">Hapus</button>
                    </form>
                    <a href="{{route('print-pdf', $lapor->id)}}">Print</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</body>
</html>