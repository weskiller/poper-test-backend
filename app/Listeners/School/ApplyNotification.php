<?php

namespace App\Listeners\School;

use App\Events\School\Created;

class ApplyNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Created $event
     * @return void
     */
    public function handle(Created $event)
    {
        //todo notify admin for approve
        logger()?->info(sprintf('Event: %s , School: %s Apply', $event::class, $event->school->id));
    }
}
