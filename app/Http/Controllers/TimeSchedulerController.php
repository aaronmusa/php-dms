<?php

namespace App\Http\Controllers;

use App\TimeScheduler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Config;


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
        $timeLogs = TimeScheduler::all();
        $timeManagement = json_encode(array("time_management" => $timeLogs));

        $websocketUrl = Config::get('websocket.url');

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->times);
        foreach($request->times as $time) {
            $timeScheduler = TimeScheduler::create($time);
            $timeScheduler->save();
        }

        return redirect('/time-scheduler');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\TimeScheduler  $timeScheduler
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TimeScheduler $timeScheduler)
    {   

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
        dd("pasok");

        $timeScheduler = TimeScheduler::find($timeScheduler->id);
        $timeScheduler->delete();

        //return redirect('/time-scheduler');
    }
}
