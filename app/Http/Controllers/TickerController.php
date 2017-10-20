<?php

namespace App\Http\Controllers;

use App\Ticker;
use Illuminate\Http\Request;
use Config;

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

        return view('TickerManagement.ticker', compact('tickers', 'tickerManagement','websocketUrl'));
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
        return view('TickerManagement.add_ticker');
    }
    
    public function showEditTickerPage($id){
        $ticker = Ticker::find($id);
        $tickerMessage = $ticker->message;
        $startTime = $ticker->start_time;
        $endTime = $ticker->end_time;
        return view('TickerManagement.edit_ticker', compact('startTime','tickerMessage','endTime','id'));
    }

    public function retrieveTickers(){
        $tickerLogs = Ticker::all();
        $tickers = json_encode(array("tickers" => $tickerLogs));

        return $tickers;
    }
}
