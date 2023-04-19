@extends('layouts.masterAuth')

@section('title', 'Registre')

@section('content')
    <div class="userForm">
        <div class="userForm-title">
            <a href="{{ route('home.index') }}"><img class='userForm-logo' src="{{ asset('/images/logo.png') }}"
                    alt="Logo" /></a>
        </div>
        <form class="userForm-form" action="{{ route('auth.store') }}" method="post">
            @csrf
            <div class="userForm-form-label">
                <label>Registro</label>
            </div>
            <div class="userForm-form-item">
                <p>Nombre de usuario</p>
                <input type="text" name="nombreUsuario" value="{{ old('nombreUsuario') }}" required>

            </div>
            <div class="userForm-form-item">
                <p>E-Mail</p>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required>
            </div>
            <div class="userForm-form-item">
                <p>Contraseña</p>
                <input type="password" name="contraseña" required>
            </div>
            <div class="userForm-form-item">
                <p>Confirma tu contraseña</p>
                <input type="password" name="confirmaContraseña" required>
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Registrase</button>
            </div>
            @if ($errors->any())
                <div class="userForm-form-item">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="userForm-form-error">{{ $error }}</li>
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
