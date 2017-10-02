<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

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
        $ip = "120.0.0.1";
        $porta = "80";
        $websocket = new \Hoa\Websocket\Server(new \Hoa\Socket\Server('ws://127.0.0.1:80'));

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
