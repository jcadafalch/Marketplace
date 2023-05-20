@extends('layouts.master')

@section('title', 'Perfil')

@section('content')
    <section class="userForm">
        <section class="userForm-title">
            <div class="userForm-form-label">
                <h3>Perfil publico</h3>
            </div>
        </section>
        <form class="userForm-form" action="{{ route('user.changeProfile') }}" method="post" enctype="multipart/form-data">
            @csrf
            @method('patch')
            <div class="container">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type='file' name="profilePhoto" id="imageUpload" class="imageUpload" accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload"></label>
                    </div>
                    <div class="avatar-preview">
                        <div class="avatar-preview-img imagePreview">
                            <img class="imageUploaded" src="{{ asset('storage/img/profile/' . Auth::user()->path) }}"
                                onerror="this.src='{{ asset('images/imagesNotFound.webp') }}'" alt="Error">
                        </div>
                    </div>
                </div>
            </div>
            <div class="userForm-form-userInfo">
                <div class="userForm-form-userInfo-name">
                    <label>Nombre</label>
                </div>
                <div class="userForm-form-userInfo-userName">
                    <input maxlength="25" type="text" name="userName" value="{{ Auth::user()->name }}"
                        placeholder="{{ Auth::user()->name }}">
                </div>
            </div>
            <div class="userForm-form-item">
                <label>Cambiar contraseña</label>
                <input type="password" name="password" placeholder="Contraseña actual">
            </div>
            <div class="userForm-form-item">
                <input type="password" name="newPassword" placeholder="Nueva Contraseña">
            </div>
            <div class="userForm-form-item">
                <input type="password" name="repeatNewPassword" placeholder="Repita nueva Contraseña">
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit" id="profileUpload">Guardar Cambios</button>
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
            @if (Session::get('error') && Session::get('error') != null)
                <div class="userForm-form-error">{{ Session::get('error') }}</div>
                @php
                    Session::put('error', null);
                @endphp
            @endif
        </form>
    </section>

    <script src="{{ asset('js/profileImgPreview.js') }}"></script>
@endsection
