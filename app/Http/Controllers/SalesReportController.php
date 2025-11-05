<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Http\Controllers\Controller;
use App\Models\Sale;
use Carbon\Carbon;

class SalesReportController extends Controller
{

    public function index(Request $request)
    {
        $period = $request->period ?? 'daily';
        
        // Start with base query
        $query = Sale::with('product')
            ->join('products', 'sales.product_id', '=', 'products.id')
            ->select('sales.*', 'products.name as product_name')
            ->orderBy('sales.sold_at', 'desc');

        // Apply user filtering
        if (Schema::hasColumn('sales', 'user_id')) {
            $query->where('sales.user_id', Auth::id());
        } elseif (Schema::hasColumn('products', 'user_id')) {
            $query->where('products.user_id', Auth::id());
        }

        $sales = $query->get();
        
        // Group sales by period and product
        $groupedSales = $sales->groupBy(function ($sale) use ($period) {
            $date = Carbon::parse($sale->sold_at);
            switch ($period) {
                case 'weekly':
                    return $date->startOfWeek()->format('Y-m-d');
                case 'monthly':
                    return $date->format('Y-m');
                default:
                    return $date->format('Y-m-d');
            }
        })->map(function ($periodSales) use ($period) {
            $firstSale = $periodSales->first();
            $date = Carbon::parse($firstSale->sold_at);
            
            $result = [
                'period_start' => $date->copy()->startOfDay(),
            ];
            
            if ($period === 'weekly') {
                $result['period_end'] = $date->copy()->endOfWeek();
            }
            
            $result['products'] = $periodSales
                ->groupBy('product_id')
                ->map(function ($productSales) {
                    return [
                        'product_name' => $productSales->first()->product_name,
                        'total_quantity' => $productSales->sum('quantity'),
                        'total_amount' => $productSales->sum('total_price'),
                        'number_of_sales' => $productSales->count(),
                    ];
                });
                
            return $result;
        });

        return view('sales.report', [
            'sales' => $groupedSales,
            'period' => $period
        ]);
    }
}