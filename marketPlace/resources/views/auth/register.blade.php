@extends('layouts.masterAuth')

@section('title', 'Registre')

@section('content')
<div class= "userForm">
    <div class="userForm-title" >
    <a href="{{ route('home.index') }}"><img class='userForm-logo' src="{{ asset('/images/logo.png') }}" alt="Logo" /></a>
    </div>
    <form class="userForm-form" method="">
        @csrf
        <div class="userForm-form-label">
            <h3>Registro</h3>
        </div>
        <div class="userForm-form-item">
            <label>Nombre de usuario</label>            
            <input type="text" name="mail">
        </div>
        <div class="userForm-form-item">
            <label>E-Mail</label>            
            <input type="email" name="mail">
        </div>
        <div class="userForm-form-item">
            <label>Contraseña</label>            
            <input type="password" name="mail">
        </div>
        <div class="userForm-form-item">
            <label>Confirma tu contraseña</label>            
            <input type="password" name="mail">
        </div>
        <div class="userForm-form-button">
            <button class="button-form" type="submit">Registrase</button>
        </div>      
    </form>
    <div class="userForm-form-help already-account">
        <p>¿Ya tienes cuenta? <a href="{{Route("auth.login")}}">Inicia sesión</a></p>
    </div>
</div>
@endsection