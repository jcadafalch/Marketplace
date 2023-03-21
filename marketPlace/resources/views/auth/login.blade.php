@extends('layouts.masterAuth')

@section('title', 'Login')

@section('content')

    <div class="LogInContent">
        <div class="LogInContent-left">
            <div class="card-header">
                <h1>Craft Made</h1>
            </div>
            <div>
                <form class="card-form">
                @csrf
                    <div class="form-item">
                        <input type="text" name="name" placeholder="Nombre">
                    </div>
                    <div class="form-item">
                        <input type="mail" name="mail" placeholder="E-mail">
                    </div>
                    <div class="form-item">
                        <input type="password" name="password" placeholder="Contaseña">
                    </div>
                    <div class="form-item">
                        <input type="password" name="password" placeholder="Repite contaseña">
                    </div>
                    <div class="form-item">
                        <button class="button-LogIn" type="submit">
                            Registarse
                        </button>
                    </div>
                </form>
                <a href="{{ route('auth.recoveryPassword') }}">¿Has olvidado la contraseña?</a>
            </div>
        </div>
        <div class="LogInContent-right">
            <div class="logoRegistre">
                <img src="{{ asset('/images/LogoFooter.png') }}" alt="Logo" />
            </div>
        </div>
    </div>
    </div>

@endsection
