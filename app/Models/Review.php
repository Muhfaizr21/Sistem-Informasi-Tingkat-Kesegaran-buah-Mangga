<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $table = 'review';

    protected $fillable = [
        'pesanan_id',
        'pembeli_id',
        'petani_id',
        'rating',
        'komentar',
        'foto_review',
    ];

    protected $casts = [
        'foto_review' => 'json',
    ];

    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class);
    }

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function petani()
    {
        return $this->belongsTo(Petani::class);
    }
}
