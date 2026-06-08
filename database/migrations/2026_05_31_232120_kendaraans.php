<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kendaraans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategoris')->cascadeOnDelete(); //cascadeOnDelete berungsi untuk menghapus data kendaraan jika kategori dihapus
            $table->string('nama_mobil');
            $table->string('merk');
            $table->year('tahun');
            $table->string('plat_nomor')->unique();
            $table->integer('kapasitas_penumpang');
            $table->decimal('harga_sewa_per_hari', 12, 2); //12 adalah total digit, 2 adalah digit desimal
            $table->string('gambar')->nullable();
            $table->text('deskripsi')->nullable();
            $table->enum('status', ['tersedia','disewa','maintenance'])->default('tersedia');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kendaraans');
    }
};