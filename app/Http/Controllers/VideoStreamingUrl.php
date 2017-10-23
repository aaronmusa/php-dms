<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoStreamingUrl extends Controller
{

    public function setUrl(Request $request) {
    	$url = $request->videoStreamingUrl;
    	Storage::disk('local')->put('video-streaming-url.txt', $url);
    	// $videoStreamingUrl = Storage::get('file1.txt');
    	return redirect('/time-scheduler');
    }

    public function setTickerMessage(Request $request) {
    	$url = $request->tickerInput;
    	Storage::disk('local')->put('ticker-message.txt', $url);
    	// $videoStreamingUrl = Storage::get('file1.txt');
    	return redirect('/ticker');
    }
}
