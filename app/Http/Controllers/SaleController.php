<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        // Group sales by product and calculate totals
        $salesQuery = Sale::select(
            'products.name as product_name',
            DB::raw('SUM(sales.quantity) as total_quantity'),
            DB::raw('SUM(sales.total_price) as total_amount'),
            DB::raw('MAX(sales.sold_at) as last_sold'),
            DB::raw('COUNT(*) as number_of_sales')
        )
    ->join('products', 'sales.product_id', '=', 'products.id')
    ;

        // If sales table has user ownership, limit to current user's sales.
        // Otherwise fall back to product ownership if that exists.
        if (Schema::hasColumn('sales', 'user_id')) {
            $salesQuery->where('sales.user_id', Auth::id());
        } elseif (Schema::hasColumn('products', 'user_id')) {
            $salesQuery->where('products.user_id', Auth::id());
        }

        $sales = $salesQuery
        ->groupBy('products.id', 'products.name')
        ->orderBy('total_quantity', 'desc')
        ->get();

        // Also fetch recent individual sales (not aggregated) so they can be shown separately
        $recentSales = Sale::with('product');

        if (Schema::hasColumn('sales', 'user_id')) {
            $recentSales->where('sales.user_id', Auth::id());
        } elseif (Schema::hasColumn('products', 'user_id')) {
            // filter via relationship when sales table doesn't have user_id
            $recentSales->whereHas('product', function ($q) {
                $q->where('user_id', Auth::id());
            });
        }

        $recentSales = $recentSales->orderBy('sold_at', 'desc')->limit(20)->get();

        return view('sales.index', compact('sales', 'recentSales'));
    }

    public function create()
    {
        if (Schema::hasColumn('products', 'user_id')) {
            $products = Product::where('quantity','>',0)->where('user_id', Auth::id())->get();
        } else {
            $products = Product::where('quantity','>',0)->get();
        }
        return view('sales.create', compact('products'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::findOrFail($data['product_id']);

        if ($product->quantity < $data['quantity']) {
            return back()->withErrors(['quantity' => 'Not enough stock'])->withInput();
        }

    // make sure product belongs to current user (if user ownership is enabled)
    if (Schema::hasColumn('products', 'user_id') && $product->user_id !== Auth::id()) abort(403);

        DB::transaction(function () use ($product, $data) {
            $total = $product->price * $data['quantity'];

            $saleData = [
                'product_id' => $product->id,
                'quantity' => $data['quantity'],
                'total_price' => $total,
                'sold_at' => now()->timezone('Asia/Kolkata'),
            ];
            if (Schema::hasColumn('sales', 'user_id')) {
                $saleData['user_id'] = Auth::id();
            }

            Sale::create($saleData);

            $product->decrement('quantity', $data['quantity']);
        });

        return redirect()->route('sales.index')->with('success', 'Sale recorded.');
    }

    public function show(Sale $sale)
    {
        if (Schema::hasColumn('sales', 'user_id') && $sale->user_id !== Auth::id()) abort(403);
        $sale->load('product');
        return view('sales.show', compact('sale'));
    }
}
