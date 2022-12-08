<?php

namespace App\WebSocket;

use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use Workerman\Connection\TcpConnection;

class ConnectionManager
{

    private static null|ConnectionManager $instance = null;

    protected array $sockets = [];

    protected array $users = [];

    private function __construct()
    {
    }

    public function addConnection(Admin|Teacher|Student $user, TcpConnection $connection): void
    {
        $identify = self::identify($user);
        $this->users[$identify] = $connection->id;
        $this->sockets[$connection->id] = $identify;
    }

    public static function identify(Admin|Teacher|Student $user): string
    {
        return $user::class . ':' . $user->getKey();
    }

    public function delConnection(Admin|Teacher|Student $user): void
    {
        $this->getConnection($user)?->close('bye');
    }

    public function getConnection(Admin|Teacher|Student $user): TcpConnection|null
    {
        $identify = self::identify($user);
        if (!isset($this->users[$identify])) {
            return null;
        }
        return $this->getConnectionById($this->users[$identify]);
    }

    public function getConnectionById(int $id): TcpConnection|null
    {
        return Server::getInstance()->getConnections()[$id] ?? null;
    }

    public static function getInstance(): static
    {
        if (self::$instance === null) {
            self::$instance = new static();
        }
        return self::$instance;
    }

    public function getUserByConnection(TcpConnection $connection): Admin|Teacher|Student|null
    {
        $identify = $this->getIdentifyByConnectionId($connection->id);
        if ($identify === null) {
            return null;
        }
        return self::parseIdentify($identify);
    }

    public function getIdentifyByConnectionId(int $id): string|null
    {
        return $this->sockets[$id] ?? null;
    }

    public static function parseIdentify(string $identify): Admin|Teacher|Student
    {
        /** @var $model Admin|Teacher|Student */
        [$model, $key] = explode(':', $identify);
        return (new $model)->findOrFail($key);
    }

    public function exists(TcpConnection $connection): bool
    {
        return isset($this->sockets[$connection->id]);
    }

}
