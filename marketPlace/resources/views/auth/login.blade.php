@extends('layouts.masterAuth')

@section('title', 'Login')

@section('content')
<div class= "userForm">
    <div class="userForm-title" >
    <a href="{{ route('home.index') }}"><img class='userForm-logo' src="{{ asset('/images/logo.png') }}" alt="Logo" /></a>
    </div>
    <form class="userForm-form" method="">
        @csrf
        <div class="userForm-form-label">
            <label>Iniciar sesión</label>
        </div>
        <div class="userForm-form-item">
            <p>Dirección de E-Mail</p>            
            <input type="text" name="mail">
        </div>
        <div class="userForm-form-item">
            <p>Contraseña</p>            
            <input type="email" name="mail">
        </div>
        <div class="userForm-form-button">
            <button class="button-form" type="submit">Iniciar sesión</button>
        </div>
        <div class="userForm-form-help">
            <p>¿No tienes cuenta?</p>
            <p><a href="{{Route("auth.register")}}">¡Registrate ahora!</a></p>
        </div>
    </form>
</div>
@endsection