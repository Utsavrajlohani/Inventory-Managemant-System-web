<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Ensuring cache tables exist\n";
if (!Schema::hasTable('cache')) {
    Schema::create('cache', function (Blueprint $table) {
        $table->string('key')->primary();
        $table->mediumText('value');
        $table->integer('expiration');
    });
    echo "Created 'cache' table\n";
} else {
    echo "'cache' table already exists\n";
}

if (!Schema::hasTable('cache_locks')) {
    Schema::create('cache_locks', function (Blueprint $table) {
        $table->string('key')->primary();
        $table->string('owner');
        $table->integer('expiration');
    });
    echo "Created 'cache_locks' table\n";
} else {
    echo "'cache_locks' table already exists\n";
}

echo "Done.\n";
