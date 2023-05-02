@extends('layouts.master')

@section('title', 'Perfil')

@section('content')
    <section class="profile">
        <article class="user-content">
            <div class="user-img">
                <img src="{{ asset('storage/img/profile/' . Auth::user()->path) }}"
                    onerror="this.src='{{ asset('storage/img/profile/defaultProfileImage.jpg') }}'" alt="Imagen de perfil">
            </div>
            <div class="user-info">
                <p class="user-name">{{ Auth::user()->name }}</p>

                <a href={{ route('user.profile') }}><button class="button-changeProfile">Modificar perfil</button></a>
                <a href={{ route('shop.createNewShop') }}><button class="button-newShop">Mi tienda</button></a>
            </div>
        </article>
    </section>

@endsection
