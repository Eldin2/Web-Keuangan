<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('gaji_gurus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('cascade');
            $table->integer('bulan'); // 1-12
            $table->integer('tahun'); // e.g. 2026
            $table->bigInteger('nominal_gaji'); // Gaji Bulanan Pokok
            $table->bigInteger('potongan')->default(0); // Potongan Gaji
            $table->bigInteger('total_gaji'); // nominal_gaji - potongan
            $table->text('keterangan')->nullable();
            $table->date('tanggal_dibayar');
            $table->string('status_pembayaran')->default('dibayar'); // dibayar, pending
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('gaji_gurus');
    }
};
