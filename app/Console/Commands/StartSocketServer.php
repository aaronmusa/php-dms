<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\TimeScheduler;
use Config;
use Illuminate\Support\Facades\Storage;


class StartSocketServer extends Command
{
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
        
        $websocket = new \Hoa\Websocket\Server(new \Hoa\Socket\Server(Config::get('websocket.url')));
       

        $websocket->on('open', function (\Hoa\Event\Bucket $bucket) {
            $urlStorage = Storage::get('video-streaming-url.txt');
            $time_management = array("time_management" => TimeScheduler::all());
            $liveUrl =  array("live_url" => $urlStorage);
            echo "Connection Opened\n";
            $bucket->getSource()->send(json_encode($time_management));
            $bucket->getSource()->send(json_encode($liveUrl));
            return;
        });

        $websocket->on('message', function (\Hoa\Event\Bucket $bucket) {
            $data = $bucket->getData();
            echo 'message: ', $data['message'], "\n";
            $bucket->getSource()->broadcast($data['message']);

            return;
        });

        $websocket->on('close', function (\Hoa\Event\Bucket $bucket) {
            echo "Connection Closed.\n";
            return;
        });

        $websocket->run();
    }
}
