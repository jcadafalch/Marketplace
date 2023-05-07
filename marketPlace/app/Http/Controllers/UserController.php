<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Foundation\Http\FormRequest;

class UserController extends Controller
{
    public function profile()
    {
        return view('user.profile', ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function userProfile()
    {
        $user_id = Auth::user()->id;
        return view('user.userProfile',['shop'=> Shop::all()->where('user_id', '=', $user_id)], ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function editProfile(Request $request)
    {
        
        $id = Auth::user()->id;
        $user = User::findOrFail($id);

        if ($request->file('profilePhoto') !== null) {
            $extension = $request->file('profilePhoto')->getClientOriginalExtension();
            $img = 'profileImg' . Auth::user()->id . '.' .  $extension;
            $request->file('profilePhoto')->storeAs('public/img/profile', $img);
            $user->path = $img;
        }

        if ($request->string('userName') !== null && $request->string('userName')->length() > 0) {
            $user->name = $request->string('userName');
        }

        if ($request->string('password') !== null && $request->string('password')->length() > 0) {
            if (Hash::check($request->password, $user->password) == true) {
                $user->password = Hash::make($request->string('password'));
            }
        }

        $user->save();

        return redirect()->route('user.userProfile', ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        setcookie("shoppingCartProductsId", "", time()-3600);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
