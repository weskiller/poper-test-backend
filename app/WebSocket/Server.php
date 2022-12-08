<?php

namespace App\WebSocket;

use Exception;
use Nette\Utils\Json;
use Nette\Utils\JsonException;
use Workerman\Connection\TcpConnection;
use Workerman\Timer;
use Workerman\Worker;

class Server extends Worker
{
    public static null|Server $instance = null;

    private function __construct(string $websocket = '', array $context_option = [])
    {
        parent::__construct($websocket, $context_option);
        $this->onConnect = [$this, 'connect'];
        $this->onMessage = [$this, 'message'];
    }

    public function connect(TcpConnection $connection): void
    {
        Timer::add(10, static function () use ($connection) {
            if (!ConnectionManager::getInstance()->exists($connection)) {
                $connection->close('authenticate time out');
            }
        });
    }

    public static function getInstance(): static
    {
        return self::$instance ?? self::register();
    }

    public static function register(string $websocket = '', array $context_option = []): static
    {
        if (self::$instance === null) {
            self::$instance = new static($websocket, $context_option);
        }
        return self::$instance;
    }

    public function message(TcpConnection $connection, string $text): void
    {
        try {
            $request = Json::decode($text, Json::FORCE_ARRAY);
            @(['protocol' => $protocol, 'data' => $data] = $request);
            if (!(isset($protocol, $data))) {
                $connection->close('invalid protocol');
                return;
            }
            ProtocolResolver::getInstance()->handle((int)$protocol, $connection, $data);
        } catch (JsonException) {
            $connection->close('invalid json content, closed');
        } catch (Exception $e) {
            logger()?->channel('websocket')->debug($e->getMessage() . "\n" . $e->getTraceAsString());
        }
    }

    /**
     * @return array
     */
    public function getConnections(): array
    {
        return $this->connections;
    }
}
