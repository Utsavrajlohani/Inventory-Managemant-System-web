@extends('layouts.app')

{{-- facades available via global aliases; explicit use block removed to reduce duplication --}}

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow mb-4">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0"><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-4">
                        <div class="col-md-4">
                            <div class="card border-info">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-box"></i> Products</h5>
                                    <h2 class="display-6">{{ Schema::hasColumn('products', 'user_id') ? \App\Models\Product::where('user_id', Auth::id())->count() : \App\Models\Product::count() }}</h2>
                                    <a href="{{ route('products.index') }}" class="btn btn-info">View Products</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-warning">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-truck"></i> Suppliers</h5>
                                    <h2 class="display-6">{{ Schema::hasColumn('suppliers', 'user_id') ? \App\Models\Supplier::where('user_id', Auth::id())->count() : \App\Models\Supplier::count() }}</h2>
                                    <a href="{{ route('suppliers.index') }}" class="btn btn-warning">View Suppliers</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card border-success">
                                <div class="card-body">
                                    <h5 class="card-title"><i class="fas fa-shopping-cart"></i> Sales</h5>
                                    <h2 class="display-6">{{ Schema::hasColumn('sales', 'user_id') ? \App\Models\Sale::where('user_id', Auth::id())->sum('quantity') : \App\Models\Sale::sum('quantity') }}</h2>
                                    <a href="{{ route('sales.index') }}" class="btn btn-success">View Sales</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-success text-center">
                        <i class="fas fa-user-check text-success"></i> Welcome, {{ auth()->user()->name }}!
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
