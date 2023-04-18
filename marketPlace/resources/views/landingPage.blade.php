@extends('layouts.master')

@section('title', 'Show')

@section('content')

    <div class='landing'>
        <div>
            <ul class="landing-products">
                @for ($i = 0; $i < count($titles); $i++)
                    <h3>{{ $titles[$i] }}</h3>

                    @for ($j = 0; $j < count($products); $j++)
                        @if ($i == $j)
                            @foreach ($products[$j] as $item)
                                <img src="{{ asset('storage/img/' . $item->url) }}" width="10%" />
                            @endforeach
                        @endif
                    @endfor

                @endfor
            </ul>
        </div>
    </div>

@endsection
