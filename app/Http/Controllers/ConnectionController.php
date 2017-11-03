<?php

namespace App\Http\Controllers;

use App\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Config;

class ConnectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $connections = Connection::all();
        $websocketUrl = Config::get('websocket.url');
        return view('connections',compact('connections','websocketUrl'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function show(Connection $connection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function edit(Connection $connection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Connection $connection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Connection  $connection
     * @return \Illuminate\Http\Response
     */
    public function destroy(Connection $connection)
    {
        //
    }

    public function saveConnection($socketId,$macAddress,$time){
        try{
            $connection = DB::insert("insert into connections (socket_id,mac_address,local_time,server_time,status) select * from (select '$socketId','$macAddress','12:12:13','12:23:24',1) as tmp where not exists (select mac_address from connections where mac_address = '$macAddress') Limit 1"); 

            $updateConnection = DB::update("update connections set socket_id = '$socketId',local_time = '13:13:13',server_time = '14:14:14',status = 1 where mac_address = '$macAddress'");
            // $newConnection = new Connection;
            // $newConnection->socket_id = $socketId;
            // $newConnection->mac_address = $macAddress;
            // $newConnection->local_time = "12:13:14";
            // $newConnection->server_time = "13:23:43";
            // $newConnection->status = 1;
            // $newConnection->save();
             //var_dump($connection[0]->mac_address);
        }catch (\Exception $e) {
             dd($e->getMessage());
        }
       
        return "1";
    }
    public function closedConnection($socketId){
        $updateConnection = DB::update("update connections set status = 0 where socket_id = '$socketId'");
    }
    public function fetchConnectionsTable(){
        $connections =  DB::select("SELECT * FROM connections where mac_address != ''");

         return json_encode($connections);
    }
}
