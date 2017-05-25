<?php

namespace App\Notifications;

use App\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\Telegram\TelegramChannel;
use NotificationChannels\Telegram\TelegramMessage;

class TicketApprove extends Notification
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
        $message = new MailMessage();
        $message->view('vendor.notifications.email', ['ticket' => $ticket]);
        if($ticket->status === Ticket::IN_REWORK){

            $message->subject('[Заявка #'.$ticket->id.'] Отправлена на доработку')
            ->line('Заявка была отклонена сотрудником '.$ticket->author->name)
            ->line('Пожалуйста свяжитесь с данным сотрудником для выяснения сложившейся ситуации.')
            ->action('Просмотреть заявку', route('tickets.show', [$ticket->id]));

        }
        else{
            $message->subject('[Заявка #'.$ticket->id.'] Выполнена')
                ->line('Заявка успешно выполнена!');
        }
        return $message;
    }

    public function toTelegram($notifiable)
    {
        $ticket = $this->ticket;
        $message = new TelegramMessage();
        $message->to($notifiable->telegram_id);
        if($ticket->status === Ticket::IN_REWORK){
            $message->content(
                "*Заявка #{$ticket->id} отклонена.*\nСвяжитесь с сотрудником {$ticket->author->name} для выяснения сложившейся ситуации."
            )
                ->button(
                    'Просмотреть заявку',
                    route('tickets.show', [$ticket->id])
                );
        }
        else{
            $message->content(
                "*Заявка #{$ticket->id} успешно выполнена!*"
            );
        }
        return $message;
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
