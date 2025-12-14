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
            $table->foreignId('dokter_id')->constrained('dokters')->onDelete('cascade'); 
            $table->string('hari');
            $table->time('jam_mulai');
            $table->time('jam_selesai');
            $table->tinyInteger('status')->default(0); // 1=Aktif, 0=Libur (Default Libur)
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