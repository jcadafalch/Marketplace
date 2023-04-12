@extends('layouts.master')

@section('title', 'Perfil')

@section('content')
 <div class="userForm">
            <div class="title">
                <h2>Perfil publico</h2>
            </div>

            <div></div>

            <a href={{route('user.profile')}}><button>Modificar perfil</button></a>
            <a href={{route('shop.createNewShop')}}><button>Mi tienda</button></a>

    </div>


@endsection