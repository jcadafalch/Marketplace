@extends('layouts.master')

@section('title', 'Perfil')

@section('content')
    <section class="profile">
        <article class="user-content">
            {{-- <div class="user-img">
                <img src="{{ asset('storage/img/profile/' . Auth::user()->path) }}"
                    onerror="this.src='{{ asset('storage/img/profile/defaultProfileImage.jpg') }}'" alt="Imagen de perfil">
            </div> --}}
            <div class="user-img">
                <div class="user-img-imagePreview">
                    <img src="{{ asset('storage/img/profile/' . Auth::user()->path) }}"
                        onerror="this.src='{{ asset('images/imagesNotFound.webp') }}'" alt="Imagen de perfil">
                </div>
            </div>
            <div class="user-info">
                <p class="user-name">{{ Auth::user()->name }}</p>

                <a href={{ route('user.profile') }}><button class="button-UserProfile">Modificar perfil</button></a>
                @if ($shop != null)
                    <a href={{ route('shop.show', ['shopName' => $shop->name]) }}><button class="button-UserProfile">Mi
                            tienda</button></a>
                    <a href={{ route('shop.edit') }}><button class="button-UserProfile">Editar mi tienda</button></a>
                @else
                    <a href={{ route('shop.createNewShop') }}><button class="button-UserProfile">Mi tienda</button></a>
                @endif
            </div>
        </article>
    </section>
@endsection
