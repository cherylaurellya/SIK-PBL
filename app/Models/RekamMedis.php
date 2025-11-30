<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekamMedis extends Model
{
    use HasFactory;

    protected $table = 'rekam_medis'; 

    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'tanggal',
        'keluhan',
        'diagnosis', 
        'tindakan',
        'resep_obat',
    ];

    protected $casts = [
        'tanggal' => 'datetime', 
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class);
    }

    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
    
    // [FIX AKHIR] Relasi yang Hilang: Rekam Medis memiliki satu Pembayaran
    public function pembayaran()
    {
        // Asumsi kolom foreign key di tabel 'pembayarans' adalah 'rekam_medis_id'
        return $this->hasOne(Pembayaran::class); 
    }
}