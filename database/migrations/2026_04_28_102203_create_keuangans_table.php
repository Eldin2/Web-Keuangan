<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeuangansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('keuangans', function (Blueprint $table) {
        $table->id();
        $table->enum('tipe', ['masuk', 'keluar']); // Pembeda jenis uang
        $table->string('kategori'); // Infaq, Dana BOS, Alat Kebersihan, dll
        $table->bigInteger('nominal');
        $table->text('keterangan')->nullable();
        $table->date('tanggal');
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('keuangans');
    }
}
