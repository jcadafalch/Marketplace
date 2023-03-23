<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogInController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function recoveryPassword(){
        return view('auth.recoveryPassword');
    }

    public function createNewTenant(){
        return view('tenant.createNewTenant');
    }
}
