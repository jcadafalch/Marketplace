@extends('layouts.master')

@section('title', 'Show')

@section('content')

    <div>
        <img src="{{ asset('storage/img/' . $product->url) }}" />

        <h4>{{ $product->name }}</h4>
        <p>{{ $product->description }}</p>
        <p>{{ $product->price }}</p>

    </div>

@endsection
