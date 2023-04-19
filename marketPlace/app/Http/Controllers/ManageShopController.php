<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ManageShopController extends Controller
{
    public function index()
    {
        return view('manage.manageShop', ['categories' => Category::all()]);
    }
}
