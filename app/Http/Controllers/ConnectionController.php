<?php

namespace App\Http\Controllers;

use App\Connection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        return view('connections',compact('connections'));
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

    public function saveConnection(){
        try{
            $mac = "1235";
            $connection = DB::insert("insert into connections (socket_id,mac_address,local_time,server_time) select * from (select 'hsdhaj','samplemacaddress','12:12:13','12:23:24') as tmp where not exists (select mac_address from connections where mac_address = 'samplemacaddress') Limit 1"); 

            $updateConnection = DB::update("update connections set socket_id = '$mac',local_time = '13:13:13',server_time = '14:14:14' where mac_address = 'hello'");
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
}
