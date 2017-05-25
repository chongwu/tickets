<?php

namespace TicketsTelegram\Mixins;

trait DialogsTrait {
    public function triggerCommand($command, $arguments = null)
    {
        $this->telegram->getCommandBus()->execute($command, $arguments, $this->update);
    }

    public function getMessageText()
    {
        return trim(preg_replace('/\s+/', ' ', $this->telegram->getWebhookUpdates()->getMessage()->getText()));
    }

    public function getKeyboardMarkup($keyboard)
    {
        return \Telegram::replyKeyboardMarkup([
            'keyboard' => $keyboard,
            'resize_keyboard' => true,
            'one_time_keyboard' => false,
        ]);
    }
}