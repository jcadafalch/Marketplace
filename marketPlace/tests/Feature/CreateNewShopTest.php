<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateNewShopTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Esta función prueba el registro de una tienda creando un usuario, iniciando sesión como ese
     * usuario y enviando un formulario con información de la tienda, incluido un archivo de imagen de
     * prueba.
     */
    public function testShopRegistration()
    {
        // Crea un usuario de prueba
        $user = User::factory()->create();

        // Inicia sesión como el usuario de prueba
        $this->actingAs($user);

        // Crea un archivo de imagen de prueba
        $file = UploadedFile::fake()->image('test_image.jpg');
        $response = $this->post('/registrar', [
            'shopName' => 'Nombre de tienda de prueba',
            'name' => 'Propietario de prueba',
            'nif' => '12345678A',
            'description' => null,
            'logo_id' => null,
            'banner_id' => null,
            'profilePhoto' => $file,
        ]);

        $this->assertDatabaseHas('shops', [
            'name' => 'Nombre de tienda de prueba',
            'ownerName' => 'Propietario de prueba',
            'nif' => '12345678A',
            'description' => null,
            'banner_id' => null,
            'user_id' => $user->id,
        ]);

        $this->assertDatabaseMissing('shops', [
            'name' => 'Nombre de tienda de prueba',
            'ownerName' => 'Propietario de prueba',
            'nif' => '12345678A',
            'description' => null,
            'banner_id' => null,
            'user_id' => $user->id,
            'logo_id' => null,
        ]);

        // Verifica que se haya redirigido a la ruta correcta después del registro de la tienda
        $response->assertRedirect(route('shop.show', ['shopName' => 'Nombre de tienda de prueba']));
    }
}
