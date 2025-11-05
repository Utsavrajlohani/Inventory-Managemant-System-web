@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Sales Report</h1>
        <div>
            <a href="{{ route('reports.sales.export', request()->only(['start_date','end_date'])) }}" class="btn btn-sm btn-primary">Export CSV</a>
        </div>
    </div>

    <form method="GET" class="row g-2 mb-3">
        <div class="col-auto">
            <input type="date" name="start_date" value="{{ $start ?? '' }}" class="form-control" placeholder="Start date">
        </div>
        <div class="col-auto">
            <input type="date" name="end_date" value="{{ $end ?? '' }}" class="form-control" placeholder="End date">
        </div>
        <div class="col-auto">
            <button class="btn btn-secondary">Filter</button>
            <a href="{{ route('reports.sales') }}" class="btn btn-link">Reset</a>
        </div>
    </form>

    @if($summary->count())
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Total Quantity</th>
                    <th>Total Sales</th>
                </tr>
            </thead>
            <tbody>
                @foreach($summary as $s)
                    <tr>
                        <td>{{ $s->product_name }}</td>
                        <td>{{ $s->total_quantity }}</td>
                        <td>{{ number_format($s->total_sales,2) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p>No sales data available yet.</p>
    @endif
@endsection
