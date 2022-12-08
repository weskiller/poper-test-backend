<?php

namespace App\WebSocket\Resource;

use App\Constants\Target;
use Illuminate\Contracts\Support\Arrayable;

class Message implements Arrayable
{
    public function __construct(public \App\Models\Message $resource)
    {
    }

    public function toArray()
    {
        return [
            'id' => $this->resource->id,
            'send_type' => Target::fromModel($this->resource->send_type)->value,
            'send_id' => $this->resource->send_id,
            'receive_type' => Target::fromModel($this->resource->receive_type)->value,
            'receive_id' => $this->resource->receive_id,
            'content' => $this->resource->content,
            'created_at' => (string)$this->resource->created_at,
        ];
    }
}
