<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Shop;
use App\Models\User;
use App\Models\Product;
use Illuminate\Database\DBAL\TimestampType;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProducteTest extends TestCase
{
    use RefreshDatabase;

    public function testGetProductName()
    {
        $p = new Product();
        $p->name = "Joguina";
        $p->description = "Joguina d'alta qualitat";
        $p->selled_at = time();
        $expected = "Joguina";
        $actual = $p->name;
        $this->assertEquals($expected, $actual);
    }

    public function testGetProductDescription()
    {
        $p = new Product();
        $p->name = "Joguina";
        $p->description = "Joguina d'alta qualitat";
        $p->selled_at = time();
        $expected = "Joguina d'alta qualitat";
        $actual = $p->description;
        $this->assertEquals($expected, $actual);
    }

    public function testGetProductSelledAt()
    {
        $p = new Product();
        $p->name = "Joguina";
        $p->description = "Joguina d'alta qualitat";
        $p->selled_at = time();
        $expected = time();
        $actual = $p->selled_at;
        $this->assertEquals($expected, $actual);
    }

    public function testGetProductNameIsNotString()
    {
        $p = new Product();
        $p->name = true;
        $p->description = "Joguina d'alta qualitat";
        $p->selled_at = time();
        $expected = gettype("string");
        $actual = gettype($p->name);
        $this->assertNotEquals($expected, $actual);
    }

    public function testGetProductSelledAtIsTimestamp()
    {
        $p = new Product();
        $p->name = "Joguina";
        $p->description = "Joguina d'alta qualitat";
        $p->selled_at = time();
        $expected = gettype(time());
        $actual = gettype($p->selled_at);
        $this->assertEquals($expected, $actual);
    }

    public function testUpdateOrderProduct()
    {
        // Creamos un usuario para simular la autenticación
        $user = User::factory()->create();

        // Autenticamos al usuario
        $this->actingAs($user);

        // Creamos un objeto de tienda con algunos datos
        $shop = Shop::createShopObject("Nombre vendedor", "Nombre tienda", "00000000T", $user->id, null);

        // Creamos tres productos y los guardamos en la base de datos
        $product = new Product();
        $product->name = "NombreProducte";
        $product->description = "Descripción producto";
        $product->price = 900;
        $product->isVisible = true;
        $product->isDeleted = false;
        $product->order = 1;
        $product->shop_id = $shop->id;
        $product->save();

        $product1 = new Product();
        $product1->name = "NombreProducte1";
        $product1->description = "Descripción producto1";
        $product1->price = 900;
        $product1->isVisible = true;
        $product1->isDeleted = false;
        $product1->order = 2;
        $product1->shop_id = $shop->id;
        $product1->save();

        $product2 = new Product();
        $product2->name = "NombreProducte2";
        $product2->description = "Descripción producto2";
        $product2->price = 900;
        $product2->isVisible = true;
        $product2->isDeleted = false;
        $product2->order = 2;
        $product2->shop_id = $shop->id;
        $product2->save();

        // Creamos un array con los productos creados
        $products = [$product, $product1, $product2];

        // Simular una solicitud para cambiar el orden de un producto
        $response = $this->json('GET', '/tienda/ordenarProducto/?id='.$product1->id.'&action=up', [
            'action' => 'ordarChange Up',
            'actualProduct' => $product1->name,
            'ProductPosterior' => $product->name,
        ]);

        // Verificamos que la respuesta sea exitosa
        $response->assertSuccessful();

        // Obtenemos los datos de la respuesta en formato JSON
        $responseData = $response->json();

        // Verificamos que los datos de la respuesta coincidan con lo esperado
        $this->assertEquals('ordarChange Up', $responseData['action']);
        $this->assertEquals($products[1]->name, $responseData['actualProduct']);
        $this->assertEquals($products[0]->name, $responseData['ProductPosterior']);

        // Obtenemos los productos actualizados de la base de datos y los ordenamos por el campo 'order'
        $updatedProducts = Product::where('shop_id', $shop->id)->orderBy('order')->get();
        
        // Verificamos que los productos estén en el orden correcto
        $this->assertEquals($products[1]->id, $updatedProducts[0]->id);
        $this->assertEquals($products[0]->id, $updatedProducts[1]->id);
        $this->assertEquals($products[2]->id, $updatedProducts[2]->id);
    }
}