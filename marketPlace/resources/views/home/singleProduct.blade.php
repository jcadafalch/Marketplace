@extends('layouts.master')

@section('title', 'Show')

@section('content')
    <section class="product-detailsPage" id="{{ $product->id }}">
        <article>
            <div class="slider">
                <div class="slide_viewer">
                    <div class="slide_group">
                        <div class="slide">
                            @if ($product->getMainImage() != null)
                                <img class="product-images-img"
                                    src="{{ $product->getMainImage()}}" />
                            @else
                                <img class="product-images-img"
                                    src="{{ asset('/images/imagesNotFound.webp' . $product->getMainImage()) }}" />
                            @endif
                        </div>
                        @foreach ($product->getAlternativeImages() as $key => $imgUrl)
                            <div class="slide">
                                <img class="product-images-img" src="{{  $imgUrl }}" />
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="slide_buttons">
            </div>
        </article>

        <article class="product-details">
            <h3 class="product-name">{{ $product->name }}</h3>
            <p class="product-price">{{ round($product->price/100, 2) }} €</p>
            <p class="product-description">{{ $product->description }}</p>
            <p>
                Tienda:
                <a class="product-storeName" href="{{ route('shop.show', ['shopName' => $shop[0]->name]) }}"
                    target="_blank">
                    <em>{{ $shop[0]->name }}</em> </a>
            </p>
            <input class="button-addToCart" type="button" value="Añadir" width="100%" id="{{ $product->id }}">
        </article>
    </section>

    <script src="{{ asset('js/slider.js') }}"></script>
@endsection
