<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['send_type', 'send_id', 'receive_type', 'receive_id', 'content'];

    public function send(): MorphTo
    {
        return $this->morphTo();
    }

    public function receive(): MorphTo
    {
        return $this->morphTo();
    }
}
