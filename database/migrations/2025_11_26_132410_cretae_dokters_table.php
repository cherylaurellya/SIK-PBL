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
        // KOREKSI: Ini harusnya Schema::CREATE jika tabel dokters belum ada.
        // TETAPI, karena Anda sedang memperbaiki masalah *no_str* pada tabel yang *sudah ada*, 
        // kita perlu menemukan migrasi yang *sebenarnya* membuat tabel dokters.

        // Mari kita asumsikan Anda memiliki file lain yang membuat tabel 'dokters'.
        // Kita HANYA akan mengubah file ini menjadi migrasi yang membuat TABEL DOKTER SECARA LENGKAP,
        // yang secara implisit akan memasukkan kolom 'no_str'.
        
        // JIKA file ini seharusnya HANYA MENAMBAH KOLOM (ALTER TABLE), maka Anda memiliki file migrasi lain yang salah.
        // Karena tidak ada file lain yang menyediakan definisi tabel 'dokters', mari kita ubah file ini untuk MEMBUAT TABEL.
        
        Schema::create('dokters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('spesialisasi')->nullable();
            // Tambahkan kolom no_str di sini
            $table->string('no_str')->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dokters');
    }
};