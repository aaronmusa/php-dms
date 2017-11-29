<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Config;
use App\ControlPanel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Traits\ControlPanelTrait;

class ControlPanelController extends Controller
{
    use ControlPanelTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

         $controlPanelData = $this->selectControlPanel();
         $urlStorage = "about:blank";


        $websocketUrl = Config::get('websocket.url');
        $tickerMessageExists = Storage::disk('local')->exists('ticker-message.txt');
        if (!$tickerMessageExists) {
            $tickerMessage = "Sample Ticker";
            Storage::disk('local')->put('ticker-message.txt', $urlStorage);
        }
        else{
            $tickerMessage = Storage::get('ticker-message.txt');
            
            if ($tickerMessage == ''){
                $tickerMessage = "Sample Ticker";
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
        $controlPanelData = $this->selectControlPanel();

         return json_encode($controlPanelData);
    }
}
