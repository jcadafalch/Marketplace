@extends('layouts.master')

@section('title', 'Perfil')

@section('content')
    <div class="profile">
        <div class="user-content">
            <div class="user-img">
                <img src="{{ asset('storage/img/profile/profileImg' . Auth::user()->id . '.jpg') }}" onerror="this.src='{{ asset('storage/img/profile/defaultProfileImage.jpg') }}'" alt="Imagen de perfil">
            </div>

            <div class="user-info">
                <p class="user-name">{{Auth::user()->name}}</p>

                <a href={{ route('user.profile') }}><button class="button-changeProfile">Modificar perfil</button></a>
                <a href={{ route('shop.createNewShop') }}><button class="button-newShop">Mi tienda</button></a>
            </div>

        </div>


    @endsection