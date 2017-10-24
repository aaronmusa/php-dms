<?php

namespace App\Http\Controllers;

use App\Ticker;
use Illuminate\Http\Request;
use Config;
use Illuminate\Support\Facades\Storage;

class TickerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $tickers = Ticker::all();
        $tickerManagement = json_encode(array("tickers" => $tickers));

        $websocketUrl = Config::get('websocket.url');

        $exists = Storage::disk('local')->exists('ticker-message.txt');
        if (!$exists) {
            $tickerMessage = "Sample Ticker";
            Storage::disk('local')->put('ticker-message.txt', $tickerMessage);
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

        return view('TickerManagement.ticker', compact('tickers', 'tickerManagement','websocketUrl','tickerMessage'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $ticker = new Ticker;
        $ticker = Ticker::create($request->all());
        $ticker->save();

        return redirect('/ticker');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ticker  $ticker
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticker $ticker)
    {
        $chosenTicker = Ticker::find($ticker->id);
        $chosenTicker->update($request->all());
        $chosenTicker->save();

        return redirect('/ticker');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticker  $ticker
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticker $ticker)
    {
        $chosenTicker = Ticker::find($ticker->id);
        return ($chosenTicker->delete()) ? "1" : "0";
    }
        //Show add page
    public function showAddTickerPage(){
        $websocketUrl = Config::get('websocket.url');

        return view('TickerManagement.add_ticker',compact('websocketUrl'));
    }
    
    public function showEditTickerPage($id){
        $ticker = Ticker::find($id);
        $tickerMessage = $ticker->message;
        $startTime = $ticker->start_time;
        $endTime = $ticker->end_time;
        $websocketUrl = Config::get('websocket.url');
        return view('TickerManagement.edit_ticker', compact('startTime','tickerMessage','endTime','id','websocketUrl'));
    }

    public function retrieveTickersOnDelete(){
        $tickerLogs = Ticker::all();
        $tickers = json_encode(array("tickers" => $tickerLogs));

        return $tickers;
    }
}
