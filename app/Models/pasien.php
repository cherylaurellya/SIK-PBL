<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $fillable = ['user_id', 'nik', 'alamat', 'tanggal_lahir'];

    public function user() {
        return $this->belongsTo(User::class);
    }
    public function rekamMedis() {
        return $this->hasMany(RekamMedis::class);
    }
    public function pembayarans() {
        return $this->hasMany(Pembayaran::class);
    }
}