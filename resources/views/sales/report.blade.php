@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4">
        <div class="col">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0"><i class="fas fa-chart-line"></i> Sales Report</h4>
                    <div class="btn-group">
                        <a href="{{ route('sales.report.period', 'daily') }}" 
                           class="btn btn-outline-primary {{ $period == 'daily' ? 'active' : '' }}">
                            <i class="fas fa-calendar-day"></i> Daily
                        </a>
                        <a href="{{ route('sales.report.period', 'weekly') }}" 
                           class="btn btn-outline-primary {{ $period == 'weekly' ? 'active' : '' }}">
                            <i class="fas fa-calendar-week"></i> Weekly
                        </a>
                        <a href="{{ route('sales.report.period', 'monthly') }}" 
                           class="btn btn-outline-primary {{ $period == 'monthly' ? 'active' : '' }}">
                            <i class="fas fa-calendar-alt"></i> Monthly
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($sales->isEmpty())
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle"></i> No sales data available for this period.
                        </div>
                    @else
                        @foreach($sales as $date => $periodData)
                            <div class="card mb-3">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">
                                        @if($period == 'daily')
                                            {{ $periodData['period_start']->format('F d, Y') }}
                                        @elseif($period == 'weekly')
                                            {{ $periodData['period_start']->format('M d') }} - 
                                            {{ $periodData['period_end']->format('M d, Y') }}
                                        @else
                                            {{ $periodData['period_start']->format('F Y') }}
                                        @endif
                                    </h5>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table class="table table-striped mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Product</th>
                                                    <th class="text-center">Number of Sales</th>
                                                    <th class="text-center">Total Quantity</th>
                                                    <th class="text-end">Total Amount</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($periodData['products'] as $product)
                                                    <tr>
                                                        <td>{{ $product['product_name'] }}</td>
                                                        <td class="text-center">{{ $product['number_of_sales'] }}</td>
                                                        <td class="text-center">{{ $product['total_quantity'] }}</td>
                                                        <td class="text-end">₹{{ number_format($product['total_amount'], 2) }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr class="fw-bold">
                                                    <td>Total</td>
                                                    <td class="text-center">
                                                        {{ collect($periodData['products'])->sum('number_of_sales') }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ collect($periodData['products'])->sum('total_quantity') }}
                                                    </td>
                                                    <td class="text-end">
                                                        ₹{{ number_format(collect($periodData['products'])->sum('total_amount'), 2) }}
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection