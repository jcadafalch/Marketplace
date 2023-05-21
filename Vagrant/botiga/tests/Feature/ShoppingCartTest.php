<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Shop;
use App\Models\User;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderLine;
use App\Models\ProductImage;
use App\Models\ProductOderLine;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ShoppingCartTest extends TestCase
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

    public function testSumTotalProductCart(){

        // Create a user
        $user = User::factory()->create();
        $this->actingAs($user);

        // Create a shop
        $shop = Shop::createShopObject("Nombre vendedor", "Nombre tienda", "00000000T",  $user->id, null);

        $order = new Order();
        $order->user_id = $user->id;
        $order->in_process = 1;
        $order->save();

        
        $orderLine = new OrderLine();
        $orderLine->order_id = $order->id;
        $orderLine->shop_id = $shop->id;
        $orderLine->save();


        // Product one 
        $product1 = new Product();
        $product1->name = "NombreProducte1";
        $product1->description = "Descripción producto";
        $product1->price = 90000;
        $product1->isVisible = true;
        $product1->isDeleted = false;
        $product1->order = 1;
        $product1->shop_id = $shop->id;
        $product1->save();

        $image1 = new Image();
        $image1->name = '$product1';
        $image1->url =  'Storage/test';
        $image1->save();

        $productImage = new ProductImage();
        $productImage->isMain = true;
        $productImage->image_id = $image1->id;
        $productImage->product_id = $product1->id;
        $productImage->save();


        $productOderLine = new ProductOderLine();
        $productOderLine->orderLine_id = $orderLine->id;
        $productOderLine->product_id = $product1->id;
        $productOderLine->price = $product1->price;
        $productOderLine->save();
        
        // Product two 
        $product2 = new Product();
        $product2->name = "NombreProducte2";
        $product2->description = "Descripción producto";
        $product2->price = 60000;
        $product2->isVisible = true;
        $product2->isDeleted = false;
        $product2->order = 2;
        $product2->shop_id = $shop->id;
        $product2->save();


        $image2 = new Image();
        $image2->name = '$product2';
        $image2->url =  'Storage/test';
        $image2->save();

        $productImage = new ProductImage();
        $productImage->isMain = true;
        $productImage->image_id = $image2->id;
        $productImage->product_id = $product2->id;
        $productImage->save();

        $productOderLine = new ProductOderLine();
        $productOderLine->orderLine_id = $orderLine->id;
        $productOderLine->product_id = $product2->id;
        $productOderLine->price = $product2->price;
        $productOderLine->save();
        
        // Product three  
        $product3 = new Product();
        $product3->name = "NombreProducte3";
        $product3->description = "Descripción producto";
        $product3->price = 30000;
        $product3->isVisible = true;
        $product3->isDeleted = false;
        $product3->order = 3;
        $product3->shop_id = $shop->id;
        $product3->save();

        $image3 = new Image();
        $image3->name = '$product2';
        $image3->url =  'Storage/test';
        $image3->save();

        $productImage = new ProductImage();
        $productImage->isMain = true;
        $productImage->image_id = $image3->id;
        $productImage->product_id = $product3->id;
        $productImage->save();

        $productOderLine = new ProductOderLine();
        $productOderLine->orderLine_id = $orderLine->id;
        $productOderLine->product_id = $product3->id;
        $productOderLine->price = $product3->price;
        $productOderLine->save();


        // Product four 
        $product4 = new Product();
        $product4->name = "NombreProducte4";
        $product4->description = "Descripción producto";
        $product4->price = 75000;
        $product4->isVisible = true;
        $product4->isDeleted = false;
        $product4->order = 4;
        $product4->shop_id = $shop->id;
        $product4->save();

        $image4 = new Image();
        $image4->name = '$product2';
        $image4->url =  'Storage/test';
        $image4->save();

        $productImage = new ProductImage();
        $productImage->isMain = true;
        $productImage->image_id = $image4->id;
        $productImage->product_id = $product4->id;
        $productImage->save();

        $productOderLine = new ProductOderLine();
        $productOderLine->orderLine_id = $orderLine->id;
        $productOderLine->product_id = $product4->id;
        $productOderLine->price = $product4->price;
        $productOderLine->save();

        //Array errors, simulate empty
        $errors = [];
        
        // Call view shoppingCart, with products collection 
        $response =  $this->view('shoppingCart.shoppingCart',['producte' => $shop->getShopProducts(),'categories' => Category::all()->where('parent_id', '=', null), 'errors' => $errors]);

        // I check that the total sum is correct
        $response->assertSeeText('2550€');
       
    }
}
