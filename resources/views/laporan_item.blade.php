@extends('master.master')

@section('content')
<div class="container">
    <h3> {{ $title }}</h3>
    <div class="pilihan" style="margin-bottom: 15px">
        <form role="form" method="get" action="{{ url('order/laporan/filter') }}">
        <select name="item" id="">
            <option value=""> -- Pilih Item -- </option>
            @foreach ($item as $row)
                <option value="{{ $row->code }}">{{ $row->name }}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-primary">Tampilkan</button>
        </form>
        <form role="form" method="get" action="{{ url('order/laporan/item') }}">
            <button type="submit" class="btn btn-default">Clear</button>
        </form>
    </div>
    
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th width="30px">No</th>
                <th>Item</th>
                <th>Item Name</th>
                <th>Qty</th>
                {{-- <th>AVG</th> --}}
                <th>Total</th>
            </tr>
        </thead>
        @foreach ($laporan as $no => $row) 
        {{-- @php $avg = $row->total/$row->qty @endphp --}}
        
        <tbody>
            <tr>
                <td>{{ ++$no }}</td>
                <td>{{ $row->code }}</td>
                <td>{{ $row->name }}</td>
                <td>{{ $row->qty }}</td>
                {{-- <td>{{ $avg }}</td> --}}
                <td>{{ $row->total }}</td>
            </tr>
        </tbody>
        @endforeach
    </table>
</div>
@endsection