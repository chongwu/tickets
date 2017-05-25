<?php

namespace App\Listeners;

use App\Events\TicketEvent;
use App\Notifications\TicketApprove;
use App\Notifications\TicketCheck;
use App\Notifications\TicketConfirm;
use App\Notifications\TicketCreate;
use App\Ticket;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Notification;

class TicketListener
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
     * @param \App\Events\TicketEvent $event
     */
    public function handle(TicketEvent $event)
    {
        $ticket = $event->ticket;
//        $event->ticket->generateICalendar();
        $usersForNotify = $ticket->getUsersByWorkType()->unique('id');
        $author = $ticket->author;
        switch ($ticket->status){
            case Ticket::CREATED:
                Notification::send($usersForNotify, new TicketCreate($ticket));
                break;
            case Ticket::IN_WORK:
                if($ticket->track) Notification::send($author, new TicketConfirm($ticket));
                break;
            case Ticket::ON_APPROVAL:
                if($ticket->track) Notification::send($author, new TicketCheck($ticket));
                break;
            case Ticket::IN_REWORK:
            case Ticket::COMPLETED:
                Notification::send($ticket->specialists, new TicketApprove($ticket));
                break;

        }
    }
}
