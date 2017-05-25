<?php

namespace App\Http\Controllers;

use BotDialogs\Dialogs;
use Illuminate\Http\Request;
use Telegram\Bot\Api;

class WebhookController extends Controller
{
    public function __construct(Api $telegram, Dialogs $dialogs)
    {
        $this->telegram = $telegram;
        $this->dialogs = $dialogs;
    }

    public function index()
    {
        /*$update = Telegram::commandsHandler(true);
        return 'ok';*/
        $update = $this->telegram->commandsHandler(true);

        if (!$this->dialogs->exists($update)) {
            // Do something if there are no existing dialogs
        } else {
            // Call the next step of the dialog
            $this->dialogs->proceed($update);
        }

    }
}
