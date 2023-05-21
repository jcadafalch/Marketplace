<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EditShopTest extends TestCase
{

    use RefreshDatabase;
    use WithFaker;

    public function testEditShop()
    {
        // Creamos un usuario y autenticarlo
        $user = User::factory()->create();
        $this->actingAs($user);

        // Creamos una tienda asociada al usuario autenticado
        $shop = Shop::createShopObject("Nombre vendedor", "Nombre tienda", "00000000T", $user->id, null);

        // Generamos una descripción aleatoria
        $description = $this->faker->sentence;

        // Generamos una imagen de prueba
        $image = UploadedFile::fake()->image('shop_banner.jpg');

        // Enviamos una solicitud PATCH a la ruta 'shop.editConfiguration'
        $response = $this->patch(route('shop.editConfiguration'), [
            'shopDescription' => $description,
            'shopBanner' => $image,
        ]);

        // Verificamos que la tienda ha sido actualizada correctamente
        $this->assertEquals($description, $shop->fresh()->description);
        $this->assertNotNull($shop->fresh()->banner_id);

        // Verificamos que se ha redirigido a la ruta 'shop.edit'
        $response->assertRedirect(route('shop.edit'));
    }
}