<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Report;

class Response extends Model
{
    use HasFactory;
    protected $fillable = [
        'report_id',
        'status',
        'pesan',
    ];

    // belongTo = disambungkan dgn table mana (PK nya ada dimana)
    // table yg berperan sbg FK
    // nama fungsi == nama model PK
    // klo table punya lebih dari 1 fk : tulis hasOne hasMany tulis di model yg utk membuatnya
    public function report()
    {
        // mau tipenya one to many/one to one tetep pke belongsTo
        // kembalikan model response yg nyambung dgn model report
        // klo nama tdk sesuai standard laravel, tambahin dbelakang class, 'id' (nama primary key), 'laporan_id' (foreign key)
        return $this->belongsTo(Report::class);
    }
}
