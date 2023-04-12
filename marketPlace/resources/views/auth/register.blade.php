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
                {{-- <p>Nombre de usuario</p> --}}
                <label for="username">{{ __('Nombre de usuario') }}</label>
                <input id="username" type="text" name="username" value="{{ old('name') }}" required
                    autocomplete="username" autofocus>
                @error('username')
                    <span role="alert">

                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="userForm-form-item">
                {{-- <p>E-Mail</p> --}}
                <label for="email">{{ __('Correo electronico') }}</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required
                    autocomplete="email">
                @error('email')
                    <span role="alert">
                        <strong> {{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="userForm-form-item">
                {{-- <p>Contraseña</p> --}}
                <label for="password">{{ __('Contraseña') }}</label>
                <input id="password" type="password" name="password" required autocomplete="new-password">
                @error('password')
                    <br>
                    <span role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
            <div class="userForm-form-item">
                {{-- <p>Confirma tu contraseña</p> --}}
                <label for="password-confirm">{{ __('Confirma tu contraseña') }}</label>
                <input id="password-confirm" type="password" name="password-confirm" required autocomplete="new-password">
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Registrase</button>
            </div>
        </form>
        <div class="userForm-form-help already-account">
            <p>¿Ya tienes cuenta? <a href="{{ Route('auth.login') }}">Inicia sesión</a></p>
        </div>
    </div>
@endsection
