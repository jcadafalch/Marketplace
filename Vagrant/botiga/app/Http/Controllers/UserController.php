<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\OrderLine;
use Illuminate\Http\Request;
use App\Http\Requests\UserEdit;
use App\Models\ProductOderLine;
use App\Models\CompleteOrderLine;
use Illuminate\Support\Facades\Log;
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
        $userShop = Shop::where('user_id', '=', $user_id)->first();
        $shops = Shop::all();
        $categories = Category::all()->where('parent_id', '=', null);

        return view('user.userProfile', ['categories' =>  $categories],['shop' => $userShop]);
    }

    public function editProfile(UserEdit $request)
    {
        $request->validated();

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
            if (!Hash::check($request->get('password'), $user->password)) {
                return back()->with('error', "La contraseña actual no es valida");
            } else {
                $user->password = Hash::make($request->string('newPassword'));
            }
        }

        $user->save();
        Log::info("Editado información de usuario:" . $user);
        return redirect()->route('user.userProfile', ['categories' => Category::all()->where('parent_id', '=', null)]);
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        setcookie("shoppingCartProductsId", "", time() - 3600);
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
        Log::info("Cerrado sesión se usuario");
    }

}
