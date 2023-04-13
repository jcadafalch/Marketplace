@extends('layouts.master')

@section('title', 'Perfil')

@section('content')
    <div class="profile">
        <div class="user-content">
            <div class="user-img">
                <img src="{{ asset('storage/img/profileImg' .'1'. '.jpg') }}" alt="Girl in a jacket">
            </div>

            <div class="user-info">
                <p class="user-name">Nombre de usuario</p>

                <a href={{ route('user.profile') }}><button class="button-changeProfile">Modificar perfil</button></a>
                <a href={{ route('shop.createNewShop') }}><button class="button-newShop">Mi tienda</button></a>
            </div>

        </div>


    @endsection