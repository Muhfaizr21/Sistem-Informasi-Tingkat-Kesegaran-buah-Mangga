<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kecamatan extends Model
{
    use HasFactory;

    protected $table = 'kecamatan';

    protected $fillable = [
        'kode_bps',
        'nama',
    ];

    public $timestamps = false;

    public function lahan()
    {
        return $this->hasMany(Lahan::class);
    }
}
