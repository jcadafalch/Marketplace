@extends('layouts.masterAuth')

@section('title', 'Recuperar Contraseña')

@section('content')
    <div class="userForm">
        <div class="userForm-title">
            <a href="{{ route('home.index') }}"><img class='userForm-logo' src="{{ asset('/images/logo.png') }}"
                    alt="Logo" /></a>
        </div>
        <form action="{{ route('reset.password.post') }}" method="POST" class="userForm-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="userForm-form-item">
                <p>Correo electronico</p>
                <input type="text" name="email" required>
                @if ($errors->has('email'))
                    <span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="userForm-form-item">
                <p>Contraseña</p>
                <input type="password" name="password" required>
                @if ($errors->has('password'))
                    <span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="userForm-form-item">
                <p>Confirma la contraseña</p>
                <input type="password" name="password_confirmation" required>
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <div class="userForm-form-button">
                <button type="submit" class="button-form">
                    Confirmar
                </button>
            </div>
        </form>
    </div>
@endsection
