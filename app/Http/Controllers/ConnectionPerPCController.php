<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Config;

use Illuminate\Http\Request;

class ConnectionPerPCController extends Controller
{
    public function show($macAddress){

    	$panelData = DB::select("SELECT * FROM connection_per_pc_view where mac_address = '$macAddress'");
    	$currentConnection = DB::select("SELECT * FROM connections where mac_address = '$macAddress'");
    	$websocketUrl = Config::get('websocket.url');

	return view('connection.panel',compact('panelData','websocketUrl','currentConnection'));
    }
}
