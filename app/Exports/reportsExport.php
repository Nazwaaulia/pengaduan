<?php

namespace App\Exports;

use App\Models\Report;
use Maatwebsite\Excel\Concerns\FromCollection;

//untuk ngatur nama-nama column header di excelnya
use Maatwebsite\Excel\Concerns\WithHeadings;

//utk mengatur data yg dimunculkan tiap column di excelnya
use Maatwebsite\Excel\Concerns\WithMapping;

class reportsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */


    //ngambil data dr database diambil dr FromCOllection
    public function collection()
    {
        //bebas pke eloquent lain (where, all, dll)
        return Report::orderBy('created_at', 'DESC')->get();
    }

    //ngatur nama-nama column header : diambil dr WithHeadings
    public function headings():array
    {
        return[
            'ID',
            'NIK Pelapor',
            'Nama Pelapor',
            'No Telp Pelapor',
            'Tanggal Lapor',
            'Pengaduan',
            'Status Response',
            'Pesan Response',
        ];
    }

    //mengatur data yg d tampilkan per column di excelnya
    //seperti foreach, yg didalam kurung () sebagai as pada foreach. bebas apa aja, asal yg dpanggil di return sama
    public function map($data) : array
    {
        return[
            $data->id,
            $data->nik,
            $data->nama,
            $data->no_telp,
            \Carbon\Carbon::parse($data->created_at)->format('j F, Y'),
            $data->pengaduan,
            $data->response ? $data->response['status'] : '_',
            $data->response ? $data->response['pesan'] : '_',
        ];
    }

}
