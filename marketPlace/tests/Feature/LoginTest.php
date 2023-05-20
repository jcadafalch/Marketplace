<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Factory;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Esta función prueba si el formulario de inicio de sesión se muestra correctamente en una página
     * web.
     */
    public function testLoginFormIsDisplayed()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
        $response->assertViewIs('auth.login');
        $response->assertSee('Iniciar sesión');
        $response->assertSee('Dirección de E-Mail');
        $response->assertSee('Contraseña');
        $response->assertSee('¿Has olvidado la contraseña?');
        $response->assertSee('Iniciar sesión');
        $response->assertSee('¿No tienes cuenta?');
        $response->assertSee('Registrate aquí');
    }

    /**
     * Esta función prueba el inicio de sesión con credenciales no válidas y espera una redirección a
     * la página de inicio de sesión con un mensaje de error.
     */
    public function testLoginWithInvalidCredentials()
    {
        $response = $this->post('/login', [
            'email' => 'invalid@example.com',
            'password' => 'invalidpassword',
        ]);

        $response->assertRedirect('/login');
        $response->assertSessionHas('message', 'El nombre de usuario o correo electrónico o contraseña son incorrectos.');
    }

    /**
     * Esta función prueba la funcionalidad de inicio de sesión para un usuario con un correo
     * electrónico no verificado.
     */
    public function testLoginWithUnverifiedEmail()
    {
        $user = User::factory()->unverified()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect();
        $this->assertAuthenticatedAs($user);
    }

    /**
     * Esta función prueba un inicio de sesión exitoso creando un usuario, publicando su correo
     * electrónico y contraseña en la ruta de inicio de sesión, afirmando que la respuesta redirige a
     * la página de inicio y afirmando que el usuario está autenticado.
     */
    public function testSuccessfulLogin()
    {
        $user = User::factory()->create();

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertRedirect('/home');
        $this->assertAuthenticatedAs($user);
    }
}
