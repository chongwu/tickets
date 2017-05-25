<?php

namespace App\Notifications;

use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class TicketCheck extends Notification
{
//    use Queueable;
    public $ticket;

    /**
     * Create a new notification instance.
     *
     * @param \App\Ticket $ticket
     */
    public function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $ticket = $this->ticket;
        return (new MailMessage)
            ->view('vendor.notifications.email', ['ticket' => $ticket])
            ->subject('[Заявка #'.$ticket->id.'] Выполнена')
            ->line('Уважаемый(-ая) '.$ticket->author->name.'!')
            ->line('Ваша заявка была исполнена.')
            ->line('Пожалуйста откройте заявку и одобрите или отклоните выполненную заявку.')
            ->line('Если в течение суток Вы этого не сделаете, заявка автоматически будет одобрена.')
            ->action('Просмотреть заявку', route('tickets.show', [$ticket->id]));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
