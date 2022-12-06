<?php

namespace App\Listeners\School;

use App\Concrete\DatabaseQueue;
use App\Events\School\EmailInvite;
use Illuminate\Contracts\Queue\ShouldQueue;

class EmailInviteHandler implements ShouldQueue
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
     * @param EmailInvite $event
     * @return void
     */
    public function handle(EmailInvite $event)
    {
        //todo send school invite email
        logger()?->info(sprintf('Event: %s , School: %s , Teacher: %s Email Handled', $event::class, $event->invite->school_id, $event->invite->email));
    }
}
