<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{
    public function index()
    {
        if (Schema::hasColumn('suppliers', 'user_id')) {
            $suppliers = Supplier::where('user_id', Auth::id())->withCount('products')->paginate(15);
        } else {
            $suppliers = Supplier::withCount('products')->paginate(15);
        }
        return view('suppliers.index', compact('suppliers'));
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:100',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

        if (Schema::hasColumn('suppliers', 'user_id')) {
            Supplier::create(array_merge($data, ['user_id' => Auth::id()]));
        } else {
            Supplier::create($data);
        }

        return redirect()->route('suppliers.index')->with('success', 'Supplier created.');
    }

    public function show(Supplier $supplier)
    {
        if (Schema::hasColumn('suppliers', 'user_id') && $supplier->user_id !== Auth::id()) abort(403);
        return view('suppliers.show', compact('supplier'));
    }

    public function edit(Supplier $supplier)
    {
        if (Schema::hasColumn('suppliers', 'user_id') && $supplier->user_id !== Auth::id()) abort(403);
        return view('suppliers.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'contact' => 'nullable|string|max:100',
            'email' => 'nullable|email',
            'address' => 'nullable|string',
        ]);

    if (Schema::hasColumn('suppliers', 'user_id') && $supplier->user_id !== Auth::id()) abort(403);
    $supplier->update($data);

        return redirect()->route('suppliers.index')->with('success', 'Supplier updated.');
    }

    public function destroy(Supplier $supplier)
    {
        if (Schema::hasColumn('suppliers', 'user_id') && $supplier->user_id !== Auth::id()) abort(403);
        $supplier->delete();
        return redirect()->route('suppliers.index')->with('success', 'Supplier deleted.');
    }
}
