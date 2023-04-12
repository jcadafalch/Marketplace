<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UserController extends Controller
{
    public function profile(){
        return view('user.profile',['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function userProfile(){
        return view('user.userProfile',['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function editProfile(Request $request){

        $id = 1; //Auth::user()->id;
        $user = User::findOrFail($id);

        $path = $request->file('profilePhoto')->storeAs('public/img', 'profileImg'.$id.'.jpg');

        $user->path = $path;

        $user->save();

        return view('user.profile',['categories' => Category::all()->where('parent_id', '=', null)]);
    }


}
