@extends('layouts.master')

@section('title', 'Perfil')

@section('content')
    <section class="profile">
        <article class="user-content">
            <div class="user-img">
                <div class="user-img-imagePreview">
                    <img src="{{ asset('storage/img/profile/' . Auth::user()->path) }}"
                        onerror="this.src='{{ asset('images/imagesNotFound.webp') }}'" alt="Imagen de perfil">
                </div>
            </div>
            <div class="user-info">
                <p class="user-name">{{ Auth::user()->name }}</p>

                <a href={{ route('user.profile') }}><p class="button-UserProfile">Modificar perfil</p></a>
                @if ($shop != null)
                    <a href={{ route('shop.show', ['shopName' => $shop->name]) }}><p class="button-UserProfile">Mi
                            tienda</p></a>
                    <a href={{ route('shop.edit') }}><p class="button-UserProfile">Editar mi tienda</p></a>
                @else
                    <a href={{ route('shop.createNewShop') }}><p class="button-UserProfile">Mi tienda</p></a>
                @endif
            </div>
        </article>
        <article class="user-order">
            <a href="{{ route('order.orderList') }}"><p>Lista de pedidos Realizados</p></a>
            @if ($shop != null)
                <a href="{{ route('order.selledList') }}"><p>Lista de pedidos vendidos</p></a>
            @endif
        </article>
    </section>
@endsection
