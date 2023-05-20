@extends('layouts.master')
@section('title', 'Resumen pedido')
@section('content')
    <section class="order-section">
        <h2>Pedidos vendidos</h2>
        @if ($shop != null)
            <article class="user-order">
                <ul class="user-order-history-list">
                    @foreach ($shops as $shop)
                        <a href="{{ route('order.selled' /*, ['id' => ]*/) }}">
                            <li class="order-product" id="1">
                                <div>
                                    <h3 class="order-product-name">{{ $shop->name }}</h3>
                                    <div>
                                        <span class="order-product-price"> Fecha: 01-01-2023 |</span>
                                        <span class="order-product-price"> Nº Pedido: </span>
                                    
                                    </div>
                                </div>
                                <div>
                                    <p class="order-product-price"> Total: € </p>
                                    <p class="order-product-price"> Entregado </p>
                                   
                                </div>
                            </li>
                        </a>
                        <hr>
                    @endforeach
                </ul>
            </article>
        @endif
    </section>
@endsection
