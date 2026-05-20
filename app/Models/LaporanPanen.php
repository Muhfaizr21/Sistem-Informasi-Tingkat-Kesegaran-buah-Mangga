<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPanen extends Model
{
    protected $table = 'laporan_panen';

    protected $fillable = [
        'petani_id',
        'lahan_id',
        'tanggal_panen',
        'jumlah_kg',
        'luas_panen_hektar',
        'jenis_mangga',
        'kondisi_cuaca',
        'data_cuaca_id',
        'catatan',
        'foto_panen',
        'status',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    protected $casts = [
        'tanggal_panen' => 'date',
        'foto_panen' => 'json',
        'diverifikasi_pada' => 'datetime',
    ];

    public function petani()
    {
        return $this->belongsTo(Petani::class, 'petani_id');
    }

    public function lahan()
    {
        return $this->belongsTo(Lahan::class, 'lahan_id');
    }

    public function getKeberhasilanPanenAttribute()
    {
        $luas = $this->luas_panen_hektar ?? ($this->lahan->luas_hektar ?? 1.0);
        if ($luas <= 0) $luas = 1.0;
        
        $yield = $this->jumlah_kg / $luas;
        
        if ($yield >= 10000) {
            return 'Berhasil (Tinggi)';
        } elseif ($yield >= 5000) {
            return 'Berhasil (Normal)';
        } elseif ($yield >= 2500) {
            return 'Kurang Panen';
        } else {
            return 'Gagal Panen';
        }
    }
}
