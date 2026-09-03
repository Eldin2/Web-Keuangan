<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transaksis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tagihan_id')->constrained('tagihans')->onDelete('cascade');
            $table->string('bukti_bayar')->nullable();
            $table->enum('metode', ['online', 'cash']);
            $table->decimal('nominal_bayar', 15, 2);
            $table->date('tanggal_bayar');
            $table->boolean('is_valid_kepala_sekolah')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transaksis');
    }
};