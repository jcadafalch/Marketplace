<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class LogInController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function recoveryPassword()
    {
        return view('auth.recoveryPassword');
    }

    public function recoveryPasswordSender(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_reset_tokens')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now(),
            'expires_at' => Carbon::now()->addDay()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Recuperar contraseña');
        });

        return back()->with('message', 'Hemos enviado un correo con el enlace para recuperar la contraseña!');
    }

    public function showResetPasswordForm($token)
    {
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_reset_tokens')
            ->where([
                'email' => $request->email,
                'token' => $request->token,
                ['expires_at', '>', Carbon::now()]
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        //DB::table('password_reset_tokens')->where(['email' => $request->email])->delete();
        
        return redirect()->route('auth.login')->with('message', 'La contraseña se ha cambiado correctamente!');
    }

    public function createNewTenant()
    {
        return view('tenant.createNewTenant', ['categories' => Category::all()]);
    }

    public function doLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            if (!isset($_COOKIE["shoppingCartProductsId"])) {
                Order::getIdsFromUserId(Auth::id());
                //crear cookie con ids
            } else {
                Order::addIds($_COOKIE["shoppingCartProductsId"], Auth::id());
            }
            $request->session()->regenerate();
            return redirect()->intended(route('home.index'));
        } else {
            return back()->withErrors(['login' => 'El nombre de usuario o correo electrónico o contraseña son incorrectos.'])->withInput();
        }
    }
}
