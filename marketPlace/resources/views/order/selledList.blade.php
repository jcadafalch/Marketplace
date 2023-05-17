@extends('layouts.master')
@section('title', 'Resumen pedido')
@section('content')
    <section class="order-section">
        <h2>Pedidos vendidos</h2>
        @if ($shop != null)
            <article class="user-order">
                <ul class="user-order-history-list">
                    @foreach ($completedShopOrderLines as $completedShopOrderLine)
                        <a href="{{ route('order.selled', ['id' => $completedShopOrderLine->orderLineId]) }}">
                            <li class="order-product" id="1">
                                <div>
                                    <h3 class="order-product-name">{{ $completedShopOrderLine->shopName }}</h3>
                                </div>
                                <div>
                                    <p class="order-product-price"> Fecha: {{ $completedShopOrderLine->orderDate }}
                                    </p>
                                    <p class="order-product-price"> {{ $completedShopOrderLine->orderLineStatus }} </p>
                                    <p class="order-product-price"> Total: {{ $completedShopOrderLine->price }}€</p>
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
