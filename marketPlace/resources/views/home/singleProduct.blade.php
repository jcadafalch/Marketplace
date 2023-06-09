@extends('layouts.master')

@section('title', 'Show')

@section('content')
    <section class="product-detailsPage" {{--id="{{ $product->id }}"--}}>
        <article>
            <div class="slider">
                <div class="slide_viewer">
                    <div class="slide_group">
                        <div class="slide">
                            @if ($product->getMainImage() != null)
                                <img class="product-images-img"
                                    src="{{ env('API_URL_IMAGES') . $product->getMainImage()}}" alt="Imagen principal de producto" />
                            @else
                                <img class="product-images-img"
                                    src="{{ asset('/images/imagesNotFound.webp') }}" alt="Imagen no encontrada" />
                            @endif
                        </div>
                        @foreach ($product->getAlternativeImages() as $key => $imgUrl)
                            <div class="slide">
                                <img class="product-images-img" src="{{env('API_URL_IMAGES') . $imgUrl }}" alt="Imagen de producto"/>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="slide_buttons">
            </div>
        </article>

        <article class="product-details">
            <h3 class="product-nameSingle">{{ $product->name }}</h3>
            <p class="product-price">{{ round($product->price/100, 2) }} €</p>
            <p class="product-description">{{ $product->description }}</p>
            <p>
                Tienda:
                <a class="product-storeName" href="{{ route('shop.show', ['shopName' => $shop[0]->name]) }}"
                    target="_blank">
                    <em>{{ $shop[0]->name }}</em> </a>
            </p>
            <input class="button-addToCart" type="button" value="Añadir" id="{{ $product->id }}">
        </article>
    </section>

    <script src="{{ asset('js/slider.js') }}"></script>
@endsection
