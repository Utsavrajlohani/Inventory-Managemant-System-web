<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Facades\DB;

class QueryExampleController extends Controller
{
    public function joins()
    {
        // Eloquent join via relationship (eager loading)
        $products = Product::with('supplier')->limit(20)->get();

        // Query builder example with explicit join
        DB::enableQueryLog();
        $joined = DB::table('products')
            ->join('suppliers','products.supplier_id','=','suppliers.id')
            ->select('products.id','products.name as product_name','suppliers.name as supplier_name')
            ->limit(20)
            ->get();

        $queries = DB::getQueryLog();

        return view('query.joins', compact('products','joined','queries'));
    }
}
