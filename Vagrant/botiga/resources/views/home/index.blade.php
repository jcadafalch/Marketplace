@extends('layouts.master')

@section('title', 'Home')

@section('content')
    <section class="home-section">
        <div class="home-section-title">
            <h1> Todos los productos </h1>
            @if (!Route::is('landingPage.showAll'))
                <form id="form-order" action="{{ route('home.searchProduct') }}" method="get">
                    <input type="hidden" name="category" id="category" />
                    <input type="hidden" name="search" id="search" />
                    <select name="order" id="order">
                        <option value="" disabled selected hidden>Ordenar por</option>
                        <option value="ASC">A-Z</option>
                        <option value="DESC">Z-A</option>
                    </select>
                </form>
            @endif
        </div>
        <ul class="products-section">
            @foreach ($products as $key => $product)
                <li class="product" {{--id="{{ $product->id }}"--}}>
                    <div class="product-image">
                        <a href="{{ route('product.show', ['id' => $product->id]) }}">
                            @if ($product->getMainImage() != null)
                                <img src="{{ env('API_URL_IMAGES') . $product->getMainImage() }}" alt="Imagen de producto" />
                            @else
                                <img src="{{ asset('/images/imagesNotFound.webp') }}" alt="Imagen no encontrada"/>
                            @endif
                        </a>
                    </div>
                    <div class="product-details">
                        <a href="{{ route('product.show', ['id' => $product->id]) }}">
                            <p class="product-name"> {{ $product->name }} </p>
                            <p class="product-price"> {{ round($product->price / 100, 2) }}€ </p>
                        </a>
                    </div>
                    <input class="button-addToCart" type="button" value="Añadir" id="{{ $product->id }}">
                </li>
            @endforeach
        </ul>

        {{ $products->links('vendor.pagination.default') }}
    </section>
    <script src="{{ asset('js/orderBy.js') }}"></script>
@endsection
