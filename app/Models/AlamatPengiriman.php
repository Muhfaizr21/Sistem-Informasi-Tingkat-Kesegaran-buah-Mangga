<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatPengiriman extends Model
{
    use HasFactory;

    protected $table = 'alamat_pengiriman';

    protected $fillable = [
        'pembeli_id',
        'label',
        'nama_penerima',
        'no_telepon',
        'alamat_lengkap',
        'kecamatan_id',
        'kota',
        'kode_pos',
        'utama',
    ];

    protected $casts = [
        'utama' => 'boolean',
    ];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
}
