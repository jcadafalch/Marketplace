@extends('layouts.master')

@section('title', 'Editar tienda')

@section('content')
    <form action="{{ route('shop.editConfiguration') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <section class="shopedit-banner">
            <div class="shopedit-banner-upload">
                <div class="shopedit-banner-edit">
                    <input type='file' id="bannerUpload" class="imageUpload" name="shopBanner" accept=".png, .jpg, .jpeg" />
                    <label for="bannerUpload"></label><span>Añadir banner</span>
                    @if ($shop->getBanner() != null)
                    <input type='button' id="bannerDelete" name="shopBannerDelete"  />
                    <label for="bannerDelete"></label><span>Eliminar banner</span>
                    @endif
                </div>
                <div class="shopedit-banner-preview">
                    <div class="shopedit-banner-imagePreview imagePreview">
                        @if ($shop->getBanner() != null)
                            <img class="shop-banner-image imageUploaded"
                                src="{{ asset('storage/img/shopProfileBanner/' . $shop->getBanner()->url) }}"
                                alt="Banner de la tienda">
                        @else
                            <img class="shop-banner-image imageUploaded" src="{{ asset('/images/imagesNotFound.webp') }}"
                                alt="Banner de la tienda">
                        @endif
                    </div>
                </div>
            </div>
            <section class="shop-body">
                <article class="shop-info">
                    <div class="shop-info-detail-shop">
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' id="shopLogoUpload" class="imageUpload" name="profileImg"
                                    accept=".png, .jpg, .jpeg" />
                                <label for="shopLogoUpload"></label>
                            </div>
                            <div class="avatar-preview">
                                <div class="shop-info-detail-shop-img imagePreview">
                                    <img id="shopLogo" class="imageUploaded"
                                        src="{{ asset('storage/img/shopProfile/' . $shop->getLogo()->url) }}"
                                        onerror="this.src='{{ asset('images/imagesNotFound.webp') }}'"
                                        alt="Logo de la tienda">
                                </div>
                            </div>
                        </div>
                        <p>{{ $shop->name }}</p>
                    </div>
                    <div class="shop-info-detail-seller">
                        <div class="user-img">
                            <div class="user-img-imagePreview">
                                <img src="{{ asset('storage/img/profile/' . Auth::user()->path) }}"
                                    onerror="this.src='{{ asset('images/imagesNotFound.webp') }}'" alt="Imagen de perfil">
                            </div>
                        </div>
                        <p>{{ Auth::user()->name }}</p>
                    </div>
                </article>

                <article class="shop-description-edit">
                    <label for="shop-description">Mensaje de la Tienda:</label>
                    <textarea type="text" name="shopDescription" maxlength="250" placeholder="Descripción de la tienda"
                        onkeyup="countChars(this);">{{ $shop->description }}</textarea>
                    <p id="char_counter"></p>
                </article>
                <div class="userForm-form-item">
                    <ul class="userForm-form-error">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                <button class="button-UserProfile" type="submit">Guardar Cambios</button>
    </form>

    <form action="" method="post">
        <article class="shop-products">
            <h4>Todos los productos</h4>

            <ul class="products-section">
                <li class="product-edit-link">
                    <a href="{{ route('shop.newProduct') }}">Añadir Producto</a>
                </li>
                @foreach ($products as $key => $product)
                    <li class="product edit" id="{{ $product->id }}">
                        <div class="edit-list">
                            <input type="button" class="edit-list-ableDissable" name="deshabilitar">
                            <label title="Deshabilitar" class='dissable' id="{{ $product->id }}"
                                for="deshabilitar"></label>
                            <input type="button" class="edit-list-ableDissable" name="habilitar">
                            <label title="Habilitar" class='able' for="habilitar" id="{{ $product->id }}"></label>
                            <input type="button" class="edit-list-ableDissable" name="eliminar">
                            <label title="Eliminar" class='delete' for="eliminar" id="{{ $product->id }}"></label>
                            <br>
                            <input type="button" class="edit-list-ableDissable" name="up">
                            <label title="Mover" class='up' for="up" id="{{ $product->id }}"></label>
                            <input type="button" class="edit-list-ableDissable" name="down">
                            <label title="Mover" class='down' for="down" id="{{ $product->id }}"></label>
                        </div>
                        <div class="product-image">
                            <a href="{{ route('product.show', ['id' => $product->id]) }}">
                                <img src="{{ env('API_URL_IMAGES') . $product->getMainImage() }}" />
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
    <script src="{{ asset('js/editProducts.js') }}"></script>
    <script src="{{ asset('js/charCounter.js') }}"></script>
@endsection
