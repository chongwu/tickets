<?php

namespace TicketsTelegram\Commands;

use App\User;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use TicketsTelegram\Mixins\CommandsTrait;

class CreatedTasks extends Command
{
    use CommandsTrait;
    protected $name = 'created';

    protected $description = 'Список созданных заданий';
    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage(['text' => 'Список созданных задач, которые можно взять в работу']);
        if($user = User::whereTelegramId($this->telegramUserId())->first()){
            $this->ticketListResponse($user->ticketsCanBeTaken());
        }
        else{
            $this->replyWithMessage(['text' => 'Ваш профиль Telegram не найден!']);
        }
    }
}