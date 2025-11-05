@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2>Supplier Details</h2>
                    <div>
                        <a href="{{ route('suppliers.edit', $supplier) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit
                        </a>
                        <form action="{{ route('suppliers.destroy', $supplier) }}" 
                              method="POST" 
                              class="d-inline"
                              onsubmit="return confirm('Are you sure you want to delete this supplier?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash"></i> Delete
                            </button>
                        </form>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 150px;">Name:</th>
                            <td>{{ $supplier->name }}</td>
                        </tr>
                        <tr>
                            <th>Contact:</th>
                            <td>{{ $supplier->contact ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Email:</th>
                            <td>{{ $supplier->email ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Address:</th>
                            <td>{{ $supplier->address ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Total Products:</th>
                            <td>{{ $supplier->products->count() }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3>Products by this Supplier</h3>
                </div>
                <div class="card-body">
                    @if($supplier->products->count())
                        <div class="list-group">
                            @foreach($supplier->products as $product)
                                <a href="{{ route('products.show', $product) }}" 
                                   class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                    {{ $product->name }}
                                    <span class="badge bg-primary rounded-pill">{{ $product->quantity }}</span>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No products from this supplier.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <a href="{{ route('suppliers.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Back to Suppliers
        </a>
    </div>
</div>
@endsection
