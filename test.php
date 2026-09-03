<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

$t = App\Models\Tagihan::first();
if ($t) {
    $t->status = 'proses_verifikasi';
    $t->save();
    echo "Updated status to " . $t->status;
} else {
    echo "No tagihan found";
}
