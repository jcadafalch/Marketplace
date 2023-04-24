@extends('layouts.masterAuth')

@section('title', 'Login')

@section('content')
    <div class="userForm">
        <div class="userForm-title">
            <a href="{{ route('home.index') }}"><img class='userForm-logo' src="{{ asset('/images/logo.png') }}"
                    alt="Logo" /></a>
        </div>
        <form class="userForm-form" method="post">
            @csrf
            <div class="userForm-form-title">
                <h3>Iniciar sesión</h3>
            </div>
            <div class="userForm-form-item">
                <label>Dirección de E-Mail</label>
                <input type="email" name="email">
            </div>
            <div class="userForm-form-item">
                <label>Contraseña</label>
                <input type="password" name="password">
                <span><a href="{{ Route('auth.recoveryPassword') }}">¿Has olvidado la contraseña?</a></span>
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Iniciar sesión</button>
            </div>
        </form>
        <div class="userForm-form-help already-account">
            <p>¿No tienes cuenta? <a href="{{ Route('auth.register') }}">Registrate aquí</a></p>
        </div>
    </div>
@endsection
