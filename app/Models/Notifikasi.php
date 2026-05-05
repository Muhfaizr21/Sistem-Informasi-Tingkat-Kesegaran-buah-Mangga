<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'pengguna_id',
        'tipe',
        'judul',
        'pesan',
        'referensi_tipe',
        'referensi_id',
        'sudah_dibaca',
    ];

    protected $casts = [
        'sudah_dibaca' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'pengguna_id');
    }

    public static function send($userId, $tipe, $judul, $pesan, $refTipe = null, $refId = null)
    {
        return self::create([
            'pengguna_id' => $userId,
            'tipe' => $tipe,
            'judul' => $judul,
            'pesan' => $pesan,
            'referensi_tipe' => $refTipe,
            'referensi_id' => $refId,
            'sudah_dibaca' => false,
        ]);
    }
}
