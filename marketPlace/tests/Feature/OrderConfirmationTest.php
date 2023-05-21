<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Shop;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderLine;
use App\Models\ProductOderLine;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class OrderConfirmationTest extends TestCase
{
    
     use RefreshDatabase;
     
    
    public function test_it_fails_if_products_unavailable()
    {
        $user = User::factory()->create();

        $shop = Shop::createShopObject("Nombre vendedor", "Nombre tienda", "00000000T", $user->id, null);

        $product = new Product();
        $product->name = "NombreProducte";
        $product->description = "Descripción producto";
        $product->price = 900;
        $product->isVisible = true;
        $product->isDeleted = false;
        $product->order = 1;
        $product->shop_id = $shop->id;
        $product->save();

        $order = new Order();
        $order->user_id = $user->id;
        $order->in_process = 1;
        $order->save();

        $orderLine = new OrderLine();
        $orderLine->order_id = $order->id;
        $orderLine->shop_id = $product->shop_id;
        $orderLine->save();

        $productOrderLine = new ProductOderLine();
        $productOrderLine->orderLine_id = $orderLine->id;
        $productOrderLine->product_id = $product->id;
        $productOrderLine->price = $product->price;
        $productOrderLine->save();

        $response = $this->actingAs($user)->get('/confirm-order');
        $response->assertStatus(404); 
    }
    
    public function test_it_redirects_to_summary_if_order_is_valid()
    {
        $user = User::factory()->create();

        $shop = Shop::createShopObject("Nombre vendedor", "Nombre tienda", "00000000T", $user->id, null);

        $product = new Product();
        $product->name = "NombreProducte";
        $product->description = "Descripción producto";
        $product->price = 900;
        $product->isVisible = true;
        $product->isDeleted = false;
        $product->order = 1;
        $product->shop_id = $shop->id;
        $product->save();

        $order = new Order();
        $order->user_id = $user->id;
        $order->in_process = 1;
        $order->save();

        $orderLine = new OrderLine();
        $orderLine->order_id = $order->id;
        $orderLine->shop_id = $product->shop_id;
        $orderLine->save();

        $productOderLine = new ProductOderLine();
        $productOderLine->orderLine_id = $orderLine->id;
        $productOderLine->product_id = $product->id;
        $productOderLine->price = $product->price;
        $productOderLine->save();
        
        $response = $this->actingAs($user)->get('/shoppingCart/confirmOrder');
        $response->assertRedirect("/resumen-pedido/{$order->id}");
        $response->assertStatus(302);
    }
}
