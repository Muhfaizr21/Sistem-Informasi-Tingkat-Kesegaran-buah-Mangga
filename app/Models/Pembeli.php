<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembeli extends Model
{
    use HasFactory;

    protected $table = 'pembeli';

    protected $fillable = [
        'pengguna_id',
        'tipe_bisnis',
        'npwp',
        'poin_loyalitas',
        'tier_member',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public function pesanan()
    {
        return $this->hasMany(Pesanan::class);
    }

    public function alamat()
    {
        return $this->hasMany(AlamatPengiriman::class);
    }

    public function scans()
    {
        return $this->hasMany(ScanKesegaran::class, 'pembeli_id');
    }

    public function favoriteFarmers()
    {
        return $this->hasMany(Favorit::class, 'pembeli_id');
    }
}
