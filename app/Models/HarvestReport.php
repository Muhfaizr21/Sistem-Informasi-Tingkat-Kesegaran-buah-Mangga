<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HarvestReport extends Model
{
    protected $fillable = [
        'user_id',
        'variety',
        'weight',
        'location',
        'grade',
        'note',
    ];
}
