<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Response;

class Report extends Model
{
    use HasFactory;
    protected $fillable = [
        'nik',
        'nama',
        'no_telp',
        'pengaduan',
        'foto',
    ];

    // hasOne = one to one
    // table yg berperan sebagai PK
    // nama fungsi disamakan dgn nama model
    // nama fungsi == nama model FK
    public function response()
    {
        // ambil model dr report yg punya relasi one to one ke model response
        // klo nama tdk sesuai standard laravel, tambahin dbelakang class, 'id' (nama primary key), 'laporan_id' (foreign key)
        return $this->hasOne(Response::class);
    }
}
