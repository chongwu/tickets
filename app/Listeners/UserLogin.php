<?php

namespace App\Listeners;

use App\User;
use Illuminate\Auth\Events\Login;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserLogin
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        /* @var User $user */
        $user = $event->user;
        $user->specialist = $user->adldapUser->inGroup(env('SPECIALIST_GROUP', 'Отдел ИСиТ'));
        $user->header = $user->adldapUser->inGroup(env('ADMIN_GROUP', 'Руководитель системы заявок'));//Руководитель системы заявок
        $user->save();
    }
}
