@extends('layouts.master')

@section('title', 'Home')

@section('content')

    {{-- <div>
        @foreach ($products as $key => $product)
            <div>
                <img src="{{ $product->image }}" style="height:200px" />
                <h4>
                    {{ $product->name }}
                </h4>
                @include('catalog.partials.catalog')
            </div>
        @endforeach
    </div> --}}
    Home
@endsection
