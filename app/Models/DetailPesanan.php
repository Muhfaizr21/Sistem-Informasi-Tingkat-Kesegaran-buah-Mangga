<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    protected $table = 'detail_pesanan';

    protected $fillable = [
        'pesanan_id',
        'listing_id',
        'petani_id',
        'jumlah_kg',
        'harga_satuan',
        'subtotal',
    ];

    protected $casts = [
        'jumlah_kg' => 'decimal:2',
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function listing()
    {
        return $this->belongsTo(ListingMangga::class);
    }

    public function petani()
    {
        return $this->belongsTo(Petani::class);
    }
}
