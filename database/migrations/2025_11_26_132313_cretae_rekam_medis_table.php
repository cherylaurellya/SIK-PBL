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
        Schema::create('rekam_medis', function (Blueprint $table) {
    $table->id();
    $table->foreignId('pasien_id')->constrained('pasiens')->onDelete('cascade');
    $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade');
    // Perawat bisa nullable jika tidak selalu mendampingi
    $table->foreignId('perawat_id')->nullable()->constrained('perawats')->onDelete('set null'); 
    $table->date('tanggal');
    $table->text('keluhan');
    $table->text('diagnosis');
    $table->text('tindakan')->nullable();
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekam_medis');
    }
};