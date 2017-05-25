<?php

namespace App\Listeners;

use App\Events\TicketChangeEmployee;
use App\Notifications\TicketChangeEmployee as TicketChangeEmployeeNotification;
use App\Notifications\TicketRemoveEmployee;
use App\Ticket;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class TicketChangeEmployeeListener
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
     * @param  TicketChangeEmployee  $event
     * @return void
     */
    public function handle(TicketChangeEmployee $event)
    {
        /* @var Ticket $ticket */
        $ticket = $event->ticket;
        $prevEmployee = $event->prevEmployee;
        if($ticket->specialists->first()->id !== $prevEmployee->id){
            \Notification::send($ticket->specialists->first(), new TicketChangeEmployeeNotification($ticket));
            \Notification::send($prevEmployee, new TicketRemoveEmployee($ticket));
        }
    }
}
