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
        $title = env('LANDING_PAGE_TITLE');
        Paginator::defaultView('default');
        $productsFilter = Product::landingPageFilter();
        return view('home.index', ['title' => $title,'products' => $productsFilter], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }
}
