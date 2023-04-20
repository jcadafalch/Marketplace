@extends('layouts.master')

@section('title', 'Craft Made')

@section('content')

    <div class='landing'>
        <div>

            @for ($i = 0; $i < count($titles); $i++)
                <ul class="landing-card">
                    <div class="landing-info">
                        <h3 class="landing-title">{{ $titles[$i] }}</h3>
                        <a id="{{ $i }}" href="{{ route('landingPage.showAll', ['id' => $i]) }}"><button
                                class="button-landing"> Ver todo </button></a>
                    </div>
                    @foreach ($products[$i] as $item)
                        @if ($i < 4)
                            <a href="{{ route('product.show', ['id' => $item->id]) }}"><img class="landing-image"
                                    src="{{ asset('storage/img/' . $item->url) }}" /></a>
                        @endif
                    @endforeach
                </ul>
            @endfor

        </div>
    </div>

@endsection
