<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    protected $fillable = ['pasien_id', 'rekam_medis_id', 'total_biaya', 'tanggal_bayar', 'status'];

    public function pasien() {
        return $this->belongsTo(Pasien::class);
    }
    public function rekamMedis() {
        return $this->belongsTo(RekamMedis::class);
    }
}