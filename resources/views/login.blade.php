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
    <main style="display: flex; justify-content: center; margin: 8%;">
        <div class="card form-card">
            <h2 style="text-align: center; margin-bottom: 20px;">Login Administrator</h2>
            @if ($errors->any())
                <ul style="width: 100%; background: red; padding:10px">
                   @foreach ($errors->all() as $error)
                      <li>{($eerror)}</li>
                    @endforeach
                </ul>
            @endif

            {{-- munculin pemberitahuan gagal login --}}
            @if (Session::get('gagal'))
                <div style="width: 100%; background:red; padding:10px">
                    {{Session::get('gagal')}}
                </div>
            @endif
            <form action="{{route('auth')}}" method="POST">
                @csrf
                <div class="input-card">
                    <label for="">Email :</label>
                    <input type="text" name="email" id="email">
                </div>
                <div class="input-card">
                    <label for="">Password :</label>
                    <input type="password" name="password" id="password">
                </div>
                <button type="submit">Masuk</button>
                <a href="/" class="back-btn">Batal</a>
            </form>
        </div>
    </main>
</body>
</html>