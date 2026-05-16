<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataLahanHistoris extends Model
{
    protected $table = 'data_lahan_historis';
    protected $fillable = ['kecamatan_id', 'tahun', 'luas_hektar'];

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
