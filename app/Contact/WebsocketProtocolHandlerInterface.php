<?php

namespace App\Contact;

use Workerman\Connection\TcpConnection;

interface WebsocketProtocolHandlerInterface
{
    public static function protocol(): int;

    public function handle(TcpConnection $connection, array $data): void;
}
