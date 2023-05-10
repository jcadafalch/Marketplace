@extends('layouts.master')

@section('title', 'Editar tienda')

@section('content')
    <form action="{{ route('shop.editConfiguration') }}" method="post" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <section class="shopedit-banner">
            {{-- <div class="avatar-upload">
                <div class="avatar-edit">
                    <img src="{{ asset('storage/img/banner.jpg') }}" alt="">
                    <input type="file" name="shopBanner" id="imageUpload">
                    <label for="shopBanner">Banner para mostrar tu marca y tus anuncios</label>
                </div>
            </div> --}}
            <div class="shopedit-banner-upload">
                <div class="shopedit-banner-edit">
                    <input type='file' id="bannerUpload" name="shopBanner" accept=".png, .jpg, .jpeg" />
                    <label for="bannerUpload"></label><span>Banner para mostrar tu marca y tus anuncios</span>
                </div>
                <div class="shopedit-banner-preview">
                    <div class="shopedit-banner-imagePreview" id="bannerPreview">
                        @if($shop->getBanner() != null)
                        <img class="shop-banner-image"
                            src="{{ asset('storage/img/shopProfileBanner/' . $shop->getBanner()->url) }}"
                             alt="Banner de la tienda">
         
                            
                        @else
                        <img class="shop-banner-image"
                        src="{{ asset('/images/imagesNotFound.webp')}}" alt="Banner de la tienda">
                       
                        @endif
                    </div>
                </div>
            </div>

            {{-- <section class="shop-banner">
            <div class="avatar-upload">
                    <img src="{{ asset('storage/img/banner.jpg') }}" alt="">
                <input type="file" name="shopBanner">
                <label for="shopBanner">Banner para mostrar tu marca y tus anuncios</label>
            </div> --}}
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
            {{-- </section> --}}
            <section class="shop-body">
                <article class="shop-info">
                    <div class="shop-info-detail-shop">
                        {{-- <div class="shop-info-detail-shop-img">
                    <img src="{{ asset('storage/img/profile/' . Auth::user()->path ) }}" alt="Imagen de perfil">
                </div> --}}
                        <div class="avatar-upload">
                            <div class="avatar-edit">
                                <input type='file' id="imageUpload" name="profileImg" accept=".png, .jpg, .jpeg" />
                                <label for="imageUpload"></label>
                            </div>
                            <div class="avatar-preview">
                                {{-- style="background-image: url({{ asset('storage/img/profile/' . Auth::user()->path) }});" --}}
                                <div id="imagePreview" class="shop-info-detail-shop-img">
                                    <img id="shopLogo"
                                        src="{{ asset('storage/img/shopProfile/' . $shop->getLogo()->url) }}"
                                        onerror="this.src='{{ asset('images/imagesNotFound.webp') }}'"
                                        alt="Logo de la tienda">
                                </div>
                            </div>
                        </div>
                        <p>{{ $shop->name }}</p>
                    </div>
                    <div class="shop-info-detail-seller">
                        {{-- <div class="shop-info-detail-seller-img">
                    <img src="{{ asset('storage/img/profile/' . Auth::user()->path ) }}"
                        onerror="this.src='{{ asset('storage/img/profile/defaultProfileImage.jpg') }}'"
                        alt="Imagen de perfil">
                </div> --}}
                        <div class="user-img">
                            <div class="user-img-imagePreview">
                                {{-- style="
                        background-image: url({{ asset('storage/img/profile/' . Auth::user()->path) }}), url({{ asset('storage/img/profile/defaultProfileImage.jpg') }});"> --}}
                                <img src="{{ asset('storage/img/profile/' . Auth::user()->path) }}"
                                    onerror="this.src='{{ asset('images/imagesNotFound.webp') }}'" alt="Logo de la tienda">
                            </div>
                        </div>
                        <p>{{ Auth::user()->name }}</p>
                    </div>
                </article>

                <article class="shop-description-edit">
                    <label for="shop-description">Mensaje de la Tienda:</label>
                    <textarea type="text" name="shopDescription" maxlength="250" placeholder="{{ $shop->description }}"  onkeyup="countChars(this);"></textarea>
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
                <li class="product" style="
                width: 21rem;
                height: 28rem;
                display: flex;
                justify-content: center;
                font-size: 3rem;
                box-shadow: 3px 5px 0px 0px gray;
            ">
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
                        </div>
                        <div class="product-image">
                            <a href="{{ route('product.show', ['id' => $product->id]) }}">
                                <img src="{{ asset('storage/img/' . $product->getMainImage()) }}" />
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
