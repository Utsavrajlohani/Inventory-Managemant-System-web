<?php
// Bootstraps Laravel to mark existing migration files as applied and create sessions table if missing.
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

echo "Marking migrations as applied (if missing)\n";
$files = glob(__DIR__ . '/../database/migrations/*.php');
foreach ($files as $f) {
    $name = basename($f, '.php');
    $exists = DB::table('migrations')->where('migration', $name)->exists();
    if (!$exists) {
        DB::table('migrations')->insert([
            'migration' => $name,
            'batch' => 1,
        ]);
        echo "Inserted migration: $name\n";
    } else {
        echo "Already present: $name\n";
    }
}

echo "\nEnsuring sessions table exists\n";
if (!Schema::hasTable('sessions')) {
    Schema::create('sessions', function (Blueprint $table) {
        $table->string('id')->primary();
        $table->foreignId('user_id')->nullable()->index();
        $table->string('ip_address', 45)->nullable();
        $table->text('user_agent')->nullable();
        $table->longText('payload');
        $table->integer('last_activity')->index();
    });
    echo "Created sessions table\n";
} else {
    echo "Sessions table already exists\n";
}

echo "Done.\n";
