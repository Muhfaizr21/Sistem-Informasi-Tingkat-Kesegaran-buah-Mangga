<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'kode_pesanan',
        'pembeli_id',
        'total_harga',
        'biaya_pengiriman',
        'diskon',
        'total_bayar',
        'alamat_id',
        'metode_pengiriman',
        'metode_pembayaran',
        'status',
        'dibayar_pada',
        'dikirim_pada',
        'selesai_pada',
    ];

    protected $casts = [
        'total_harga' => 'decimal:2',
        'biaya_pengiriman' => 'decimal:2',
        'diskon' => 'decimal:2',
        'total_bayar' => 'decimal:2',
        'dibayar_pada' => 'datetime',
        'dikirim_pada' => 'datetime',
        'selesai_pada' => 'datetime',
    ];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function items()
    {
        return $this->hasMany(DetailPesanan::class);
    }

    public function alamat()
    {
        return $this->belongsTo(AlamatPengiriman::class, 'alamat_id');
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }
}
