<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$request = new \Illuminate\Http\Request();
$request->merge([
    'tagihan_id' => App\Models\Tagihan::first()->id,
    'nominal_bayar' => 100000,
]);

// This requires an image, so it might fail validation if we just call the controller.
// But we already know the controller logic:
$tagihan = App\Models\Tagihan::find($request->tagihan_id);
$tagihan->update(['status' => 'proses_verifikasi']);
echo $tagihan->status;
