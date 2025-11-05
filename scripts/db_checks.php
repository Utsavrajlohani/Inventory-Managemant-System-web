<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use Illuminate\Support\Facades\DB;

function printRows($title, $rows) {
    echo "--- $title (showing up to 20 rows) ---\n";
    if (empty($rows)) {
        echo "(no rows)\n\n";
        return;
    }
    foreach ($rows as $r) {
        echo json_encode($r) . "\n";
    }
    echo "\n";
}

// 1) NULL user_id rows
$productsNull = DB::select('SELECT id, name, user_id FROM products WHERE user_id IS NULL LIMIT 20');
$salesNull = DB::select('SELECT id, product_id, quantity, user_id, sold_at FROM sales WHERE user_id IS NULL LIMIT 20');
$suppliersNull = DB::select('SELECT id, name, user_id FROM suppliers WHERE user_id IS NULL LIMIT 20');

printRows('Products with NULL user_id', $productsNull);
printRows('Sales with NULL user_id', $salesNull);
printRows('Suppliers with NULL user_id', $suppliersNull);

// 2) Sales where sale.user_id != product.user_id (and sale.user_id not null)
$mismatch = DB::select("SELECT s.id as sale_id, s.user_id as sale_user, p.id as product_id, p.user_id as product_user
    FROM sales s JOIN products p ON s.product_id = p.id
    WHERE s.user_id IS NOT NULL AND p.user_id IS NOT NULL AND s.user_id <> p.user_id
    LIMIT 50");
printRows('Sales with mismatched sale.user_id vs product.user_id', $mismatch);

// 3) Counts per user
$productCounts = DB::select('SELECT COALESCE(user_id, 0) AS user_id, COUNT(*) AS product_count FROM products GROUP BY user_id ORDER BY product_count DESC');
$saleCounts = DB::select('SELECT COALESCE(user_id, 0) AS user_id, COUNT(*) AS sale_count FROM sales GROUP BY user_id ORDER BY sale_count DESC');

echo "--- Product counts per user ---\n";
foreach ($productCounts as $r) echo json_encode($r) . "\n";
echo "\n--- Sale counts per user ---\n";
foreach ($saleCounts as $r) echo json_encode($r) . "\n";

echo "\nChecks complete.\n";
