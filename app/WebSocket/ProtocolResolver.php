<?php

namespace App\WebSocket;

use App\Contact\WebsocketProtocolHandlerInterface;
use App\WebSocket\Protocol\Auth;
use App\WebSocket\Protocol\SendMessage;
use Workerman\Connection\TcpConnection;

class ProtocolResolver
{

    private static null|ProtocolResolver $instance = null;

    protected array $handlers = [];

    private function __construct()
    {
        $this->handlers = [
            Auth::protocol() => Auth::class,
            SendMessage::protocol() => SendMessage::class,
        ];
    }

    /**
     * @return static
     */
    public static function getInstance(): static
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function handle(int $protocol, TcpConnection $connection, array $data)
    {
        if (!isset($this->handlers[$protocol])) {
            $connection->close('Unregistered protocol');
            return;
        }
        /** @var WebsocketProtocolHandlerInterface $handler */
        $handler = new $this->handlers[$protocol];
        $handler->handle($connection, $data);
    }
}
