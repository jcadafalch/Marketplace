@extends('layouts.master')

@section('title', 'Show')

@section('content')

    <div>

        {{-- TODO: Portada del llibre --}}
        <img src="{{ $product->url }}" style="height:200px"/>

        <h4>
            {{ $product->name }}
        </h4>
    </div>

@endsection
