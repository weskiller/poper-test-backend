<?php

namespace App\WebSocket\Protocol;

use App\Contact\WebsocketProtocolHandlerInterface;
use App\WebSocket\ConnectionManager;
use Illuminate\Http\Request;
use Laravel\Passport\Guards\TokenGuard;
use Nette\Utils\Json;
use Workerman\Connection\TcpConnection;

class Auth implements WebsocketProtocolHandlerInterface
{

    public function handle(TcpConnection $connection, array $data): void
    {
        @(['identity' => $identity, 'access_token' => $access_token] = $data);
        $request = Request::create('/');
        $request->headers->add(['Authorization' => 'Bearer ' . $access_token]);
        /** @var TokenGuard $guard */
        $guard = auth($identity);
        dump($guard::class, $guard->setRequest($request)->user());
        if ($user = $guard->setRequest($request)->user()) {
            ConnectionManager::getInstance()->addConnection($user, $connection);
            $connection->send(Json::encode(['protocol' => self::protocol(), 'message' => 'authenticated']));
        } else {
            $connection->send(Json::encode(['protocol' => self::protocol(), 'message' => __('auth.failed')]));
        }
    }

    public static function protocol(): int
    {
        return 1;
    }
}
