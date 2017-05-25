<?php

namespace TicketsTelegram\Commands;

use Telegram\Bot\Actions;
use Telegram\Bot\Commands\Command;
use TicketsTelegram\Dialogs\StartDialog;
use TicketsTelegram\Keyboard;

class StartCommand extends Command
{

    /**
     * Имя команды в Telegram.
     *
     * @var string
     */
    protected $name = 'start';

    protected $description = 'Первоначальное соединение с ботом';

    /**
     * {@inheritdoc}
     */
    public function handle($arguments)
    {
        \Dialogs::add(new StartDialog($this->update));
        // This will send a message using `sendMessage` method behind the scenes to
        // the user/chat id who triggered this command.
        // `replyWith<Message|Photo|Audio|Video|Voice|Document|Sticker|Location|ChatAction>()` all the available methods are dynamically
        // handled when you replace `send<Method>` with `replyWith` and use the same parameters - except chat_id does NOT need to be included in the array.
//        $this->replyWithMessage(['text' => 'Hello! Welcome to our bot, Here are our available commands:']);

        // This will update the chat status to typing...
//        $this->replyWithChatAction(['action' => Actions::TYPING]);

        // This will prepare a list of available commands and send the user.
        // First, Get an array of all registered commands
        // They'll be in 'command-name' => 'Command Handler Class' format.
//        $commands = $this->getTelegram()->getCommands();

        // Build the list
        /*$response = '';
        foreach ($commands as $name => $command) {
            $response .= sprintf('/%s - %s' . PHP_EOL, $name, $command->getDescription());
        }

        $reply_markup = \Telegram::replyKeyboardMarkup([
            'keyboard' => Keyboard::DEFAULT_KB,
            'resize_keyboard' => true,
            'one_time_keyboard' => true,
        ]);*/

        // Reply with the commands list
//        $this->replyWithMessage(['text' => $response, 'reply_markup' => $reply_markup]);

        // Trigger another command dynamically from within this command
        // When you want to chain multiple commands within one or process the request further.
        // The method supports second parameter arguments which you can optionally pass, By default
        // it'll pass the same arguments that are received for this command originally.
//        $this->triggerCommand('subscribe');
    }
}