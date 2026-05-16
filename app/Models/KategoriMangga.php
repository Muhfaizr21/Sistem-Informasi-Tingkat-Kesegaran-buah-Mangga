<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriMangga extends Model
{
    protected $table = 'kategori_manggas';
    protected $fillable = ['nama', 'deskripsi'];
}
