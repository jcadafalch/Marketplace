<?php

namespace App\Http\Controllers;

session_start();

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        dd(isset($_COOKIE["shoppingCartProductsId"]));
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
        if (!isset($_COOKIE["shoppingCartProductsId"])) {
            setcookie("shoppingCartProductsId", "$id.");
        } else {
            setcookie("shoppingCartProductsId", $_COOKIE["shoppingCartProductsId"] . "$id.");
        }
    }
}
