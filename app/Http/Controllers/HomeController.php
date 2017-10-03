<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeScheduler;
use Illuminate\Support\Facades\Storage;

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
        // foreach ($logs as $log => $values){
        //     $data['items'][$log] = []
           
        // }
        
        $exists = Storage::disk('local')->exists('video-streaming-url.txt');
        if (!$exists) {
            $urlStorage = "";
        }
        else{
            $urlStorage = Storage::get('video-streaming-url.txt');
        }
        return view('index', compact('logs','urlStorage'));
    }
}
