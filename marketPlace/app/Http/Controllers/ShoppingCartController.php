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
        if (!isset($_COOKIE["shoppingCartProductsId"])) {
            setcookie("shoppingCartProductsId", "$id.", ["Path" => "/", "SameSite" => "Lax"]);
            if(Auth::check()){
                Order::addIds("$id.", Auth::id());
            }
            return true;
        } else {
            if(Auth::check()){
                Order::addIds($_COOKIE["shoppingCartProductsId"], Auth::id());
            }
            setcookie("shoppingCartProductsId", $_COOKIE["shoppingCartProductsId"] . "$id.", ["Path" => "/", "SameSite" => "Lax"]);
            return true;
        }
    }

    public function delProduct($id)
    {
        if (isset($_COOKIE["shoppingCartProductsId"])) {
            setcookie("shoppingCartProductsId", str_replace("$id.", "", $_COOKIE["shoppingCartProductsId"]), ["Path" => "/", "SameSite" => "Lax"]);
            if(Auth::check()){
                Order::addIds("$id.", Auth::id());
            }
            return true;
        }
    }
}
