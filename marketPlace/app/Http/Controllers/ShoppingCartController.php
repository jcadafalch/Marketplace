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
        if (!isset($_SESSION["shoppingCartProductsId"])) {
            $_SESSION["shoppingCartProductsId"] = [];
        } 
        $producte = Product::getInfoFromId($_SESSION["shoppingCartProductsId"]);
        $categories = Category::all();
        Log::info("ShoppingCart-Header number of categories: " . count($categories));
        return view('shoppingCart.shoppingCart', ['categories' => $categories], ['producte' => $producte]);
    }

    public function addProduct($id)
    {
        if (!isset($_SESSION["shoppingCartProductsId"])) {
            $_SESSION["shoppingCartProductsId"] = [];
        }

        //$_SESSION["shoppingCartProductsId"] = [];

        array_push($_SESSION["shoppingCartProductsId"], intval($id));
        Log::debug($_SESSION["shoppingCartProductsId"]);
        $shoppingCartProductsIdJsonList = json_encode($_SESSION["shoppingCartProductsId"]);
        return $shoppingCartProductsIdJsonList;
    }
}
