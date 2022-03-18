@extends('layout')

@section('content')
    <h1>Shipped:</h1>
    <table class="table table-sm w-50">
        <tr>
            <th>Pack Size</th>
            <th>Qty</th>
        </tr>
        @foreach($orderedPackets as $packSize => $qty)
            <tr>
                <td>{{ $packSize }}</td>
                <td>{{ $qty }}</td>
            </tr>
        @endforeach
    </table>
@endsection
