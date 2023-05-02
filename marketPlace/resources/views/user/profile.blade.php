@extends('layouts.master')

@section('title', 'Perfil')

@section('content')
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <section class="userForm">
        <section class="userForm-title">
            <div class="userForm-form-label">
                <h3>Perfil publico</h3>
            </div>
        </section>
        <form class="userForm-form" action="{{ route('user.changeProfile') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            {{-- <div class="userForm-form-avatar">
                <img src="{{ asset('storage/img/profile/profileImg' . Auth::user()->id . '.jpg') }}"
                    onerror="this.src='{{ asset('storage/img/profile/defaultProfileImage.jpg') }}'" alt="Imagen de perfil">
            </div>
            <div class="userForm-form-uploadPhoto">
                <div class="userForm-form-uploadPhoto-text">
                    <label>Foto de perfil</label>
                </div>
                <div class="userForm-form-uploadPhoto-button">
                    <input type="file" name="profilePhoto" accept="image/*" value="{{ old('profilePhoto') }}">
                </div>
            </div> --}}
            <div class="container">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type='file' name="profilePhoto" id="imageUpload" accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload"></label>
                    </div>
                    <div class="avatar-preview">
                        <div id="imagePreview" style="background-image: url({{ asset('storage/img/profile/profileImg' . Auth::user()->id . '.jpg') }});">
                        </div>
                    </div>
                </div>
            </div>
            <div class="userForm-form-userInfo">
                <div class="userForm-form-userInfo-name">
                    <label>Nombre</label>
                </div>
                <div class="userForm-form-userInfo-userName">
                    <input type="text" name="userName" value="{{ old('userName') }}"
                        placeholder="{{ Auth::user()->name }}">
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
                <input type="password" name="repeatNewPassword" value="{{ old('repeatNewPassword') }}"
                    placeholder="Repita nueva Contraseña">
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit" id="imageUpload">Guardar Cambios</button>
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
    </section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="{{ asset('js/profileImgPreview.js') }}"></script>

    <style>
        /* .container {
            max-width: 960px;
            margin: 30px auto;
            padding: 20px;
        } */

        .avatar-upload {
            position: relative;
            max-width: 205px;
            /* margin: 50px auto; */
        }

        .avatar-upload .avatar-edit {
            position: absolute;
            right: 12px;
            z-index: 1;
            top: 10px;
        }

        .avatar-upload .avatar-edit input {
            display: none;
        }

        .avatar-upload .avatar-edit input+label {
            display: inline-block;
            width: 34px;
            height: 34px;
            margin-bottom: 0;
            border-radius: 100%;
            background: #FFFFFF;
            border: 1px solid transparent;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.12);
            cursor: pointer;
            font-weight: normal;
            transition: all 0.2s ease-in-out;
        }

        .avatar-upload .avatar-edit input+label:hover {
            background: #f1f1f1;
            border-color: #d6d6d6;
        }

        .avatar-upload .avatar-edit input+label:after {
            content: "\e3c9";
            font-family: 'Material Icons';
            color: #757575;
            position: absolute;
            top: 10px;
            left: 0;
            right: 0;
            text-align: center;
            margin: auto;
        }

        .avatar-upload .avatar-preview {
            width: 192px;
            height: 192px;
            position: relative;
            border-radius: 100%;
            border: 6px solid #F8F8F8;
            box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
        }

        .avatar-upload .avatar-preview>div {
            width: 100%;
            height: 100%;
            border-radius: 100%;
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
@endsection
