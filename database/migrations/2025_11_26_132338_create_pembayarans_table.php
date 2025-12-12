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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            // Foreign Key
            // Asumsi foreign key ke rekam_medis_id
            $table->foreignId('rekam_medis_id')->constrained('rekam_medis')->onDelete('cascade'); 
            
            // Kolom Data Pembayaran
            $table->integer('total_biaya'); // FIX: Diperlukan oleh Controller/Model
            $table->string('metode_pembayaran'); // FIX: Diperlukan oleh Controller/Model
            $table->string('status')->default('Lunas'); // Diperlukan oleh Controller/Model
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};