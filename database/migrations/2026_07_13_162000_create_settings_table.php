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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default bank account details so that it starts with the current details
        \App\Models\Setting::create([
            'key' => 'norek_bank_name',
            'value' => 'BRI'
        ]);
        \App\Models\Setting::create([
            'key' => 'norek_number',
            'value' => '111 111 1111'
        ]);
        \App\Models\Setting::create([
            'key' => 'norek_owner',
            'value' => 'TK IT INSAN CENDIKIA'
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
