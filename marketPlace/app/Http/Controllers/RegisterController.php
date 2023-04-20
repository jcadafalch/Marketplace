<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRegister;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;

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

         User::create([
             'name' => $request->nombreUsuario,
             'email' => $request->email,
             'password' => Hash::make($request->contraseña),
             'remember_token' => Str::random(10),
            ]);
            
            
        Log::info("Nuevo usuario registrado: ");
        Log::info($request);

        return redirect()->route('auth.login')->with('status', 'Se acaba de enviar un correo para verificar el registro.');
    }
}
