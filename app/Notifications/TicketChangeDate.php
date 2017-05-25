<?php

namespace App\Notifications;

use App\Ticket;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TicketChangeDate extends Notification
{
    use Queueable;

    public $ticket;

    /**
     * Create a new notification instance.
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
            ->subject('[Заявка #'.$ticket->id.'] Изменение даты выполнения заявки')
            ->line('Заявитель: '.$ticket->author->name)
            ->line('Категория: '.$ticket->workType->name)
            ->line('Дата выполнения: '.$ticket->specialists->first()->ticket_complete_date)
            ->line('Заявка: '.$ticket->text)
            ->action('Просмотреть заявку', route('tickets.show', [$ticket->id]));
    }

    public function toTelegram($notifiable)
    {
        $ticket = $this->ticket;

        return TelegramMessage::create()
            ->to($notifiable->telegram_id)
            ->content(
                "*Заявка #{$ticket->id} (изменена дата выполнения)*\n*Заявитель:* {$ticket->author->name} \n*Категория:* {$ticket->workType->name} \n*Дата выполнения: *".$ticket->specialists->first()->ticket_complete_date." \n*Заявка:* \n {$ticket->text}"
            )
            ->button(
                'Просмотреть заявку',
                route('tickets.show', [$ticket->id])
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
