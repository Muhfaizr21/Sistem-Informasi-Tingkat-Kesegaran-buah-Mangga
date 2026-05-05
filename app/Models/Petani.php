<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Petani extends Model
{
    use HasFactory;

    protected $table = 'petani';

    protected $fillable = [
        'pengguna_id',
        'nik',
        'pengalaman_tahun',
        'sertifikasi',
        'rekening_bank',
        'nama_bank',
        'kelompok_tani',
        'dokumen_ktp',
        'dokumen_lahan',
        'status_verifikasi',
        'diverifikasi_oleh',
        'diverifikasi_pada',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function lahan()
    {
        return $this->hasMany(Lahan::class);
    }

    public function listings()
    {
        return $this->hasMany(ListingMangga::class);
    }

    public function review()
    {
        return $this->hasMany(Review::class);
    }

    public function favoritedBy()
    {
        return $this->hasMany(Favorit::class, 'petani_id');
    }
}
