@extends('layout')

@section('content')
    <h1>Willy's Widgets</h1>
    <h2>Ordered package calculator</h2>
    <form action="packs" method="POST">
        @csrf
        <input type="number" name="ordered-packs" placeholder="Input ordered packs"/>
        <button type="submit">Submit</button>
    </form>
@endsection
