@extends('layouts.masterAuth')

@section('title', 'Registro')

@section('content')
    <div class="userForm">
        <div class="userForm-title">
            <a href="{{ route('landingPage') }}"><img class='userForm-logo' src="{{ asset('/images/logo.png') }}"
                    alt="Logo" /></a>
        </div>
        <form class="userForm-form" action="{{ route('auth.store') }}" method="post">
            @csrf
            <div class="userForm-form-label">
                <h3>Registro</h3>
            </div>
            <div class="userForm-form-item">
                <label for="nombreUsuario">Nombre de usuario</label>
                <input type="text" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required>

            </div>
            <div class="userForm-form-item">
                <label for="email">E-Mail</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="userForm-form-item">
                <label for="contraseña">Contraseña</label>
                <input type="password" name="contraseña" required>
            </div>
            <div class="userForm-form-item">
                <label for="confirmaContraseña">Confirma tu contraseña</label>
                <input type="password" name="confirmaContraseña" required>
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Registrase</button>
            </div>
            @if ($errors->any())
                <div class="userForm-form-item">
                    <ul class="userForm-form-error">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
        <div class="userForm-form-help already-account">
            <p>¿Ya tienes cuenta? <a href="{{ Route('auth.login') }}">Inicia sesión</a></p>
        </div>
    </div>
@endsection
