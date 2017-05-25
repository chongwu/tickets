<?php

namespace TicketsTelegram\Dialogs;


use App\User;
use BotDialogs\Dialog;
use GuzzleHttp\Client;
use TicketsTelegram\Keyboard;
use TicketsTelegram\Mixins\DialogsTrait;

class StartDialog extends Dialog
{
    use DialogsTrait;
    protected $steps = ['hello', 'comparison', 'parse'];

    public function hello()
    {
        $this->telegram->sendMessage([
            'chat_id' => $this->getChat()->getId(),
            'text' => 'Доброго времени суток! Введите паожалуйста своё Ф.И.О.!'
        ]);

    }

    public function comparison()
    {
        $fio = $this->getMessageText();
        $userId = $this->getChat()->getId();
        if($user = User::whereName($fio)->first()){
            $user->telegram_id = $userId;
            $user->save();
            $this->telegram->sendMessage([
                'chat_id' => $userId,
                'text' => 'Вы успешно подключены!',
                'reply_markup' => $this->getKeyboardMarkup(Keyboard::DEFAULT_KB)
            ]);
        }
        else{
            $this->telegram->sendMessage([
                'chat_id' => $userId,
                'text' => 'Поиски не дали результатов. Попробуйте снова.'
            ]);
            $this->jump('comparison');
        }
    }

    public function parse()
    {
        switch ($this->getMessageText()){
            case 'Изменить пользователя':
                $this->jump('hello');
                $this->triggerCommand('start');
                break;
            case 'Список задач':
                $this->telegram->sendMessage([
                    'chat_id' => $this->getChat()->getId(),
                    'text' => 'Выберите тип просматриваемых задач',
                    'reply_markup' => $this->getKeyboardMarkup(Keyboard::TASKS_KB)
                ]);
                $this->jump('parse');
                break;
            case 'Назад':
                $this->telegram->sendMessage([
                    'chat_id' => $this->getChat()->getId(),
                    'text' => 'Главное меню',
                    'reply_markup' => $this->getKeyboardMarkup(Keyboard::DEFAULT_KB)
                ]);
                $this->jump('parse');
                break;
            case 'В работе':
                $this->triggerCommand('tasks');
                $this->jump('parse');
                break;
            case 'Созданы':
                $this->triggerCommand('created');
                $this->jump('parse');
                break;
            case 'На подтверждении':
                $this->triggerCommand('on-approve');
                $this->jump('parse');
                break;
            default:
                $client = new Client();
                $result = $client->post('http://api.forismatic.com/api/1.0/', [
                    'form_params' => [
                        'method' => 'getQuote',
                        'format' => 'text'
                    ]
                ]);
                $this->telegram->sendMessage([
                    'chat_id' => $this->getChat()->getId(),
                    'text' => 'Простите, я Вас не понимаю. Используйте пожалуйста команды, размещенные на клавиатуре Telegram.'.PHP_EOL.PHP_EOL
                        .'Можете ещё прочитать цитату:'.PHP_EOL.$result->getBody(),
                ]);
                $this->jump('parse');
                break;
        }

    }
}