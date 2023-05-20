@extends('layouts.master')

@section('title', 'Editar tienda')

@section('content')
    {{-- <form action="{{ route('volver') }}" method="GET">
        <button type="submit" class="volver">Volver</button>
    </form> --}}
    <form action="{{ route('shop.editConfiguration') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <section class="shopedit-banner">
            <div class="shopedit-banner-upload">
                <div class="shopedit-banner-edit">
                    <input type='file' id="bannerUpload" class="imageUpload" name="shopBanner"
                        accept=".png, .jpg, .jpeg" />
                    <label for="bannerUpload"></label><span>Añadir banner</span>
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
        </section>
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
                                @if  ($shop->getLogo() == null)
                                <img id="shopLogo" class="imageUploaded"
                                    src='{{ asset('images/imagesNotFound.webp') }}' alt="Logo de la tienda">
                                @else
                                    <img id="shopLogo" class="imageUploaded"
                                    src="{{ asset('storage/img/shopProfile/' . $shop->getLogo()->url) }}"
                                    alt="Logo de la tienda">
                                @endif    
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
                <p>Mensaje de la Tienda:</p>
                <textarea name="shopDescription" maxlength="250" placeholder="Descripción de la tienda" onkeyup="countChars(this);">{{ $shop->description }}</textarea>
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
        </section>
    </form>

    <section class="shop-body">
        <form method="post">
            <article class="shop-products">
                <h4>Todos los productos</h4>

                <ul class="products-section">
                    <li class="product-edit-link">
                        <a href="{{ route('shop.newProduct') }}">Añadir Producto</a>
                    </li>
                    @foreach ($products as $key => $product)
                        <li class="{{ $product->isVisible == true ? 'product edit enabled' : 'product edit dissabled' }}"
                            {{-- id="{{ $product->id }}" --}}>
                            <div class="edit-list" id="{{ $product->id }}">
                                <input type="button" class="edit-list-ableDissable" name="deshabilitar"
                                    value="deshabilitar" id="deshabilitar-{{ $product->id }}">
                                <label title="Deshabilitar" class='dissable'
                                    for="deshabilitar-{{ $product->id }}"></label>
                                <input type="button" class="edit-list-ableDissable" name="habilitar" value="habilitar" id="habilitar-{{ $product->id }}">
                                <label title="Habilitar" class='able' for="habilitar-{{ $product->id }}"></label>
                                <input type="button" class="edit-list-ableDissable" name="eliminar" value="eliminar" id="eliminar-{{ $product->id }}">
                                <label title="Eliminar" class='delete' for="eliminar-{{ $product->id }}"></label>
                                <br>
                                <input type="button" class="edit-list-ableDissable" name="up" value="up" id="up-{{ $product->id }}">
                                <label title="Mover" class='up' for="up-{{ $product->id }}"
                                    style="{{ $product->order == $firstOrder ? 'display:none;' : '' }}"></label>
                                <input type="button" class="edit-list-ableDissable" name="down" value="down" id="down-{{ $product->id }}">
                                <label title="Mover" class='down' for="down-{{ $product->id }}"
                                    style="{{ $product->order == $lastOrder ? 'display:none;' : '' }}"></label>
                            </div>
                            <div class="product-image">
                                <a href="{{ route('product.show', ['id' => $product->id]) }}">
                                    <img src="{{ env('API_URL_IMAGES') . $product->getMainImage() }}"
                                        alt="Imagen de producto" />
                                </a>
                            </div>
                            <div class="product-details">
                                <a href="{{ route('product.show', ['id' => $product->id]) }}">
                                    <p class="product-name"> {{ $product->name }} </p>
                                    <a href="{{ route('shop.editProductContent', ['id' => $product->id]) }}">
                                        <p class="product-editar">Editar</p>
                                    </a>
                                    <p class="product-price"> {{ round($product->price / 100, 2) }}€ </p>
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
