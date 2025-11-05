<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

$tables = ['products','sales','suppliers'];
foreach ($tables as $t) {
    echo "Columns for table: $t\n";
    try {
        $cols = DB::select("SELECT column_name, data_type FROM information_schema.columns WHERE table_schema=DATABASE() AND table_name = ?", [$t]);
        if (empty($cols)) {
            echo "  (table does not exist)\n\n";
            continue;
        }
        foreach ($cols as $c) {
            echo "  - {$c->column_name} ({$c->data_type})\n";
        }
        echo "\n";
    } catch (Exception $e) {
        echo "  ERROR: {$e->getMessage()}\n\n";
    }
}
