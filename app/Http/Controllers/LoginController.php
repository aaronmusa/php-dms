<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index() {
        if (auth()->check()) {
            return redirect('/time-scheduler');
        }
        
        return view('login.login');
    }
}
