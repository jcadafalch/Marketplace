<?php

namespace App\Models;

use App\Models\Shop;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderLine;
use Illuminate\Database\Eloquent\Model;

class CompleteOrderLine extends Model
{
    protected $table = 'complete_order_lines';

    protected $guarded = [];

    // Atributos del modelo
    protected $attributes = [
        'orderDate' => '',
        'orderId' => '',
        'orderLineStatus' => '',
        'shopName' => '',
        'shopLogoUrl' => '',
        'price' => 0,
        'productsName' => ""
    ];

}
