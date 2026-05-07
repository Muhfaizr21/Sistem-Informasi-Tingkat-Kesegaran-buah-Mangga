<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataCuaca extends Model
{
    protected $table = 'data_cuaca';

    protected $fillable = [
        'kecamatan_id',
        'latitude',
        'longitude',
        'tanggal_prakiraan',
        'suhu_min',
        'suhu_max',
        'kelembaban',
        'curah_hujan_mm',
        'kecepatan_angin',
        'risiko_penyakit',
        'optimal_panen',
        'sumber_api',
        'diambil_pada',
    ];

    protected $casts = [
        'tanggal_prakiraan' => 'date',
        'diambil_pada' => 'datetime',
        'optimal_panen' => 'boolean',
    ];
}
