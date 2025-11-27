<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    // Relasi ke profil spesifik
    public function admin() {
        return $this->hasOne(Admin::class);
    }
    public function dokter() {
        return $this->hasOne(Dokter::class);
    }
    public function perawat() {
        return $this->hasOne(Perawat::class);
    }
    public function pasien() {
        return $this->hasOne(Pasien::class);
    }
}