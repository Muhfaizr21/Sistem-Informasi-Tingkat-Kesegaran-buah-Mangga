<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListingMangga extends Model
{
    use HasFactory;

    protected $table = 'listing_mangga';

    protected $fillable = [
        'petani_id',
        'lahan_id',
        'scan_id',
        'batch_id',
        'jenis_mangga',
        'skor_kesegaran',
        'foto_batch',
        'stok_tersedia_kg',
        'harga_per_kg',
        'minimal_order_kg',
        'deskripsi',
        'aktif',
    ];

    protected $casts = [
        'foto_batch' => 'json',
        'aktif' => 'boolean',
        'skor_kesegaran' => 'decimal:2',
        'stok_tersedia_kg' => 'decimal:2',
        'harga_per_kg' => 'decimal:2',
        'minimal_order_kg' => 'decimal:2',
    ];

    public function petani()
    {
        return $this->belongsTo(Petani::class);
    }

    public function lahan()
    {
        return $this->belongsTo(Lahan::class);
    }

    public function scan()
    {
        return $this->belongsTo(ScanKesegaran::class, 'scan_id');
    }
}
