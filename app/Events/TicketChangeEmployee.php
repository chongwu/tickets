<?php

namespace App\Events;

use App\Ticket;
use App\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class TicketChangeEmployee
{
    use InteractsWithSockets, SerializesModels;

    public $ticket;
    public $prevEmployee;

    /**
     * Create a new event instance.
     * @param Ticket $ticket
     * @param \App\User $prevEmployee
     * @internal param int $ticket
     */
    public function __construct(Ticket $ticket, User $prevEmployee)
    {
        $this->ticket = $ticket; //Ticket::where('id', $ticketId)->first();
        $this->prevEmployee = $prevEmployee;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
