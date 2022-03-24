@extends('master.master')

@section('content')
<div class="container">
    <h3> {{ $title }}</h3>
    <div class="pilihan" style="margin-bottom: 15px">
        <form role="form" method="get" action="{{ url('order/laporan/tampilkan') }}">
        <select name="customer" id="">
            <option value=""> -- Pilih Customer -- </option>
            @foreach ($cust as $row)
                <option value="{{ $row->code }}">{{ $row->name }}</option>
            @endforeach
        </select>
        <input type="date" name="tanggal" placeholder="Pilih Tanggal"/>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
        </form>
        <form role="form" method="get" action="{{ url('order/laporan/customer') }}">
            <button type="submit" class="btn btn-default">Clear</button>
        </form>
    </div>
    
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th width="30px">No</th>
                <th>Customer</th>
                <th>Customer Name</th>
                <th>Date</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        @foreach ($laporan as $no => $row) 
        <tbody>
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $row->customer_id }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->date }}</td>
                <td>{{ $row->qty }}</td>
                <td>{{ number_format($row->total) }}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
</div>
@endsection