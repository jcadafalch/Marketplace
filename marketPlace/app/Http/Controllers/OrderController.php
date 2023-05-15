<?php

namespace App\Http\Controllers;

session_start();

use App\Models\Shop;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderLine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
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

        Log::info("Se ha realizado un pedido: " /* añadir usuario */);

        return view('order.orderSummary', ['categories' => $categories], ['producte' => $producte, 'shops' => Shop::all()]);
    }

    public function order(/*$id*/)
    {
        if (!isset($_COOKIE["shoppingCartProductsId"])) {
            $producte = [];
        } else {
            $producte = Product::getInfoFromId($_COOKIE['shoppingCartProductsId']);
        }
        $categories = Category::all();
        return view('order.order', ['categories' => $categories], ['producte' => $producte, 'shops' => Shop::all(), /*'order' => Order::findOrFile($id)*/]);
    }

    public function selled(/*$id*/)
    {
        if (!isset($_COOKIE["shoppingCartProductsId"])) {
            $producte = [];
        } else {
            $producte = Product::getInfoFromId($_COOKIE['shoppingCartProductsId']);
        }
        $categories = Category::all();
        return view('order.selled', ['categories' => $categories], ['producte' => $producte, 'shops' => Shop::all(), /*'order' => Order::findOrFile($id)*/]);
    }

    public function orderList()
    {
        if (!isset($_COOKIE["shoppingCartProductsId"])) {
            $producte = [];
        } else {
            $producte = Product::getInfoFromId($_COOKIE['shoppingCartProductsId']);
        }
        $categories = Category::all();
        return view('order.orderList', ['categories' => $categories], ['producte' => $producte, 'shops' => Shop::all(), /*'order' => Order::findOrFile($id)*/]);
    }

    public function selledList(/*$id*/)
    {
        $user_id = Auth::user()->id;
        $userShop = Shop::where('user_id', '=', $user_id)->first();
        $shops = Shop::all();
        $categories = Category::all()->where('parent_id', '=', null);
        if (!isset($_COOKIE["shoppingCartProductsId"])) {
            $producte = [];
        } else {
            $producte = Product::getInfoFromId($_COOKIE['shoppingCartProductsId']);
        }
        $categories = Category::all();
        return view('order.selledList', ['categories' => $categories], ['producte' => $producte, 'shops' => Shop::all(), /*'order' => Order::findOrFile($id)*/ 'shop' => $userShop]);
    }
}
