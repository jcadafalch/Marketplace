@extends('layouts.master')

@section('title', 'Perfil')

@section('content')
 <div class="userForm">
        <div class="userForm-title">
            <div class="userForm-form-label">
                <h3>Perfil publico</h3>
            </div>
        </div>
        <form class="userForm-form" action="{{ route('user.changeProfile') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="userForm-form-avatar">
                <img src="{{ asset('storage/img/profile/profileImg' . Auth::user()->id . '.jpg') }}" onerror="this.src='{{ asset('storage/img/profile/defaultProfileImage.jpg') }}'" alt="Imagen de perfil">
            </div >
            <div class="userForm-form-uploadPhoto">
                <div class ="userForm-form-uploadPhoto-text">
                    <label>Foto de perfil</label>      
                </div>
                <div class="userForm-form-uploadPhoto-button">
                    <input type="file" name="profilePhoto" accept="image/*" value="{{ old('profilePhoto') }}">
                </div>
            </div>
            <div class="userForm-form-userInfo">
                <div class="userForm-form-userInfo-name">
                    <label>Nombre</label>
                </div>
                <div class="userForm-form-userInfo-userName">
                     <input type="text" name="userName" value="{{ old('userName') }}" placeholder="{{Auth::user()->name}}">
                </div>
            </div>
            <div class="userForm-form-item">
                <label>Cambiar contraseña</label>
                <input type="password" name="password" value="{{ old('password') }}" placeholder="Contraseña actual">
            </div>
            <div class="userForm-form-item">
                <input type="password" name="newPassword" value="{{ old('newPassword') }}" placeholder="Nueva Contraseña">
            </div>
            <div class="userForm-form-item">
                <input type="password" name="repeatNewPassword" value="{{ old('repeatNewPassword') }}" placeholder="Repita nueva Contraseña">
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