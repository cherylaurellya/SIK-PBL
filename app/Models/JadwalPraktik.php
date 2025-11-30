<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalPraktik extends Model
{
    use HasFactory;

    protected $fillable = [
        'dokter_id',
        'hari',
        'jam_mulai',
        'jam_selesai',
        'status', // <<--- INI YANG HILANG, KINI DITAMBAHKAN
    ];

    // Opsional, tapi disarankan untuk memastikan penyimpanan tipe data numerik
    protected $casts = [
        'status' => 'integer', 
    ];

    // Relasi ke tabel Dokter
    public function dokter()
    {
        return $this->belongsTo(Dokter::class);
    }
}