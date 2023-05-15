<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/getImage', [ApiController::class, 'getImage']);
Route::get('/getImages', [ApiController::class, 'getAllImage']);
Route::get('/createImage', [ApiController::class, 'createImage'])->withoutMiddleware("throttle:api");


Route::post('/pushImage', [ApiController::class, 'pushImage']);


Route::delete('/deleteImage', [ApiController::class, 'deleteImage']);
Route::delete('/deleteImageByProductName', [ApiController::class, 'deleteImageByProductName']);
Route::delete('/deleteAllImages', [ApiController::class, 'deleteAllImages']);

