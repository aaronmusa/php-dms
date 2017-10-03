<?php

namespace App\Http\Controllers;

use App\TimeScheduler;
use Illuminate\Http\Request;


class TimeSchedulerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $logs = TimeScheduler::all();
        // dd($logs);
        // return view('index', compact('logs'));
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

        return redirect('/home');
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

        return redirect('/home');
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
        $timeScheduler->delete();

        return redirect('/home');
    }
}
