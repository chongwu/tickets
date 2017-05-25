<?php

namespace App\Listeners;

use App\Events\TicketChangeDate;
use App\Notifications\TicketChangeDateForAuthor;
use App\Ticket;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketChangeDateListener
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  TicketChangeDate  $event
     * @return void
     */
    public function handle(TicketChangeDate $event)
    {
        /* @var Ticket $ticket*/
        $ticket = $event->ticket;
        \Notification::send($ticket->specialists()->first(), new \App\Notifications\TicketChangeDate($ticket));
        if($ticket->track){
            \Notification::send($ticket->author, new TicketChangeDateForAuthor($ticket));
        }
    }
}
