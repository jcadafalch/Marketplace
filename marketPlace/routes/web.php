<?php

use App\Http\Controllers\LogInController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;

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
Route::get('/searchProduct', [HomeController::class, 'searchProduct'])->name('home.index');
Route::get('/login', [LogInController::class, 'index'])->name('auth.login');
Route::get('/producte/{id}', [HomeController::class, 'show'])->name('product.show');

