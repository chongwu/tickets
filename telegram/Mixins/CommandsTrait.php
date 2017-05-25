<?php

namespace TicketsTelegram\Mixins;

use App\Ticket;

trait CommandsTrait {
    public static function ticketView(Ticket $ticket)
    {
        return '*Заявка #'.$ticket->id.'*'.PHP_EOL
            .'*Плановая дата выполнения:*'.$ticket->complete_date->format('d.m.Y').PHP_EOL
            .'*Описание:*'.PHP_EOL.$ticket->text;
    }

    public function telegramMessage()
    {
        return $this->getTelegram()->getWebhookUpdates()->getMessage();
    }

    public function telegramUserId()
    {
        return $this->telegramMessage()->getChat()->getId();
    }

    public function ticketListResponse($tickets)
    {
        $response = '';
        if(!$tickets->isEmpty()){
            foreach ($tickets as $ticket){
                $response .= static::ticketView($ticket).(($ticket->id===$tickets->last()->id)?'':PHP_EOL.PHP_EOL);
            }
            $this->replyWithMessage(['text' => $response, 'parse_mode' => 'Markdown']);
        }
        else{
            $this->replyWithMessage(['text' => 'Список задач пуст']);
        }
        return $response;
    }
}