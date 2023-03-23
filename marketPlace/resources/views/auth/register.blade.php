@extends('layouts.masterAuth')

@section('title', 'Recuperar Contraseña')

@section('content')
<div class= "userForm">
    <div class="userForm-title" >
    <a href="{{ route('home.index') }}"><img class='userForm-logo' src="{{ asset('/images/logo.png') }}" alt="Logo" /></a>
    </div>
    <form class="userForm-form" method="">
        @csrf
        <div class="userForm-form-label">
            <label>Registro</label>
        </div>
        <div class="userForm-form-item">
            <p>Nombre y Apellidos</p>            
            <input type="text" name="mail">
        </div>
        <div class="userForm-form-item">
            <p>E-Mail</p>            
            <input type="email" name="mail">
        </div>
        <div class="userForm-form-item">
            <p>Contraseña</p>            
            <input type="password" name="mail">
        </div>
        <div class="userForm-form-item">
            <p>Confirma tu contraseña</p>            
            <input type="password" name="mail">
        </div>
        <div class="userForm-form-button">
            <button class="button-form" type="submit">Enviar</button>
        </div>      
    </form>
</div>
@endsection