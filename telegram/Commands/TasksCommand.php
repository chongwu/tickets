<?php

namespace TicketsTelegram\Commands;

use App\User;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use TicketsTelegram\Mixins\CommandsTrait;

class TasksCommand extends Command
{
    use CommandsTrait;

    protected $name = 'tasks';

    protected $description = 'Получение списка заданий для выполнения';

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage(['text' => 'Ваш список задач для исполнения:']);
        /* @var User $user */
        if($user = User::with(['activeTickets'])->whereTelegramId($this->telegramUserId())->first())
        {
            $this->ticketListResponse($user->workTickets);
        }
        else{
            $this->replyWithMessage(['text' => 'Ваш профиль Telegram не найден!']);
        }
    }
}