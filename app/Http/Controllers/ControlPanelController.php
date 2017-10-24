<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use App\ControlPanel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ControlPanelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $controlPanelData =  DB::select('SELECT * FROM control_panels order by time LIMIT 10');


        $websocketUrl = Config::get('websocket.url');
        $tickerMessageExists = Storage::disk('local')->exists('ticker-message.txt');
        if (!$tickerMessageExists) {
            $tickerMessage = "Sample Ticker";
            Storage::disk('local')->put('ticker-message.txt', $urlStorage);
        }
        else{
            $tickerMessage = Storage::get('ticker-message.txt');
            
            if ($tickerMessage == ''){
                $tickerMessage = "Sample Tocker";
            }
            else{
               $tickerMessage = Storage::get('ticker-message.txt'); 
            }  
        }

        $urlExists = Storage::disk('local')->exists('video-streaming-url.txt');
        if (!$urlExists) {
            $urlStorage = "about:blank";
            Storage::disk('local')->put('video-streaming-url.txt', $urlStorage);
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

        return view('ControlPanel.control_panel', compact('websocketUrl','controlPanelData','tickerMessage','urlStorage'));
    }

    public function fetchControlPanelView(){
         $controlPanelData =  DB::select('SELECT * FROM control_panels order by time LIMIT 10');

         return json_encode($controlPanelData);
    }
}
