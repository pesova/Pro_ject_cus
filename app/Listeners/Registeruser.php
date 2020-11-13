<?php

namespace App\Listeners;

use App\Events\UserRegistered;
use App\Notifications\WelcomeMessage;
use App\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class Registeruser
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        try {
            $user = new User;
            $user->phone_number = $event->user_data->phone_number;
            $user->password = $event->user_data->password;
            if ($user->save()) {
                $user->notify(new WelcomeMessage);
            }
            Log::info('User registered to database successfully');
        } catch (\Exception $e) {
            Log::error('Catch error: RegisterUserEvent -'. $e->getMessage());
        }
    }
}
