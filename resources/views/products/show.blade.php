@extends('layouts.app')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h2 class="mb-0"><i class="fas fa-box"></i> Product Details</h2>
            <div>
                <a href="{{ route('products.edit', $product->id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <form action="{{ route('products.destroy', $product->id) }}" 
                      method="POST" 
                      class="d-inline"
                      onsubmit="return confirm('Are you sure you want to delete this product?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-borderless">
                        <tr>
                            <th style="width: 150px;">Name:</th>
                            <td>{{ $product->name }}</td>
                        </tr>
                        <tr>
                            <th>Description:</th>
                            <td>{{ $product->description ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <th>Price:</th>
                            <td>₹{{ number_format($product->price, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Quantity:</th>
                            <td>{{ $product->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Supplier:</th>
                            <td>{{ $product->supplier->name ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6 text-center">
                    @if($product->image_path)
                        <img src="{{ asset('storage/' . $product->image_path) }}" 
                             alt="{{ $product->name }}"
                             class="img-fluid rounded"
                             style="max-height: 300px;">
                    @else
                        <div class="alert alert-info">
                            <i class="fas fa-image"></i> No image available
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="card-footer">
            <a href="{{ route('products.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>
    </div>
</div>
@endsection
