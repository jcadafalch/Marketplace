@extends('layouts.master')

@section('title', 'Tu tienda')

@section('content')
    
    @if ($shop->getBanner() != null)
        <nav class="shop-banner">
            <img class="shop-banner-image" src="{{ asset('storage/img/shopProfileBanner/' . $shop->getBanner()->url) }}"
                onerror="this.src='{{ asset('/images/imagesNotFound.webp') }}'" alt="Banner de la tienda">
        </nav>
    @endif
    <section class="shop-body">
        <article class="shop-info">
            <div class="shop-info-detail-shop">
                <div class="shop-info-detail-shop-img">
                    <img src="{{ asset('storage/img/shopProfile/' . $shop->getLogo()->url) }}"
                        onerror="this.src='{{ asset('/images/imagesNotFound.webp') }}'" alt="Logo de la tienda">
                </div>
                <p> {{ $shop->name }} </p>
            </div>
            <div class="shop-info-detail-seller">
                <div class="shop-info-detail-seller-img">
                    <img src="{{ asset('storage/img/profile/' . strval($shop->getOwner()->path)) }}"
                        onerror="this.src='{{ asset('/images/imagesNotFound.webp') }}'" alt="Imagen de perfil del vendedor">
                </div>
                <p>{{ $shop->ownerName }}</p>
            </div>
        </article>
        {{-- <article class="shop-description">
            <h4>Mensaje de la Tienda:</h4> --}}
            {{-- <input type="checkbox" id="expanded" name="expanded"> --}}
            {{-- <p>{{ $shop->ownerName }}</p> --}}
            {{-- <label for="expanded" role="button">Leer más</label> --}}
            {{-- <div class="shop-description-button">
                <label for="expanded" role="button" data-more="Leer más..." data-less="Leer menos..."></label>
            </div> --}}
        {{-- </article> --}}
        @if ($shop->description != null)
            <article class="shop-description">
                <h4>Mensaje de la Tienda:</h4>
                {{-- <input type="checkbox" id="expanded" name="expanded"> --}}
                <p> {{ $shop->description }} </p>
                {{-- <label for="expanded" role="button">Leer más</label> --}}
                {{-- <div class="shop-description-button">
                    <label for="expanded" role="button" data-more="Leer más..." data-less="Leer menos..."></label>
                </div> --}}
            </article>
        @endif
        <article class="shop-products">
            <h4>Todos los productos</h4>

            <ul class="products-section">
                @foreach ($productsShop as $key => $product)
                    <li class="product" id="{{ $product->id }}">
                        <div class="product-image">
                            <a href="{{ route('product.show', ['id' => $product->id]) }}">
                                @if ($product->getMainImage() != null)
                                    <img src="{{ $product->getMainImage()}}"
                                        alt="Imagen del producto" />
                                @else
                                    <img src="{{ asset('/images/imagesNotFound.webp') }}"
                                        alt="Imagen del producto" />
                                @endif
                            </a>
                        </div>
                        <div class="product-details">
                            <a href="{{ route('product.show', ['id' => $product->id]) }}">
                                <p class="product-name"> {{ $product->name }} </p>
                                <p class="product-price"> {{ $product->price }}€ </p>
                            </a>
                        </div>

                        <input class="button-addToCart" type="button" value="Añadir" id="{{ $product->id }}">
                    </li>
                @endforeach
            </ul>
        </article>
        {{ $productsShop->links('vendor.pagination.default') }}
    </section>
@endsection
