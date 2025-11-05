<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

echo "Populating products.user_id from suppliers.user_id where supplier exists...\n";
$affected1 = DB::statement(
    "UPDATE products p JOIN suppliers s ON p.supplier_id = s.id SET p.user_id = s.user_id WHERE p.user_id IS NULL AND p.supplier_id IS NOT NULL"
);
echo "Query executed. (Note: DB driver returns boolean for statement)\n";

echo "Populating sales.user_id from products.user_id where available...\n";
$affected2 = DB::statement(
    "UPDATE sales s JOIN products p ON s.product_id = p.id SET s.user_id = p.user_id WHERE s.user_id IS NULL AND p.user_id IS NOT NULL"
);
echo "Query executed.\n";

echo "Counts after population:\n";
$pNull = DB::select('SELECT COUNT(*) as cnt FROM products WHERE user_id IS NULL')[0]->cnt;
$sNull = DB::select('SELECT COUNT(*) as cnt FROM sales WHERE user_id IS NULL')[0]->cnt;
echo "  products with NULL user_id: $pNull\n";
echo "  sales with NULL user_id: $sNull\n";

echo "Sample remaining product rows with NULL user_id:\n";
$rowsP = DB::select('SELECT id, name, supplier_id FROM products WHERE user_id IS NULL LIMIT 20');
foreach ($rowsP as $r) echo json_encode($r) . "\n";

echo "Sample remaining sales rows with NULL user_id:\n";
$rowsS = DB::select('SELECT id, product_id, quantity FROM sales WHERE user_id IS NULL LIMIT 20');
foreach ($rowsS as $r) echo json_encode($r) . "\n";

echo "Done.\n";
