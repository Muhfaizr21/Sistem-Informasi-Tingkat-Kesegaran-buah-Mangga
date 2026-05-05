<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    protected $table = 'pengguna';

    protected $appends = ['name'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama',
        'email',
        'password',
        'role',
        'no_telepon',
        'foto_profil',
    ];

    /**
     * Virtual attribute for 'name' to maintain compatibility with Laravel Auth
     */
    public function getNameAttribute()
    {
        return $this->nama;
    }

    public function setNameAttribute($value)
    {
        $this->attributes['nama'] = $value;
    }

    /**
     * Helper methods for roles
     */
    public function isAdmin() { return $this->role === 'admin'; }
    public function isPetani() { return $this->role === 'petani'; }
    public function isPembeli() { return $this->role === 'pembeli'; }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get the petani profile associated with the user.
     */
    public function petani()
    {
        return $this->hasOne(Petani::class, 'pengguna_id');
    }

    /**
     * Get the pembeli profile associated with the user.
     */
    public function pembeli()
    {
        return $this->hasOne(Pembeli::class, 'pengguna_id');
    }

    public function notifications()
    {
        return $this->hasMany(Notifikasi::class, 'pengguna_id');
    }
}
