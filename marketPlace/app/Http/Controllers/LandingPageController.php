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
        if (count($productsFilter[0]) > 0) {
            # code...
        
        //  dd($productsFilter);
        return view('landingPage', ['titles' => $productsFilter[0],'products' => $productsFilter[1]], ['categories' => Category::all()->where('parent_id', '=', null)]);
        }

        return redirect()->route('home.index');
    }

    public function showAll($id)
    {
        // Paginator::defaultView('default');
        $productsFilter = Product::landingPageFilter();
        // dd($productsFilter[1]);
        return view('home.index', ['titles' => $productsFilter[0],'products' => $productsFilter[1][$id]], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }
}
