@extends('layouts.master')

@section('title', 'Craft Made')

@section('content')
    <section class='landing'>
        @for ($i = 0; $i < count($titles); $i++)
            <div class="landing-card">
                <h2 class="landing-title">{{ $titles[$i] }}</h2>
                <ul class="landing-products">
                    @php
                        $cont = 0;
                    @endphp
                    @foreach ($products[$i] as $item)
                        @if ($cont < 8)
                            <li>
                                <a href="{{ route('product.show', ['id' => $item->id]) }}"><img class="landing-image"
                                        src="{{ env('API_URL_IMAGES') . $item->url }}" alt="Imagen de producto" />
                                    <p>{{ $item->name }}</p>
                                    <p>{{ round($item->price / 100, 2) }}€</p>
                                </a>
                            </li>
                            @php
                                $cont++;
                            @endphp
                        @endif
                    @endforeach
                </ul>
                <a class="button-landing" id="{{ $i }}" href="{{ route('landingPage.showAll', ['id' => $i]) }}">
                    Ver todo </a>
            </div>
        @endfor
    </section>

@endsection
