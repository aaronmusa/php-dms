<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeScheduler;

class HomeController extends Controller

{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = TimeScheduler::all();
        return view('index', compact('logs'));
    }
}
