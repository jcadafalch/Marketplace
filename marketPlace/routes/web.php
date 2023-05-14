<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\LogInController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ManageShopController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ShoppingCartController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;

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

//logout
Route::get('/logout', [UserController::class, 'logout'])->name('auth.logout');

// landing & home
Route::get('/home', [HomeController::class, 'index'])->name('home.index');
Route::get('/', [LandingPageController::class, 'index'])->name('landingPage');
Route::get('/landingPage/{id}', [LandingPageController::class, 'showAll'])->name('landingPage.showAll');

// login & registro
Route::get('/login', [LogInController::class, 'index'])->name('auth.login');
Route::post('/login', [LogInController::class, 'doLogin'])->name('auth.doLogin');
Route::get('/register', [RegisterController::class, 'create'])->name('auth.register');
Route::post('/register', [RegisterController::class, 'store'])->name('auth.store');

// NO TOCAR, si se toca cualquier cosa deja de funcionar (debe estar así para que Laravel internamente verifique el usuario)
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
  $request->fulfill();

  return redirect('/login');
})->middleware(['auth', 'signed'])->name('verification.verify');

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
Route::get('/shoppingCart/confirmOrder', [ShoppingCartController::class, 'confirmOrder'])->name('shoppingCart.confirmOrder');
Route::get('/shoppingCart/addProduct/{id}', [ShoppingCartController::class, 'addProduct'])->name('shoppingCart.addProduct');
Route::get('/shoppingCart/delProduct/{id}', [ShoppingCartController::class, 'delProduct'])->name('shoppingCart.delProduct');


// errors 
Route::get('/productoNoEncontrado', [ErrorController::class, 'productNotFoundError'])->name('error.productNotFoundError');
Route::get('/tiendaNoEcontrada', [ErrorController::class, 'shopNotFoundError'])->name('error.shopNotFoundError');
Route::get('/Error', [ErrorController::class, 'genericError'])->name('error.genericError');

Route::get('/recuperarContrasenya', [LogInController::class, 'recoveryPassword'])->name('auth.recoveryPassword');
Route::get('/administrarTenda/{id}', [ManageShopController::class, 'index'])->name('manage.manageShop');

Route::middleware('auth')->group((function () {


// gestion usuario
Route::get('/cambiarPerfil', [UserController::class, 'profile'])->name('user.profile');
Route::get('/perfil', [UserController::class, 'userProfile'])->name('user.userProfile');
Route::patch('/cambiarPerfil', [UserController::class, 'editProfile'])->name('user.changeProfile');

// tienda
Route::get('/crearNuevaTienda', [ShopController::class, 'createNewShop'])->name('shop.createNewShop');
Route::post('/registrar', [ShopController::class, 'registerShop'])->name('register.createNewShop'); 
Route::get('/administrarTenda/{id}', [ManageShopController::class, 'index'])->name('manage.manageShop');
Route::get('/tienda/editar', [ShopController::class, 'showEdit'])->name('shop.edit');
Route::patch('/tienda/editarTienda', [ShopController::class, 'editShop'])->name('shop.editConfiguration');
Route::post('/tienda/editarProducto/{id}', [ShopController::class, 'updateProduct'])->name('shop.editProduct');
Route::get('/tienda/editarProducto/{id}', [ShopController::class, 'showUpdateProduct'])->name('shop.showEditProduct');

// Pedidos
Route::get('/resumen-pedido/{id}', [OrderController::class, 'show'])->name('order.summary');

Route::get('/resumen-pedido/{id}/pdf', [OrderController::class, 'pdf'])->name('order.orderSummaryPdf');

}));

Route::group(['middleware' => ['web']], function () {
  Route::get('/tienda/añadirProducto', [ShopController::class, 'newProduct'])->name('shop.newProduct');
  Route::get('/tienda/añadirProducto/cat', [ShopController::class, 'getSubcategories']);
  Route::post('/tienda/añadirProducto', [ShopController::class, 'addProduct'])->name('shop.addProduct');
});

Route::get('/tienda/{shopName}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/pedido', [OrderController::class, 'show'])->name('order.show');
Route::get('/venta', [OrderController::class, 'selled'])->name('order.selled');
