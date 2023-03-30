@extends('layouts.master')

@section('title', 'Perfil')

@section('content')
 <div class="userForm">
        <div class="userForm-title">
            <div class="userForm-form-label">
                <label>Perfil publico</label>
            </div>
        </div>
        <form class="userForm-form" action="{{ route('register.createNewShop') }}" method="post">
            @csrf
            <div class="userForm-form-avatar">
                <img src="https://img.freepik.com/vector-premium/perfil-avatar-hombre-icono-redondo_24640-14044.jpg">
            </div >
            <div class="userForm-form-uploadPhoto">
                <div class ="userForm-form-uploadPhoto-text">
                    <p>Foto de perfil</p>      
                </div>
                <div class="userForm-form-uploadPhoto-button">
                    <input type="file" name="profilePhoto" accept="image/*" value="{{ old('profilePhoto') }}">
                </div>
            </div>
            <div class="userForm-form-userInfo">
                <div class="userForm-form-userInfo-name">
                    <p>Nombre</p>
                </div>
                <div class="userForm-form-userInfo-userName">
                     <input type="text" name="userName" value="{{ old('password') }}">
                </div>
            </div>
            <div class="userForm-form-item">
                <p>Cambiar contraseña</p>
                <input type="text" name="password" value="{{ old('password') }}" placeholder="Contraseña actual">
            </div>
            <div class="userForm-form-item">
                <input type="text" name="newPassword" value="{{ old('newPassword') }}" placeholder="Nueva Contraseña">
            </div>
            <div class="userForm-form-item">
                <input type="text" name="repeatNewPassword" value="{{ old('repeatNewPassword') }}" placeholder="Repita nueva Contraseña">
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Guardar Cambios</button>
            </div>
             @if ($errors->any())
            <div class="userForm-form-item">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="userForm-form-error" >{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
        </form>
    </div>


@endsection