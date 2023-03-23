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
            <label>Ayuda de contraseña</label>
        </div>
        <div class="userForm-form-item">
            <p>Dirección de e-mail</p>            
            <input type="mail" name="mail">
        </div>
        <div class="userForm-form-help">
            <p>Al enviar recibira un correo en un su email con todas las intrucciones,
            <strong>Por favor verifique su bandeja de spam.</strong></p>
        </div>
        <div class="userForm-form-button">
            <button class="button-form" type="submit">Enviar</button>
        </div>      
    </form>
</div>
@endsection