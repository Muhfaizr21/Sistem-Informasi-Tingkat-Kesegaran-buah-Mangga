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
        'slug',
        'skor_kesegaran',
        'foto_batch',
        'stok_tersedia_kg',
        'harga_per_kg',
        'minimal_order_kg',
        'deskripsi',
        'aktif',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function ($listing) {
            $listing->slug = \Illuminate\Support\Str::slug($listing->jenis_mangga . '-' . \Illuminate\Support\Str::random(6));
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

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
