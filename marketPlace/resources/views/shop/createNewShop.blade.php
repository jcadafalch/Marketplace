@extends('layouts.master')

@section('title', 'Crear tienda')

@section('content')
    <div class="userForm">
        <div class="userForm-title">
            <div class="userForm-form-label">
                <h3>Dar de alta tu tienda</h3>
            </div>
        </div>
        <form class="userForm-form" action="{{ route('register.createNewShop') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="container">
                <div class="avatar-upload">
                    <div class="avatar-edit">
                        <input type='file' name="profilePhoto" id="imageUpload" accept=".png, .jpg, .jpeg" />
                        <label for="imageUpload"></label>
                    </div>
                    <div class="avatar-preview">
                        <div id="imagePreview" class="avatar-preview-img">
                            {{-- style="background-image: url({{ asset('storage/img/profile/' . Auth::user()->path ) }});" --}}
                            <img id="shopImg" src="{{asset('storage/img/profile/' . Auth::user()->path) }}"
                            onerror="this.src='{{ asset('images/imagesNotFound.webp') }}'" alt="Imagen de perfil">
                        </div>
                    </div>
                </div>
            </div>
            <div class="userForm-form-item">
                <label>Nombre de la tienda</label>
                <input type="text" name="shopName" value="{{ old('shopName') }}">
            </div>
            <div class="userForm-form-item">
                <label>Nombre del Propietario</label>
                <input type="text" name="name" value="{{ old('name') }}">
            </div>
            <div class="userForm-form-item">
                <label>Nif o Dni</label>
                <input type="text" name="nif" value="{{ old('nif') }}">
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Enviar</button>
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
    <script src="{{ asset('js/profileImgPreview.js') }}"></script>
@endsection
