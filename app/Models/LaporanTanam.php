<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanTanam extends Model
{
    protected $table = 'laporan_tanam';

    protected $fillable = [
        'petani_id',
        'lahan_id',
        'tanggal_tanam',
        'jumlah_bibit',
        'varietas',
        'status',
        'catatan'
    ];
}
