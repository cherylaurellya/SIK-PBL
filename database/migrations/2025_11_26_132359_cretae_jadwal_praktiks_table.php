<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('jadwal_praktiks', function (Blueprint $table) {
            $table->id();
            // Pastikan tabel 'dokters' sudah ada sebelumnya.
            // Jika tabel dokter Anda bernama 'users' dengan role dokter, sesuaikan foreignId ini.
            // Asumsi saat ini: Anda punya tabel 'dokters'.
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade'); 
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jadwal_praktiks');
    }
};