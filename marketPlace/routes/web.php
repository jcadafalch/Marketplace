<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShoppingCartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// landing & home
Route::get('/', [HomeController::class, 'index'])->name('home.index');

// login & registro
Route::get('/login', [LogInController::class, 'index'])->name('auth.login');
Route::get('/register', [RegisterController::class, 'index'])->name('auth.register');

// contaseña
Route::get('/recuperarContrasenya', [LogInController::class, 'recoveryPassword'])->name('auth.recoveryPassword');
Route::post('/recuperarContrasenya', [LogInController::class, 'recoveryPasswordSender'])->name('auth.recoveryPasswordSender'); 
Route::get('reset-password/{token}', [LogInController::class, 'showResetPasswordForm'])->name('reset.password.get');
Route::post('reset-password', [LogInController::class, 'submitResetPasswordForm'])->name('reset.password.post');

// busqueda
Route::get('/searchProduct', [HomeController::class, 'searchProduct'])->name('home.searchProduct');
Route::get('/producte/{id}', [HomeController::class, 'show'])->name('product.show');

// carrito
Route::get('/shoppingCart', [ShoppingCartController::class, 'index'])->name('shoppingCart.index');
Route::get('/crearNuevaTienda', [ShopController::class, 'createNewShop'])->name('shop.createNewShop');
Route::post('/registrar', [ShopController::class, 'registerShop'])->name('register.createNewShop');
Route::get('/shoppingCart/addProdct/{id}', [ShoppingCartController::class, 'addProduct'])->name('shoppingCart.addProduct');

// gestion usuario
Route::get('/crearNuevaTienda', [LogInController::class, 'createNewTenant'])->name('tenant.createNewTenant');

// tienda