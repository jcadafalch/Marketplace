@extends('layouts.master')

@section('title', 'Editar tienda')

@section('content')
    <form action="" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')
        <section class="shop-banner">
            <div class="avatar-upload">
                {{-- <img src="{{ asset('storage/img/banner.jpg') }}" alt=""> --}}
                <input type="file" name="shopBanner">
                <label for="shopBanner">Banner para mostrar tu marca y tus anuncios</label>
            </div>
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
        </section>
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
                            {{-- style="background-image: url({{ asset('storage/img/profile/' . Auth::user()->path) }});" --}}
                            <div id="imagePreview" class="shop-info-detail-shop-img">
                                <img id="imagenPrueba" src="{{ asset('storage/img/profile/' . Auth::user()->path) }}"
                                    alt="Imagen de perfil">
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
            <input type="button" value="Guardar Cambios" class="button-changeProfile">
    </form>

    <form action="" method="post">
        <article class="shop-products">
            <h4>Todos los productos</h4>

            <ul class="products-section">
                <li class="product">
                    <a href="{{ route('shop.newProduct') }}">Añadir Producto</a>
                </li>
                @foreach ($products as $key => $product)
                    <li class="product button-edit" id="{{ $product->id }}">
                        <div class="button-edit-list">
                            <input type="button" class="button-ableDissable" name="deshabilitar">
                            <label for="deshabilitar"></label>
                            <input type="button" class="button-ableDissable" name="habilitar">
                            <label for="habilitar"></label>
                            <input type="button" class="button-ableDissable" name="eliminar">
                            <label for="eliminar"></label>
                        </div>
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
                    </li>
                @endforeach
            </ul>
        </article>
    </form>
    {{ $products->links('vendor.pagination.default') }}
    </section>
    <script src="{{ asset('js/profileImgPreview.js') }}"></script>
@endsection
