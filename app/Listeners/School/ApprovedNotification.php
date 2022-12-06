<?php

namespace App\Listeners\School;

use App\Events\School\Approved;

class ApprovedNotification
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
     * @param Approved $event
     * @return void
     */
    public function handle(Approved $event)
    {
        //todo notify teacher for approved
        logger()?->info(sprintf('Event: %s , School: %s Approved', $event::class, $event->school->id));
    }
}
