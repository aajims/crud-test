@extends('master.master')

@section('content')
<div class="container">
    <h3> {{ $title }}</h3>
    
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th width="30px">No</th>
                <th>No Order</th>
                <th>Date</th>
                <th>Customer</th>
                <th>Customer Name</th>
                <th>Qty</th>
                <th>SubTotal</th>
                <th>Discount</th>
                <th>Total</th>
            </tr>
        </thead>
        @foreach ($lap as $no => $row) 
        <tbody>
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $row->no }}</td>
                <td>{{ $row->date }}</td>
                <td>{{ $row->customer_id }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ number_format($row->subtotal) }}</td>
                <td>{{ $row->discount }}</td>
                <td>{{ number_format($row->total) }}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
</div>
@endsection