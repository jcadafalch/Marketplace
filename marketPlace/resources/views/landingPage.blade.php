@extends('layouts.master')

@section('title', 'Show')

@section('content')

    <div class='landing'>
        <div>

            @for ($i = 0; $i < count($titles); $i++)
                <ul class="landing-card">
                    <h3 class="landing-title" >{{ $titles[$i] }}</h3>

                    @for ($j = 0; $j < /*count($products)*/ 4; $j++)
                        @if ($i == $j)
                            @foreach ($products[$j] as $item)
                                <a href="{{ route('product.show', ['id' => $item->id]) }}"><img class="landing-image" src="{{ asset('storage/img/' . $item->url) }}" /></a>
                            @endforeach
                        @endif
                    @endfor
                </ul>
            @endfor

        </div>
    </div>

@endsection
