<?php

namespace App\Listeners;

use App\Events\RegistrationEvent;
use App\Models\User;
use App\Notifications\RegistrationNotification;
use Illuminate\Support\Facades\Notification;

class RegistrationListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(RegistrationEvent $event)
    {
        $admin = User::whereIn('user_type', [1])->get();

        Notification::send($admin, new RegistrationNotification($event->user));
    }
}
