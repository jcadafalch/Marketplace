@extends('layouts.master')
@section('title', 'Resumen pedido')
@section('content')
    <section class="profile">
        <h2>Pedidos realizados</h2>
        <article class="user-order">
            @if ($orders == null || count($orders) == 0)
                <p>Todavía no has realizdo ningún pedido</p>
            @endif
            @if ($orders != null)
                @foreach ($orders as $order)
                    <details class="user-order-history">
                        <summary class="user-order-history-title">Numero de pedido: {{ $order->id }}</summary>
                        <div class="user-order-history-download">
                            <a href="{{ route('order.summary', ['id' => $order->id]) }}">
                                <h3>Visualizar pedido</h3>
                            </a>
                            <a href="{{ route('order.orderSummaryPdf', ['id' => $order->id]) }}">
                                <span class="material-symbols-outlined">
                                    download
                                </span>
                            </a>
                        </div>
                        <ul class="user-order-history-list">
                            @foreach ($completedOrderLines as $completedOrderLine)
                                @if ($completedOrderLine->orderId == $order->id)
                                    <li class="order-product">
                                        <div>
                                            <img class="order-product-image"
                                                src="{{ asset('storage/img/shopProfile/' . $completedOrderLine->shopLogoUrl) }}"
                                                onerror="this.src='{{ asset('/images/imagesNotFound.webp') }}'"
                                                alt="Logo de la tienda">
                                        </div>
                                        <div>
                                            <a
                                                href="{{ route('order.orderLineSummary', ['id' => $completedOrderLine->orderLineId]) }}">
                                                <h3 class="order-product-name">{{ $completedOrderLine->shopName }}</h3>
                                                <p class="order-product-list"> {{ $completedOrderLine->productsName }}
                                                </p>
                                            </a>
                                        </div>

                                        <div class="order-product-price">
                                            <p> Fecha: {{ $completedOrderLine->orderDate }}</p>
                                            <p> {{ $completedOrderLine->orderLineStatus }} </p>
                                            <p> Total: {{ $completedOrderLine->price }}€ </p>
                                            <a href="{{ route('order.orderSummaryPdf', ['id' => $order->id]) }}">
                                                <span class="material-symbols-outlined order-product-price">
                                                    download
                                                </span>
                                            </a>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </details>
                @endforeach
            @endif

        </article>
    </section>
@endsection
