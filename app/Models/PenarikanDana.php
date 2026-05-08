<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenarikanDana extends Model
{
    use HasFactory;

    protected $fillable = [
        'petani_id',
        'nominal',
        'no_ktp',
        'foto_ktp',
        'nama_bank',
        'no_rekening',
        'nama_rekening',
        'status',
        'catatan_admin',
        'disetujui_pada',
        'disetujui_oleh',
    ];

    protected $casts = [
        'disetujui_pada' => 'datetime',
        'nominal' => 'decimal:2',
    ];

    public function petani()
    {
        return $this->belongsTo(Petani::class);
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}
