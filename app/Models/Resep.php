<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resep extends Model
{
    protected $fillable = ['rekam_medis_id', 'nama_obat', 'dosis', 'aturan_pakai'];

    public function rekamMedis() {
        return $this->belongsTo(RekamMedis::class);
    }
}