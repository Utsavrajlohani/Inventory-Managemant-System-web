<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function sales()
    {
        $start = request()->query('start_date');
        $end = request()->query('end_date');

        $query = DB::table('sales')
            ->join('products','sales.product_id','=','products.id')
            ->select('products.id as product_id','products.name as product_name', DB::raw('SUM(sales.quantity) as total_quantity'), DB::raw('SUM(sales.total_price) as total_sales'))
            ->groupBy('products.id','products.name')
            ->orderByDesc('total_quantity');

        if ($start) {
            $query->whereDate('sales.sold_at', '>=', $start);
        }
        if ($end) {
            $query->whereDate('sales.sold_at', '<=', $end);
        }

        $summary = $query->get();

        return view('reports.sales', compact('summary','start','end'));
    }

    public function exportSalesCsv()
    {
        $start = request()->query('start_date');
        $end = request()->query('end_date');

        $query = DB::table('sales')
            ->join('products','sales.product_id','=','products.id')
            ->select('products.name as product_name', DB::raw('SUM(sales.quantity) as total_quantity'), DB::raw('SUM(sales.total_price) as total_sales'))
            ->groupBy('products.name')
            ->orderByDesc('total_quantity');

        if ($start) $query->whereDate('sales.sold_at', '>=', $start);
        if ($end) $query->whereDate('sales.sold_at', '<=', $end);

        $rows = $query->get();

        // Build CSV in-memory so tests can capture it reliably
        $fh = fopen('php://memory', 'r+');
        fputcsv($fh, ['Product','Total Quantity','Total Sales']);
        foreach ($rows as $r) {
            fputcsv($fh, [$r->product_name, $r->total_quantity, number_format($r->total_sales,2)]);
        }
        rewind($fh);
        $csv = stream_get_contents($fh);
        fclose($fh);

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="sales-report.csv"',
        ];

        // If streaming export requested via query param or env, return streamed response
        if (request()->query('stream') || env('APP_STREAM_EXPORT', false)) {
            $callback = function() use ($rows) {
                $out = fopen('php://output', 'w');
                fputcsv($out, ['Product','Total Quantity','Total Sales']);
                foreach ($rows as $r) {
                    fputcsv($out, [$r->product_name, $r->total_quantity, number_format($r->total_sales,2)]);
                }
                fclose($out);
            };

            return response()->stream($callback, 200, $headers);
        }

        return response($csv, 200, $headers);
    }

    /**
     * Streaming export explicitly (alternate route)
     */
    public function exportSalesCsvStream()
    {
        // reuse the logic above to construct rows
        $start = request()->query('start_date');
        $end = request()->query('end_date');

        $query = DB::table('sales')
            ->join('products','sales.product_id','=','products.id')
            ->select('products.name as product_name', DB::raw('SUM(sales.quantity) as total_quantity'), DB::raw('SUM(sales.total_price) as total_sales'))
            ->groupBy('products.name')
            ->orderByDesc('total_quantity');

        if ($start) $query->whereDate('sales.sold_at', '>=', $start);
        if ($end) $query->whereDate('sales.sold_at', '<=', $end);

        $rows = $query->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="sales-report-stream.csv"',
        ];

        $callback = function() use ($rows) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Product','Total Quantity','Total Sales']);
            foreach ($rows as $r) {
                fputcsv($out, [$r->product_name, $r->total_quantity, number_format($r->total_sales,2)]);
            }
            fclose($out);
        };

        return response()->stream($callback, 200, $headers);
    }
}
