<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lahan extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'lahan';

    protected $fillable = [
        'petani_id',
        'nama_lahan',
        'latitude',
        'longitude',
        'kecamatan_id',
        'desa',
        'luas_hektar',
        'jenis_mangga',
        'jumlah_pohon',
        'tahun_tanam',
        'status',
        'foto_lahan',
    ];

    protected $casts = [
        'foto_lahan' => 'json',
        'luas_hektar' => 'decimal:2',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function petani()
    {
        return $this->belongsTo(Petani::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
