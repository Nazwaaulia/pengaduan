<?php

namespace App\Http\Controllers;

use App\Models\Response;
use Illuminate\Http\Request;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function show(Response $response)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function edit($report_id)
    {
        //ambil data yang bakal di munculin data yanh di ambil data response yang report_id nya sama kaya $report_id nya sama kaya $report_id dari path dinamis {report_id}
        //kalao ada datanya di ambil satu/first()
        $report = Response::where('report_id', $report_id)->first();
        $reportId = $report_id;
        return view('response', compact('report', 'reportId'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $report_id)
    {
        $request->validate([
            'status'=> 'required',
            'pesan'=> 'required',
        ]);

        //upadteOrCreate()fungsinya untuk melakukan update data kalo emang di db responsemnya uda ada data yang punya report_id sama dengan $report_id sama dengan$report_id cari dari path dinamis kalau gada itu maka di create di create
        //array pertama acuan dari datanya
        //array ke dua data yang di kirim
        //kenapa pake update or create karen response ini kan kalo tadinyandak ada mau di tambahin tapi kalo ada mau
        Response::updateOrCreate(
            [
                'report_id' => $report_id,
            ],
            [
                'status' => $request->status,
                'pesan' => $request->pesan,
            ]
            );
            return redirect()->route('data-petugas')->with('responseSuccess', 'berhasil mengubah response!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Response  $response
     * @return \Illuminate\Http\Response
     */
    public function destroy(Response $response)
    {
        //
    }
}
