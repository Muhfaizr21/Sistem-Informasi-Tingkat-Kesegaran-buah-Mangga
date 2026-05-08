<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorit extends Model
{
    protected $table = 'favorit';

    protected $fillable = [
        'pembeli_id',
        'petani_id',
    ];

    public function pembeli()
    {
        return $this->belongsTo(Pembeli::class);
    }

    public function petani()
    {
        return $this->belongsTo(Petani::class);
    }
}
