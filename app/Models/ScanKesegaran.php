<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScanKesegaran extends Model
{
    use HasFactory;

    protected $table = 'scan_kesegaran';

    protected $fillable = [
        'lahan_id',
        'petani_id',
        'pembeli_id',
        'path_foto',
        'berat_gram',
        'diameter_cm',
        'jenis_mangga',
        'skor_kesegaran',
        'persentase_warna',
        'skor_tekstur',
        'skor_bentuk',
        'skor_aroma',
        'cacat_terdeteksi',
        'kategori',
        'rekomendasi',
        'skor_kepercayaan',
        'batch_id',
        'dipindai_pada',
        'status_verifikasi',
        'skor_manual',
        'is_anomaly',
        'catatan_admin',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    protected $casts = [
        'dipindai_pada' => 'datetime',
        'cacat_terdeteksi' => 'boolean',
        'is_anomaly' => 'boolean',
        'diverifikasi_pada' => 'datetime',
    ];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class, 'pembeli_id');
    }

    public function petani()
    {
        return $this->belongsTo(Petani::class, 'petani_id');
    }

    public function lahan()
    {
        return $this->belongsTo(Lahan::class, 'lahan_id');
    }
}
