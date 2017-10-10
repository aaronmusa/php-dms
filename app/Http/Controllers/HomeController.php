<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\TimeScheduler;
use Illuminate\Support\Facades\Storage;

use Config;

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
        $timeLogs = TimeScheduler::all();
        $timeManagement = json_encode(array("time_management" => $timeLogs));

        $websocketUrl = Config::get('websocket.url');

        // foreach ($logs as $log => $values){
        //     $data['time_management'][$log] = [
        //         'id' => $values->id,
        //         'start_time' => $values->start_time,
        //         'end_time' => $values->end_time

        //     ];
        // }
        // dd(json_encode($data));

        $exists = Storage::disk('local')->exists('video-streaming-url.txt');
        if (!$exists) {
            $urlStorage = "about:blank";
        }
        else{
            $urlStorage = Storage::get('video-streaming-url.txt');
            
            if ($urlStorage == ''){
                $urlStorage = "about:blank";
            }
            else{
               $urlStorage = Storage::get('video-streaming-url.txt'); 
            }  
        }
        return view('admin_bsb', compact('timeLogs', 'timeManagement', 'urlStorage', 'websocketUrl'));
    }
}
