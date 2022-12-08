<?php

namespace App\WebSocket\Protocol;

use App\Constants\Target;
use App\Contact\WebsocketProtocolHandlerInterface;
use App\Models\Admin;
use App\Models\Student;
use App\Models\Teacher;
use App\WebSocket\ConnectionManager;
use App\WebSocket\Resource\Message;
use Nette\Utils\Json;
use Workerman\Connection\TcpConnection;

class SendMessage implements WebsocketProtocolHandlerInterface
{
    protected ConnectionManager $connection;

    public function __construct()
    {
        $this->connection = ConnectionManager::getInstance();
    }

    public function handle(TcpConnection $connection, array $data): void
    {
        $user = $this->connection->getUserByConnection($connection);
        if ($user === null) {
            $connection->close('unauthenticated');
            return;
        }

        @(['receive_type' => $receiveType, 'receive_id' => $receiveId, 'content' => $content] = $data);

        $receive = match (Target::from($receiveType)) {
            Target::Teacher => Teacher::findOrFail($receiveId),
            Target::Student => Student::findOrFail($receiveId),
            Target::Administrator => Admin::findOrFail($receiveId)
        };
        /** @var \App\Models\Message $message */
        $message = $user->messages()->create([
            'receive_type' => $receive::class,
            'receive_id' => $receive->id,
            'content' => $content,
        ]);
        $this->connection->getConnection($receive)
            ?->send(Json::encode([
                'protocol' => self::protocol(),
                'data' => (new Message($message))->toArray(),
            ]));
    }

    public static function protocol(): int
    {
        return 2;
    }
}
