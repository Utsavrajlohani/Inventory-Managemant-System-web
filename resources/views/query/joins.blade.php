@extends('layouts.app')

@section('content')
    <h1>Join example</h1>

    <h3>Products with eager-loaded supplier (Eloquent)</h3>
    <ul>
        @foreach($products as $p)
            <li>{{ $p->name }} — {{ $p->supplier?->name ?? '-' }}</li>
        @endforeach
    </ul>

    <h3>Query Builder join results</h3>
    <ul>
        @foreach($joined as $j)
            <li>{{ $j->product_name }} — {{ $j->supplier_name }}</li>
        @endforeach
    </ul>

    <!-- Executed queries removed from view to avoid leaking debug output -->

@endsection
