<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RingkasanProduksi extends Model
{
    protected $table = 'ringkasan_produksi';
    protected $fillable = [
        'kecamatan_id',
        'tahun',
        'triwulan',
        'total_produksi_kuintal',
        'total_lahan_hektar',
        'total_petani_aktif',
        'rata_skor_kesegaran',
        'total_pesanan',
        'sumber_data',
        'diperbarui_pada',
    ];
}
