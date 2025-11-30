<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pembayaran extends Model
{
    use HasFactory;

    // DAFTAR KOLOM YANG BOLEH DIISI (Wajib sama dengan Controller)
    protected $fillable = [
        'rekam_medis_id',
        'total_biaya',
        'metode_pembayaran', // Penting! Jangan sampai ketinggalan
        'status',
    ];

    // Relasi ke Rekam Medis
    public function rekamMedis()
    {
        return $this->belongsTo(RekamMedis::class);
    }
}