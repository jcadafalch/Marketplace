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
                <label>Correo electronico</label>
                <input type="text" name="email" required>
                @if ($errors->has('email'))
                    </br><span class="text-danger">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="userForm-form-item">
                <label>Contraseña</label>
                <input type="password" name="password" required>
                @if ($errors->has('password'))
                    </br><span class="text-danger">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="userForm-form-item">
                <label>Confirma la contraseña</label>
                <input type="password" name="password_confirmation" required>
                @if ($errors->has('password_confirmation'))
                    </br><span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
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
