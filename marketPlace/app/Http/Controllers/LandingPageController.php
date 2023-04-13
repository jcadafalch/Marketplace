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
       
        Paginator::defaultView('default');
        $productsFilter = Product::landingPageFilter();

        dd($productsFilter);
        return view('home.index', ['title' => $productsFilter[0],'products' => $productsFilter[1]], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }
}
