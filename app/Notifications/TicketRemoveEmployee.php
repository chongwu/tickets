<?php

namespace App\Notifications;

use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TicketRemoveEmployee extends Notification
{
    use Queueable;

    public $ticket;
    public $message = 'Данная заявка направлена на исполнение другому специалисту.';

    /**
     * Create a new notification instance.
     * @param \App\Ticket $ticket
     * @param string $message
     */
    public function __construct(Ticket $ticket, $message = null)
    {
        $this->ticket = $ticket;
        if(!is_null($message)){
            $this->message = $message;
        }
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return !empty($notifiable->telegram_id)?[TelegramChannel::class, 'mail']:['mail'];
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
            ->subject('[Заявка #'.$ticket->id.'] Отмена выполнения заявки')
            ->line($this->message);
    }

    public function toTelegram($notifiable)
    {
        $ticket = $this->ticket;

        return TelegramMessage::create()
            ->to($notifiable->telegram_id)
            ->content(
                "*Заявка #{$ticket->id} (отмена выполнения заявки)*\n{$this->message}"
            );
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
