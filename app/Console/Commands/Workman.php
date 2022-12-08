<?php

namespace App\Console\Commands;

use App\WebSocket\Server;
use Illuminate\Console\Command;

class Workman extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workman:websocket {action} {--daemonize}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'workman websocket';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        global $argv;
        $action = $this->argument('action');
        $argv[0] = 'workerman:websocket';
        $argv[1] = $action;
        $argv[2] = $this->option('daemonize') ?? '-d';

        // Create a Websocket server
        $websocket = sprintf('websocket://%s:%s', env('WEBSOCKET_SERVER_HOST'), env('WEBSOCKET_SERVER_PORT'));
        $server = Server::register($websocket);
        $server::runAll();
        return Command::SUCCESS;
    }
}
