<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    protected $table = 'rekam_medis';
    protected $fillable = ['pasien_id', 'dokter_id', 'perawat_id', 'tanggal', 'keluhan', 'diagnosis', 'tindakan'];

    public function pasien() {
        return $this->belongsTo(Pasien::class);
    }
    public function dokter() {
        return $this->belongsTo(Dokter::class);
    }
    public function perawat() {
        return $this->belongsTo(Perawat::class);
    }
    public function resep() {
        return $this->hasOne(Resep::class); // Atau hasMany jika 1 rekam medis bisa banyak resep
    }
    public function pembayaran() {
        return $this->hasOne(Pembayaran::class);
    }
}