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
use Illuminate\Support\Facades\Log;
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

        
        /* Si la autenticación falla, redirige al usuario a la página de inicio de sesión con un 
        mensaje de error que indica que el correo electrónico o la contraseña son incorrectos. */
        if (!Auth::attempt($credentials)) {
            return redirect()->route('auth.login')->with('message', 'El nombre de usuario o correo electrónico o contraseña son incorrectos.');  
        }

        Log::info(Auth::user());
        
        /* Si la dirección de correo electrónico no está verificada, redirige al usuario a la 
        página de inicio de sesión con un mensaje de error que indica que el correo electrónico
        del usuario no está verificado y que debe comprobar su correo electrónico y verificar su registro. */
        if(!isset(Auth::user()->email_verified_at)){
            Log::info("Usuari no verificat");
            return redirect()->route('auth.login')->with('message', 'Usuario no verificado, revisa el correo y verifica el regitro');
        }

        $request->session()->regenerate();
        return redirect()->intended(route('home.index'));
    }
}
