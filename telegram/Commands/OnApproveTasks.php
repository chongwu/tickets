<?php

namespace TicketsTelegram\Commands;

use App\User;
use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use TicketsTelegram\Mixins\CommandsTrait;

class OnApproveTasks extends Command
{
    use CommandsTrait;
    protected $name = 'on-approve';

    protected $description = 'Список задач на подтверждении';

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        $this->replyWithChatAction(['action' => Actions::TYPING]);
        $this->replyWithMessage(['text' => 'Список задач на подтверждении']);
        if($user = User::with(['onApproveTickets'])->whereTelegramId($this->telegramUserId())->first()){
            $this->ticketListResponse($user->onApproveTickets);
        }
        else{
            $this->replyWithMessage(['text' => 'Ваш профиль Telegram не найден!']);
        }
    }
}