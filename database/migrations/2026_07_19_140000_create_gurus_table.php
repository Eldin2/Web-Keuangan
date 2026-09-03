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
        Schema::create('gurus', function (Blueprint $table) {
            $table->id();
            $table->string('nama_guru');
            $table->string('nip')->nullable()->unique();
            $table->string('status')->nullable(); // e.g. Tetap, Honor, PNS
            $table->string('jabatan'); // e.g. Wali Kelas, Guru Kelas
            $table->bigInteger('gaji_bulanan')->default(0); // Simple monthly salary
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
        Schema::dropIfExists('gurus');
    }
};
