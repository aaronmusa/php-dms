<?php

namespace App\Http\Controllers;

use App\TimeScheduler;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Config;
use Illuminate\Support\Facades\Input;


class TimeSchedulerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$timeLogs = TimeScheduler::all();
        $timeLogs = DB::table('time_schedulers AS a')
                    ->select('a.*','socket_id',DB::raw('case when b.name is null then "to all" else b.name end as name'))
                    ->leftJoin('connections AS b', 'a.mac_address', '=', 'b.mac_address')
                    ->get();
        $timeManagement = json_encode(array("time_management" => $timeLogs));
        
        $websocketUrl = Config::get('websocket.url');

        $exists = Storage::disk('local')->exists('video-streaming-url.txt');
        if (!$exists) {
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
        return view('TimeManagement.time_management', compact('timeLogs', 'timeManagement', 'urlStorage', 'websocketUrl'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->startTime);
        // foreach($request->times as $time) {
        //     $timeScheduler = TimeScheduler::create($time);
        //     $timeScheduler->save();
        // }
        $timeScheduler = new TimeScheduler;
        $timeScheduler->mac_address = "all";
        $timeScheduler->start_time = $request->start_time;
        $timeScheduler->end_time = $request->end_time;
        $timeScheduler->save();

        return redirect('/time-scheduler');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TimeScheduler  $timeScheduler
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeScheduler $timeScheduler){   
        $timeScheduler = TimeScheduler::find($timeScheduler->id);
        $timeScheduler->update($request->all());
        $timeScheduler->save();

        return redirect('/time-scheduler');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\TimeScheduler  $sotimeSchedulercket
     * @return \Illuminate\Http\Response
     */
    public function destroy(TimeScheduler $timeScheduler)
    {
        $timeScheduler = TimeScheduler::find($timeScheduler->id);

        return ($timeScheduler->delete()) ? "1" : "0";
    }
    //Show add page
    public function showAddPage(){
         $websocketUrl = Config::get('websocket.url');
        return view('TimeManagement.add_time',compact('websocketUrl'));
    }

    public function showEditPage($id){
        $timeLog = TimeScheduler::find($id);
        $startTime = $timeLog->start_time;
        $endTime = $timeLog->end_time;
        $websocketUrl = Config::get('websocket.url');
        return view('TimeManagement.edit_time', compact('startTime','endTime','id','websocketUrl'));
    }
    public function retrieveLogsOnDelete(){
        $timeLogs = DB::table('time_schedulers AS a')
                    ->select('a.*','b.socket_id',DB::raw('case when b.name is null then "to all" else b.name end as name'))
                    ->leftJoin('connections AS b', 'a.mac_address', '=', 'b.mac_address')
                    ->get();
        $timeManagement = json_encode(array("time_management" => $timeLogs));

        return $timeManagement;
    }

    public function addTimeInControlPanel(Request $request) {
        $timeScheduler = new TimeScheduler;
        $timeScheduler->mac_address = $request->mac_address;
        $timeScheduler->start_time = $request->start_time;
        $timeScheduler->end_time = $request->end_time;
        $timeScheduler->save();

        return "1";
    }

    public function deleteByEndTime(TimeScheduler $timeScheduler){
        $timeScheduler = TimeScheduler::find($timeScheduler->end_time);

        return ($timeScheduler->delete()) ? "1" : "0";
    }
}
