@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h2 class="mb-0"><i class="fas fa-receipt"></i> Sale Details #{{ $sale->id }}</h2>
                </div>
                <div class="card-body">
                    <table class="table">
                        <tr>
                            <th style="width: 150px;">Product:</th>
                            <td>
                                <a href="{{ route('products.show', $sale->product) }}" class="text-decoration-none">
                                    {{ $sale->product->name }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <th>Quantity:</th>
                            <td>{{ $sale->quantity }}</td>
                        </tr>
                        <tr>
                            <th>Unit Price:</th>
                            <td>₹{{ number_format($sale->total_price / $sale->quantity, 2) }}</td>
                        </tr>
                        <tr>
                            <th>Total Amount:</th>
                            <td>
                                <span class="h4 text-primary">₹{{ number_format($sale->total_price, 2) }}</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Sale Date:</th>
                            <td>{{ \Illuminate\Support\Carbon::parse($sale->sold_at)->timezone('Asia/Kolkata')->format('F d, Y h:i:s A') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('sales.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to Sales
                </a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Product Information</h3>
                </div>
                <div class="card-body">
                    <p><strong>Current Stock:</strong> {{ $sale->product->quantity }}</p>
                    <p><strong>SKU:</strong> {{ $sale->product->sku ?? 'N/A' }}</p>
                    <a href="{{ route('products.show', $sale->product) }}" class="btn btn-info">
                        <i class="fas fa-box"></i> View Product Details
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
