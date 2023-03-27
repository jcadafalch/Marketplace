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
    </form>
    <div class="userForm-form-help already-account">
        <p>¿No tienes cuenta? <a href="{{Route("auth.register")}}">Registrate aquí</a></p>
    </div>
</div>
@endsection