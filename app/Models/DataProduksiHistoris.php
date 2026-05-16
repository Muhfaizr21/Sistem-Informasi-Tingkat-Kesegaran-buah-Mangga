<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataProduksiHistoris extends Model
{
    protected $table = 'data_produksi_historis';
    protected $fillable = [
        'kecamatan_id', 
        'tahun', 
        'kuartal', 
        'produksi_kuintal', 
        'luas_hektar',
        'jenis_mangga', 
        'cuaca',
        'keberhasilan_panen'
    ];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
