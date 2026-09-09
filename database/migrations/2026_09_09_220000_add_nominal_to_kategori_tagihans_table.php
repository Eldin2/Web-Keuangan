<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('kategori_tagihans', 'nominal')) {
            Schema::table('kategori_tagihans', function (Blueprint $table) {
                $table->decimal('nominal', 15, 2)->default(0)->after('nama_kategori');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('kategori_tagihans', 'nominal')) {
            Schema::table('kategori_tagihans', function (Blueprint $table) {
                $table->dropColumn('nominal');
            });
        }
    }
};
