@extends('layouts.master')

@section('title', 'Administrar Tenda')

@section('content')

    <h1>Administra tus tiendas</h1>

    <form id="form-order" action="{{ route('home.searchProduct') }}" method="get">
        <select name="order" id="order">
            <option value="" disabled selected hiden>Ordenar por</option>
            <option value="ASC">A-Z</option>
            <option value="DESC">Z-A</option>
        </select>
    </form>

    <ul class="products-section">
        
    </ul>

@endsection
