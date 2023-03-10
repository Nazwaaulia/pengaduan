<?php

namespace App\Http\Controllers;

use App\Models\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;
use Excel;
use App\Exports\reportsExport;
use App\Models\Response;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // ASC ascending -> kecil ke besar
        // DESC descending -> besar ke kecil
        $reports = Report::orderBy('created_at', 'DESC')->simplePaginate(2);
        return view('index', compact('reports'));
    }

    public function petugas(Request $request)
    {
        $search = $request->search;
        // with = mengambil relasi (nama fungsi hasOne/hasMany/belongsTo di modelnya), ambil data dr relasi itu
        // data report mau dtampilin dgn data response jd pke with
        // desc = baru->lama
        $reports = Report::with('response')->where('nama', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'DESC')->get();
        return view('petugas', compact('reports'));
    }

    public function data(Request $request)
    //Request $request ditambahkan krn pd page data terdapat fitur search & akan mengambil teks yg d input di search
    {
        //ambil data yg d input dr form search ke input yg namenya d search
        $search = $request->search;

        //where: mencari data berdasarkn column nama
        //pake nama karena search nya berdasarkan nama
        //data d ambil merupakan data yg 'LIKE' (terdapat) teks yg d masukan ke input search
        //LIKE nyari data teks
        //contoh: input search: fem, maka nyari ke db yg column namany ada isi 'fem'
        // % didepan nyari data column name yg depannya 'fem'
        // % dbelakang nyari data yg ada 'fem'nya d belakang
        // % depan belakang, nyari depan belakang, ntah depan, tengah, atau belakang
        $reports = Report::with('response')->where('nama', 'LIKE', '%' . $search . '%')->orderBy('created_at', 'DESC')->get();
        return view('data', compact('reports'));
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }

    public function auth(Request $request)
    //Request $request utk mengambil data dr imputannya. data disimpen di csrf
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        //ambil data dan simpen d variable
        $user = $request->only('email', 'password');
        //simpen data ke auth pk Auth::attempt
        //cek proses penyimpanan ke auth berhasil ato g pke if else

        if (Auth::attempt($user)) {
            // nesting if, if bersarang, if dalam if
            // kalau data login udh masuk ke fitur Auth, dcek pke if-else
            // kalau data Auth rolenya admin maka ke route data
            // kalau data Auth rolenya petugas maka ke route petugas
            if (Auth::user()->role == 'admin') {
                return redirect('/data');
            }elseif (Auth::user()->role == 'petugas') {
                return redirect('/petugas');
            }
        }else {
            return redirect()->back()->with('gagal', 'Gagal login, coba lagi');
        }
        
    }

    public function createPDF()
    {
        // ambil data yg akan ditampilkan pada pdf, bisa juga dengan where atau eloquent lainnya dan jangan gunakan pagination
        // konvert ke array dengan toArray()
        // toArray() untuk mengubah objek jd array, krn pdfnya hanya bisa nerima $data (array)
        $data = Report::with('response')->get()->toArray(); 

        // kirim data yg diambil kepada view yg akan ditampilkan, kirim dengan inisial 
        // samain 'inisial' dgn $ di foreach 
        view()->share('reports',$data); 

        // panggil view blade yg akan dicetak pdf serta data yg akan digunakan
        $pdf = PDF::loadView('print', $data)->setPaper('a4','landscape');

        // download PDF file dengan nama tertentu
        return $pdf->download('data_keseluruhan.pdf');

    }

    public function printPDF($id)
    {
        $data = Report::with('response')->where('id', $id)->get()->toArray(); 
        view()->share('reports',$data); 
        $pdf = PDF::loadView('print', $data);
        return $pdf->download('data_pengaduan.pdf');
    }

    public function exportExcel()
    {
        //nama file yg akan d download
        $file_name = 'data-keseluruhan.xlsx';

        //memenaggil file reportsExport dan mendownloadny dgn nama spt $file_name
        return Excel::download(new reportsExport, $file_name);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request -> validate([
            'nik' => 'required',
            'nama' =>'required',
            'no_telp' =>'required|max:13',
            'pengaduan' =>'required|min:5',
            'foto'=>'required|image|mimes:jpg,jpeg,png,svg',
        ]);

        $image = $request->file('foto');
        $imgName = rand() . '.' . $image->extension();
        $path =public_path('assets/image/');
        $image->move($path,$imgName);

        Report::create([
            'nik' => $request->nik,
            'nama' => $request->nama,
            'no_telp' => $request->no_telp,
            'pengaduan' => $request->pengaduan,
            'foto' => $imgName,
        ]);
        return redirect()->back()->with('sucessAdd','Berhasil Menambahkan Data Baru!');
//halaman home sama tambah data sama, pakai back

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //cari data yg dmkst
        //firstOrFail untuk ambil data
        //kan pake where, klo misal datanya sesuai, diambil
        $data = Report::where('id', $id)->firstOrFail();

        //$data isinya -> nik smp foto dr pengaduan
        //bikin variable yg isinya ngarah ke file foto terkait
        //public_path nyari file d folder public yg namanya sama kek $data bagian foto
        $image = public_path('assets/image/'.$data['foto']);

        //dah nemu fotonya hpus pke unlink
        //cuma hapus foto
        unlink($image);
        
        //hapus data dr database 
        //hapus semua data dari database
        $data->delete();
        Response::where('lapor_id , $id')->delete();
        //balik k page sblmny
        return redirect()->back();
    }
}