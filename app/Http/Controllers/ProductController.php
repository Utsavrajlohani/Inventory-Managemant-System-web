<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index()
    {
        // If migrations haven't been run yet the `user_id` column won't exist.
        // Fall back to showing all products until migration is applied.
        if (Schema::hasColumn('products', 'user_id')) {
            $products = Product::with('supplier')->where('user_id', Auth::id())->paginate(10);
        } else {
            $products = Product::with('supplier')->paginate(10);
        }
        return view('products.index', compact('products'));
    }

    public function create()
    {
        if (Schema::hasColumn('suppliers', 'user_id')) {
            $suppliers = Supplier::where('user_id', Auth::id())->get();
        } else {
            $suppliers = Supplier::all();
        }
        return view('products.create', compact('suppliers'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'supplier_id' => 'required|exists:suppliers,id',
            'image' => 'nullable|file|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], [
            'image.image' => 'The uploaded file must be an image.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, or gif.',
            'image.max' => 'The image may not be larger than 2MB.',
            'image.file' => 'Please select a valid image file.'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products','public');
            $data['image_path'] = $path;
        }

    if (Schema::hasColumn('products', 'user_id')) {
        Product::create(array_merge($data, ['user_id' => Auth::id()]));
    } else {
        Product::create($data);
    }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    public function show(Product $product)
    {
    if (Schema::hasColumn('products', 'user_id') && $product->user_id !== Auth::id()) abort(403);
        $product->load('supplier');
        return view('products.show', compact('product'));
    }

    public function edit(Product $product)
    {
        if (Schema::hasColumn('products', 'user_id') && $product->user_id !== Auth::id()) abort(403);
        if (Schema::hasColumn('suppliers', 'user_id')) {
            $suppliers = Supplier::where('user_id', Auth::id())->get();
        } else {
            $suppliers = Supplier::all();
        }
        return view('products.edit', compact('product','suppliers'));
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

    if (Schema::hasColumn('products', 'user_id') && $product->user_id !== Auth::id()) abort(403);
    if ($request->hasFile('image')) {
            // delete old if exists
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $path = $request->file('image')->store('products','public');
            $data['image_path'] = $path;
        }

    $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        if (Schema::hasColumn('products', 'user_id') && $product->user_id !== Auth::id()) abort(403);
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted.');
    }
}
