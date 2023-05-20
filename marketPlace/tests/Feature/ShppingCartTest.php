<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Shop;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderLine;
use App\Models\ProductOderLine;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShppingCartTest extends TestCase
{
    use RefreshDatabase;

    public function testAddProduct()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a shop
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

        // Call the addProduct method
        $response = $this->actingAs($user)->get("/shoppingCart/addProduct/{$product->id}");

        // Assert that the response is successful
        $response->assertOk();

        // Assert that the product was added to the shopping cart
        $this->assertStringContainsString((string)$product->id, $response->headers->getCookies()[0]->getValue());

        // Assert that the product was added to the order (assuming Order::addIds() is working correctly)
        $this->assertDatabaseHas('product_oder_lines', [
            'product_id' => $product->id
        ]);
    }

    public function testDelProduct()
    {
        // Create a user
        $user = User::factory()->create();

        // Create a shop
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


        // Set the shopping cart cookie with the product ID
        $this->withCookie('shoppingCartProductsId', $product->id);

        // Call the delProduct method
        $response = $this->actingAs($user)->get("/shoppingCart/delProduct/{$product->id}");

        // Assert that the response is successful
        $response->assertOk();

        // Assert that the product was removed from the shopping cart
        $this->assertStringNotContainsString((string)$product->id, $response->getContent());


        // Assert that the product was removed from the order (assuming Order::delIds() is working correctly)
        $this->assertDatabaseMissing('product_oder_lines', [
            'product_id' => $product->id,
            'order_line_id' => $orderLine->id
        ]);
    }
}
