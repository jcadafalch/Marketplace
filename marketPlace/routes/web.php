<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
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


Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/searchProduct', [HomeController::class, 'searchProduct'])->name('home.searchProduct');
Route::get('/login', [LogInController::class, 'index'])->name('auth.login');
Route::get('/register', [RegisterController::class, 'index'])->name('auth.register');
Route::get('/producte/{id}', [HomeController::class, 'show'])->name('product.show');
Route::get('/shoppingCart', [ShoppingCartController::class, 'index'])->name('shoppingCart.index');
Route::get('/recuperarContrasenya', [LogInController::class, 'recoveryPassword'])->name('auth.recoveryPassword');
Route::get('/crearNuevaTienda', [LogInController::class, 'createNewTenant'])->name('tenant.createNewTenant');
Route::get('/shoppingCart/addProdct/{id}', [ShoppingCartController::class, 'addProduct'])->name('shoppingCart.addProduct');
