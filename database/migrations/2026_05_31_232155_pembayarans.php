<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rental_id')->unique()->constrained('rentals')->cascadeOnDelete();
            $table->string('metode_pembayaran');
            $table->string('bukti_pembayaran');
            $table->decimal('jumlah_bayar', 12, 2);
            $table->dateTime('tanggal_bayar')->nullable();
            $table->enum('status_pembayaran', ['pending','verified','rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};