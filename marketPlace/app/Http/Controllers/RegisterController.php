<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegister;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;

class RegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    /*public function index()
    {
        return view('auth.register');
    }*/

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('auth.register');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UserRegister $request)
    {

         $validated = $request->validated();

         $user = User::create([
             'name' => $request->nombreUsuario,
             'email' => $request->email,
             'password' => Hash::make($request->contraseña),
             'remember_token' => Str::random(10),
        ]);

        // $user = User::where('email','like',$request->email);
        event(new Registered($user));
        auth()->login($user);
        Log::info("Nuevo usuario registrado: ", ['nuevo usuario' => $newOrderLine]);

        return redirect()->route('auth.login')->with('message', 'Se ha enviado un correo para verificar el registro.');
    }
}
