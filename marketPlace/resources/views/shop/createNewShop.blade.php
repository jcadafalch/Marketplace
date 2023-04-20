@extends('layouts.master')

@section('title', 'Crear tienda')

@section('content')
    <div class="userForm">
        <div class="userForm-title">
            <div class="userForm-form-label">
                <label>Dar de alta tu tienda</label>
            </div>
        </div>
        <form class="userForm-form" action="{{ route('register.createNewShop') }}" method="post">
            @csrf
            <div class="userForm-form-item">
                <p>Nombre de la tienda</p>
                <input type="text" name="shopName" value="{{ old('shopName') }}">
            </div>
            <div class="userForm-form-item">
                <p>Nombre completo</p>
                <input type="text" name="name" value="{{ old('name') }}">
            </div>
            <div class="userForm-form-item">
                <p>Nif o Dni</p>
                <input type="text" name="nif" value="{{ old('nif') }}">
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Enviar</button>
            </div>
             @if ($errors->any())
            <div class="userForm-form-item">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="userForm-form-error" >{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </form>
    </div>
@endsection