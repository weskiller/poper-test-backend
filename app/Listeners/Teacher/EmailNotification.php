<?php

namespace App\Listeners\Teacher;

use App\Concrete\DatabaseQueue;
use App\Events\Teacher\Register;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailNotification implements ShouldQueue
{
    use DatabaseQueue;

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
     * @param Register $event
     * @return void
     */
    public function handle(Register $event)
    {
        //todo email verification
        logger()?->info(sprintf('Event: %s , Teacher: %s Register', $event::class, $event->teacher->id));
    }
}
