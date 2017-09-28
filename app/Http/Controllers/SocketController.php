<?php

namespace App\Http\Controllers;

use App\Socket;
use Illuminate\Http\Request;

class SocketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $logs = Socket::all();
        return view('index', compact('logs'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        foreach($request->times as $time) {
            $socket = Socket::create($time);
            $socket->save();
        }

        return redirect('/');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Socket  $socket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Socket $socket)
    {
        $socket = Socket::find($request->id);
            $socket->start_time   = $request->input('start_time');
            $nerd->end_time       = $request->input('end_time');
            $nerd->save();

            return view('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Socket  $socket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Socket $socket)
    {
        $socket = Socket::find($socket->id);
        $socket->delete();
        
        return view('/');
    }
}
