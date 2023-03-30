<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function profile(){
        return view('user.profile',['categories' => Category::all()->where('parent_id', '=', null)]);
    }
}
