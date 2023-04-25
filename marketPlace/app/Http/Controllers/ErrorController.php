<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ErrorController extends Controller
{
    public function productNotFoundError()
    {
        return view('errors.productNotFound',['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function shopNotFoundError()
    {
        return view('errors.shopNotFound',['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function genericError()
    {
        return view('errors.genericError',['categories' => Category::all()->where('parent_id', '=', null)]);
    }
}
