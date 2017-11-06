<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\TimeScheduler;
use App\Ticker;
use Config;
use Illuminate\Support\Facades\Storage;
use WebSocket\Client;


class StartSocketServer extends Command
{
    private $websocket;
    private $url;
    private $socketIds = [];
    private $oldSocketIds = [];

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'socket:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->url = Config::get('websocket.url');
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        date_default_timezone_set('Asia/Manila'); // CDT


        
        $this->websocket = new \Hoa\Websocket\Server(new \Hoa\Socket\Server($this->url));       

        $this->websocket->on('open', function (\Hoa\Event\Bucket $bucket) {
            try{
                $urlStorage = Storage::get('video-streaming-url.txt');
                $time_management = array("time_management" => TimeScheduler::all());
                $tickers = array("tickers" => Ticker::all());
                $liveUrl =  array("live_url" => $urlStorage);
                 echo "Connection Opened\n";
                $bucket->getSource()->send(json_encode($time_management));
                $bucket->getSource()->send(json_encode($tickers));
                $bucket->getSource()->send(json_encode($liveUrl));
            }catch(\Exception $e){
                dd($e->getMessage());
            }
            

            return;
        });

        $this->websocket->on('message', function (\Hoa\Event\Bucket $bucket) {
            try{
                $data = $bucket->getData();
                $message = $data['message'];
                
                if ($message == "check ids") {
                    $socketIds = []; //Socket ids to be marked as offline in connection table

                    //Check if oldsocketids have data
                    if (count($this->oldSocketIds) > 0) {
                        //Check if oldsocketid still exists in the new socket ids
                        //var_dump($this->oldSocketIds);
                        foreach ($this->oldSocketIds as $oldSocketId){
                            $isOnline = false; //Default value is false if socket id does not exist in the old oscket id

                            //If old socket id exists in new socket id mark is online to true
                            if (in_array($oldSocketId, $this->socketIds)){
                                $isOnline = true;
                                app('App\Http\Controllers\ConnectionController')->openConnection($oldSocketId);
                            }

                            //if is online is false push socket id to the socketids array
                            if ($isOnline == false){
                                array_push($socketIds,$oldSocketId);
                            }
                        }

                        //Mark socket ids offline in connection table\
                        foreach($socketIds as $socketId){
                            app('App\Http\Controllers\ConnectionController')->closedConnection($socketId);
                        }  

                        if (count($socketIds) > 0) {
                            var_dump($socketIds);
                            echo "update connections after delete\n";
                            $bucket->getSource()->send("update_connections");
                            $socketIds = [];
                        }
                    }

                    $this->oldSocketIds = $this->socketIds;
                    $this->socketIds = [];

                } else {
                    echo 'message: ', $message, "\n";      
                    $bucket->getSource()->broadcast($message);     

                    $macAddress =  json_decode($message)->mac_address;
                        echo "save connection\n";

                    if ($macAddress) {
                        $nodeId     = $bucket->getSource()->getConnection()->getCurrentNode()->getId();
                        $time       =     json_decode($message)->time;
                        
                        app('App\Http\Controllers\ConnectionController')->saveConnection($nodeId,$macAddress,$time);
                        $bucket->getSource()->broadcast("update_connections");
                    }  
                }
                
            }catch(\Exception $e){
                $e->getMessage();
            }
            
            return;
        });

        $this->websocket->on('close', function (\Hoa\Event\Bucket $bucket) { 
            try{
                $nodeId = $bucket->getSource()->getConnection()->getCurrentNode()->getId();
                app('App\Http\Controllers\ConnectionController')->closedConnection($nodeId);
                echo "Connection Closed.\n";
            }catch(\Exception $e){
                dd($e->getMessage());
            }
           
            return;
        });

        $this->websocket->on('ping', function (\Hoa\Event\Bucket $bucket) { 
            $nodeId     = $bucket->getSource()->getConnection()->getCurrentNode()->getId();
            if (!in_array($nodeId, $this->socketIds)){
                array_push($this->socketIds, $nodeId);
            }
            echo $nodeId . "\n";
           //$bucket->getSource()->broadcast("ping send");
            return;
        });

        $this->websocket->run();

    }
}
