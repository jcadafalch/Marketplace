@extends('layouts.master')

@section('title', 'Añadir Producto')

@section('content')
    <div class="userForm">
        <div class="userForm-title">
            <h3>Añadir producto</h3>
        </div>
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        @if (Session::has('error'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('error') }}
            </div>
        @endif
        <form class="userForm-form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="userForm-form-item">
                <label>Nombre</label>
                <input type="text" name="name" value="{{ old('name') }}" required>
            </div>

            <div class="userForm-form-item">
                <label>Precio</label>
                <input type="number" step="0.01" min="0.00" name="price" value="{{ old('price') }}" required>
            </div>

            <div class="userForm-form-item">
                <label>Detalle</label>
                <textarea rows="5" cols="40" maxlength='200' minlength='10' name="detail" required>{{ old('detail') }}</textarea>
            </div>
            <div class="upload-container">
                <div class="drop-area">
                    <label for="file-input"> Imagen destacada </label>
                    <input name="file" type="file" id="file-input" accept="image/*" value="{{ old('file') }}"
                        hidden />

                    <div class="preview-container hidden">
                        <div class="preview-image"></div>
                        <span class="file-name"></span>
                        <p class="close-button">Eliminar</p>
                    </div>
                </div>
            </div>
            <div class="upload__box drop-area">
                <div class="upload__btn-box">
                    <label class="upload__btn">
                        <p>Otras Imagenes</p>
                        <input name="otrasImagenes[]" type="file" multiple data-max_length="5" accept="image/*"
                            class="upload__inputfile" value="{{ old('otrasImagenes[]') }}">
                    </label>
                </div>
                <div class="upload__img-wrap"></div>
            </div>
            <div class="checkbox-container">

                <div id="multiselect" class="multiselect checkbox-dropdown">
                    <p>Categorias</p>
                    {{-- <div class="selectBox" onclick="showCheckboxes()">
                        <select>
                            <option>Selecciona categorias</option>
                        </select>
                        <div class="overSelect"></div>
                    </div> --}}
                    <ul id="checkboxes" class="checkbox-dropdown-list">
                        @foreach ($categories as $item)
                            <li>
                                <label for="{{ $item->name }}">
                                    <input type="checkbox" name="category[]" class="checkbox" id="{{ $item->name }}"
                                        value="{{ $item->name }}" />{{ $item->name }}</label>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div id="multiselect2" class="multiselect checkbox-dropdown" hidden>
                    <p>Subcategorias</p>
                    {{-- <div class="selectBox" onclick="showCheckboxes2()">
                        <select>
                            <option>Selecciona subcategorias</option>
                        </select>
                        <div class="overSelect"></div>
                    </div> --}}
                    <ul id="checkboxes2" class="checkbox-dropdown-list">
                        <li class="check">

                        </li>
                    </ul>
                </div>
            </div>
            <div class="userForm-form-button">
                <button class="button-form" type="submit">Guardar</button>
            </div>
            @if ($errors->any())
                <div class="error-list">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>
    </div>

    <script src="{{ asset('js/imgPreviw.js') }}"></script>
@endsection
