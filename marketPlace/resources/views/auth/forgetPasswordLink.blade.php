@extends('layouts.masterAuth')

@section('title', 'Recuperar Contraseña')

@section('content')
    <div class="userForm">
        <div class="userForm-title">
            <a href="{{ route('landingPage') }}"><img class='userForm-logo' src="{{ asset('/images/logo.png') }}"
                    alt="Logo" /></a>
        </div>
        <form action="{{ route('reset.password.post') }}" method="POST" class="userForm-form">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="userForm-form-item">
                <label>Correo electronico</label>
                <input type="text" name="email" required>
            </div>

            <div class="userForm-form-item">
                <label>Contraseña</label>
                <input type="password" name="password" required>
            </div>

            <div class="userForm-form-item">
                <label>Confirma la contraseña</label>
                <input type="password" name="password_confirmation" required>
            </div>

            <div class="userForm-form-button">
                <button type="submit" class="button-form">
                    Confirmar
                </button>
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
    </div>
@endsection
