<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Http\Requests\UserRegister;
use App\Http\Controllers\RegisterController;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Esta función comprueba si la página de registro se carga correctamente y contiene los elementos
     * esperados.
     */
    public function testRegisterPageLoadsSuccessfully()
    {
        $response = $this->get('/register');

        $response->assertStatus(200);
        $response->assertViewIs('auth.register');
        $response->assertSee('Registro');
    }

    /**
     * Esta función prueba el proceso de registro de usuarios al crear un usuario con datos específicos
     * y verificar si el usuario se agregó correctamente a la base de datos.
     */
    public function testUserRegistration()
    {
        $userData = [
            'nombreUsuario' => 'JohnDoe',
            'email' => 'john.doe@example.com',
            'contraseña' => 'Password123!', // Cumple con los requisitos de contraseña
            'confirmaContraseña' => 'Password123!',
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(302);
        $response->assertRedirect('/login');

        $this->assertDatabaseHas('users', ['email' => 'john.doe@example.com']);
    }

    /**
     * La función prueba la validación del registro de usuario mediante el envío de datos de usuario no
     * válidos y la verificación de errores y la ausencia de la base de datos.
     */
    public function testUserRegistrationValidation()
    {
        $userData = [
            'nombreUsuario' => '',
            'email' => 'invalid_email',
            'contraseña' => 'password',
            'confirmaContraseña' => '', // Campo confirmaContraseña vacío
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors(['nombreUsuario', 'email', 'contraseña', 'confirmaContraseña']); // Verificar errores de validación
        $this->assertDatabaseMissing('users', ['email' => 'invalid_email']);
    }

    /**
     * Esta función prueba el registro de usuario con una contraseña no válida que no contiene un
     * carácter especial.
     */
    public function testUserRegistrationWithInvalidPassword()
    {
        $userData = [
            'nombreUsuario' => 'JohnDoe',
            'email' => 'john.doe@example.com',
            'contraseña' => 'password123', // No contiene carácter especial
            'confirmaContraseña' => 'password123',
        ];

        $response = $this->post('/register', $userData);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('contraseña');
        $this->assertDatabaseMissing('users', ['email' => 'john.doe@example.com']);
    }
}
