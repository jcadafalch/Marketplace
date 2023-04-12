<?php

namespace App\Http\Controllers;

session_start();

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!isset($_COOKIE["shoppingCartProductsId"])) {
            $producte = [];
        } else {
            $producte = Product::getInfoFromId($_COOKIE['shoppingCartProductsId']);
        }
        $categories = Category::all();
        return view('shoppingCart.shoppingCart', ['categories' => $categories], ['producte' => $producte]);
    }

    public function addProduct($id)
    {
        if (Auth::check()) {
            if (!isset($_COOKIE["shoppingCartProductsId"])) {
                setcookie("shoppingCartProductsId", "$id.", ["Path" => "/", "SameSite" => "Lax"]);
            } else {
                setcookie("shoppingCartProductsId", $_COOKIE["shoppingCartProductsId"] . "$id.", ["Path" => "/", "SameSite" => "Lax"]);
            }
        }
    }
}
