<?php

namespace App\Concrete;

trait DatabaseQueue
{
    public string $connection = 'database';

    public string $queue = 'default';
}
