<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class LandingPageController extends Controller
{
    public function index()
    {
        // Paginator::defaultView('default');
        $productsFilter = Product::landingPageFilter();

        // Eliminar variables de session 
        session()->forget(['category', 'search']);

        if (count($productsFilter[0]) > 0) {
        return view('landingPage', ['titles' => $productsFilter[0],'products' => $productsFilter[1]], ['categories' => Category::all()->where('parent_id', '=', null)]);
        }

        return redirect()->route('home.index');
    }

    public function showAll($id)
    {
        $productsFilter = Product::landingPageFilter();
        return view('home.index', ['titles' => $productsFilter[0],'products' => $productsFilter[1][$id]], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }
}
