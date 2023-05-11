@extends('layouts.master')

@section('title', 'Craft Made')

@section('content')
    <section class='landing'>
        @for ($i = 0; $i < count($titles); $i++)
            <article class="landing-card">
                <h2 class="landing-title">{{ $titles[$i] }}</h2>
                <ul class="landing-products">
                    @foreach ($products[$i] as $item)
                        @if ($i < 8)
                            <li>
                                <a href="{{ route('product.show', ['id' => $item->id]) }}"><img class="landing-image"
                                        src="{{ asset('storage/img/' . $item->url) }}" />
                                    <p>{{ $item->name }}</p>
                                    <p>{{ $item->price }}€</p>
                                </a>
                            </li>
                        @endif
                    @endforeach
                </ul>
                <a id="{{ $i }}" href="{{ route('landingPage.showAll', ['id' => $i]) }}"><button
                        class="button-landing"> Ver todo </button></a>
            </article>
        @endfor
    </section>

@endsection
