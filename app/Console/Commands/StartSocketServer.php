<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Config;


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

        $websocket = new \Hoa\Websocket\Server(new \Hoa\Socket\Server(Config::get('websocket.url')));

        $websocket->on('open', function (\Hoa\Event\Bucket $bucket) {
            echo "Connection Opened\n";
            return;
        });

        $websocket->on('message', function (\Hoa\Event\Bucket $bucket) {
            $data = $bucket->getData();
            // var_dump($bucket->getSource());
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
