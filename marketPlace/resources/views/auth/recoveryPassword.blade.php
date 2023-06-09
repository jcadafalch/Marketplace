@extends('layouts.masterAuth')

@section('title', 'Recuperar Contraseña')

@section('content')
    <div class="userForm">
        <div class="userForm-title">
            <a href="{{ route('landingPage') }}"><img class='userForm-logo' src="{{ asset('/images/logo.png') }}"
                    alt="Logo" /></a>
        </div>
        <form class="userForm-form" method="post" action="{{ route('auth.recoveryPasswordSender') }}">
            @csrf
            <div class="userForm-form-label">
                <h3>Ayuda de contraseña</h3>
            </div>
            <div class="userForm-form-item">
                <label>Dirección de e-mail</label>
                <input type="email" name="email">
            </div>
            <div class="userForm-form-help">
                <p>Al enviar recibira un correo en un su email con todas las intrucciones,
                    <strong>Por favor verifique su bandeja de spam.</strong>
                </p>
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Enviar</button>
            </div>
            @if ($errors->has('email'))
                <p class="userForm-form-error">{{ $errors->first('email') }}</p>
            @endif
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    <p class="userForm-form-error">{{ Session::get('message') }}</p>
                </div>
            @endif
        </form>
    </div>
@endsection
