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
        $producte = Product::getInfoFromId($_SESSION["ids"]);
        $categories = Category::all();
        Log::info("ShoppingCart-Header number of categories: " . count($categories));
        return view('shoppingCart.shoppingCart', ['categories' => $categories], ['producte' => $producte]);
    }
}
