@extends('layouts.master')

@section('title', 'Editar tienda')

@section('content')

    <nav class="shop-banner">
        <img src="{{ asset('storage/img/banner.jpg') }}" alt="">
        {{-- <div class="avatar-upload">
            <div class="avatar-edit">
                <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                <label for="imageUpload"></label>
            </div>
            <div class="avatar-preview">
                <div id="imagePreview"
                    style="background-image: url({{ asset('storage/img/profile/' . Auth::user()->path) }});">
                </div>
            </div>
        </div> --}}
    </nav>
    <section class="shop-body">
        <article class="shop-info">
            <div class="shop-info-detail-shop">
                {{-- <div class="shop-info-detail-shop-img">
                    <img src="{{ asset('storage/img/profile/' . Auth::user()->path ) }}" alt="Imagen de perfil">
                </div> --}}
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload"></label>
                    </div>
                    <div class="avatar-preview">
                        <div id="imagePreview"
                            style="background-image: url({{ asset('storage/img/profile/' . Auth::user()->path) }});">
                        </div>
                    </div>
                </div>
                <p>Nombre de Tienda</p>
            </div>
            <div class="shop-info-detail-seller">
                {{-- <div class="shop-info-detail-seller-img">
                    <img src="{{ asset('storage/img/profile/' . Auth::user()->path ) }}"
                        onerror="this.src='{{ asset('storage/img/profile/defaultProfileImage.jpg') }}'"
                        alt="Imagen de perfil">
                </div> --}}
                <div class="user-img">
                    <div class="user-img-imagePreview"
                        style="
                        background-image: url({{ asset('storage/img/profile/' . Auth::user()->path) }}), url({{ asset('storage/img/profile/defaultProfileImage.jpg') }});">
                    </div>
                </div>
                <p>Nombre Usuario</p>
            </div>
        </article>
        <article class="shop-description-edit" style="margin: 5rem 0 5rem 0;">
            <label for="shop-description">Mensaje de la Tienda:</label>
            <input type="text" name="shop-description">
        </article>
        <article class="shop-products">
            <h4>Todos los productos</h4>

            <ul class="products-section">
                <li class="product">
                    <a href="{{ route('shop.newProduct') }}">Añadir Producto</a>
                </li>
                @foreach ($products as $key => $product)
                    <li class="product" id="{{ $product->id }}">
                        <div class="product-image">
                            <a href="{{ route('product.show', ['id' => $product->id]) }}">
                                <img src="{{ asset('storage/img/' . $product->url) }}" />
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
        {{ $products->links('vendor.pagination.default') }}
    </section>
    
    <script src="{{ asset('js/profileImgPreview.js') }}"></script>
@endsection