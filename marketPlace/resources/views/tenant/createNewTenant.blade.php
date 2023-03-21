@extends('layouts.masterAuth')

@section('title', 'Recuperar Contraseña')

@section('content')
<div class= "userForm">
    <div class="userForm-title" >
    <h1>Craft Made</h1>
    </div>
    <form class="userForm-form" method="">
        @csrf
        <div class="userForm-form-label">
            <label>Dar de alta tu tienda</label>
        </div>
        <div class="userForm-form-item">
            <p>Nombre de la tienda</p>
            <input type="text" name="shopName">
        </div>
        <div class="userForm-form-item">
            <p>Nombre completo de la persona fisica</p>
            <input type="text" name="name" >
        </div>
        <div class="userForm-form-item">
            <p>Nif o Dni</p>            
            <input type="text" name="nif">
        </div>
        <div class="userForm-form-button">
            <button class="button-recovery" type="submit">Enviar</button>
        </div>      
    </form>
</div>
@endsection