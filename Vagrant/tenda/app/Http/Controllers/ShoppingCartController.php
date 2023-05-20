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
            if (Auth::check()) {
                Order::addIds("$id.", Auth::id());
            }
            return true;
            Log::info("Añadido producto a carrito");
        } else {
            setcookie("shoppingCartProductsId", $_COOKIE["shoppingCartProductsId"] . "$id.", ["Path" => "/", "SameSite" => "Lax"]);
            if (Auth::check()) {
                Order::addIds($id, Auth::id());
            }
            return true;
            Log::info("Añadido producto a carrito");
        }
    }

    public function delProduct($id)
    {
        if (isset($_COOKIE["shoppingCartProductsId"])) {
            setcookie("shoppingCartProductsId", str_replace("$id.", "", $_COOKIE["shoppingCartProductsId"]), ["Path" => "/", "SameSite" => "Lax"]);
            if (Auth::check()) {
                Order::delIds($id);
            }
            return true;
            Log::info("Eliminado producto de carrito");
        }
    }

    /**
     * La función confirma un pedido al verificar si el usuario tiene un carrito, si los productos en
     * el carrito aún están disponibles y luego cierra el pedido.
     * 
     * @return view sea una redirección a la página del tablero o una vista del carrito de compras con
     * errores, si los hay.
     */
    public function confirmOrder()
    {
        Log::debug("Confirmar pedido");

        $userId = Auth::user()->id;
        $order = Order::where('user_id', '=', $userId)->where('in_process', '=', 1)->first();

        if ($order == null) {
            $errors = ['No se ha encontrado el carrito'];
            return $this->showShoppingCartWithErrors($errors);
        }

        $products = Order::getOrderProducts($order->id);

        $errors = [];

        foreach ($products as $product) {
            if ($product->sellet_at != null || $product->isVisible == 0 || $product->isDeleted == 1) {
                array_push($errors, "El producto <strong>{$product->name}</strong> ya no està disponible. Eliminalo para poder hacer el pedido.");
            }
        }

        if (!empty($errors)) {
            return $this->showShoppingCartWithErrors($errors);
        }

        $result = Order::closeOrder($order->id);

        if($result != "true"){

            $errors = [$result];
            return $this->showShoppingCartWithErrors($errors);
        }

        $orderId = $order->id;
        return redirect()->route('order.summary', ['id' => $order->id]);
    }


    /**
     * Esta función muestra el carrito de compras con errores y recupera información de productos de
     * cookies y categorías de la base de datos.
     * 
     * @param errors  es una variable que contiene una matriz de mensajes de error que
     * ocurrieron durante la ejecución de una función o método. Se pasa como un parámetro a la función
     * showShoppingCartWithErrors() para mostrar los mensajes de error al usuario en la página del
     * carrito de compras.
     * 
     * @return una vista llamada 'shoppingCart.shoppingCart' con una variedad de categorías, una
     * variedad de errores y una variedad de información del producto.
     */
    private function showShoppingCartWithErrors($errors)
    {
        if (!isset($_COOKIE["shoppingCartProductsId"])) {
            $producte = [];
        } else {
            $producte = Product::getInfoFromId($_COOKIE['shoppingCartProductsId']);
        }
        $categories = Category::all();
        return view('shoppingCart.shoppingCart', ['categories' => $categories, 'errors' => $errors], ['producte' => $producte]);
    }
}
