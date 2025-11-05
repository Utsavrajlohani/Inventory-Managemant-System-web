@extends('layouts.app')

@section('content')
<div class="container">
    <!-- Sales Table -->
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h2 class="mb-0"><i class="fas fa-shopping-cart"></i> Sales Summary</h2>
                <a href="{{ route('sales.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Record Sale
                </a>
            </div>
        </div>
        <div class="card-body">
            @if($sales->isEmpty())
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> No sales have been recorded yet.
                </div>
            @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Product</th>
                                <th>Number of Sales</th>
                                <th>Total Quantity</th>
                                <th>Total Amount</th>
                                <th>Last Sale</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($sales as $sale)
                                <tr>
                                    <td>{{ $sale->product_name }}</td>
                                    <td>{{ $sale->number_of_sales }}</td>
                                    <td>{{ $sale->total_quantity }}</td>
                                    <td>₹{{ number_format($sale->total_amount, 2) }}</td>
                                    <td>{{ \Carbon\Carbon::parse($sale->last_sold)->timezone('Asia/Kolkata')->format('M d, Y h:i:s A') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
    
    <!-- Recent individual transactions -->
    <div class="card mt-4">
        <div class="card-header">
            <h4 class="mb-0"><i class="fas fa-history"></i> Recent Transactions</h4>
        </div>
        <div class="card-body">
            @if(isset($recentSales) && $recentSales->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-sm table-striped">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Amount</th>
                                <th>Sold At</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentSales as $s)
                                <tr>
                                    <td>{{ optional($s->product)->name ?? '—' }}</td>
                                    <td>{{ $s->quantity }}</td>
                                    <td>₹{{ number_format($s->total_price, 2) }}</td>
                                    <td>{{ optional($s->sold_at) ? \Carbon\Carbon::parse($s->sold_at)->timezone('Asia/Kolkata')->format('M d, Y h:i:s A') : '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info">No recent transactions to show.</div>
            @endif
        </div>
    </div>
</div>
@endsection
