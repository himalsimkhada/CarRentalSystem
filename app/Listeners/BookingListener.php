<?php

namespace App\Listeners;

use App\Events\BookingEvent;
use App\Mail\BookingMail;
use App\Models\User;
use App\Notifications\BookingNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class BookingListener
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
    public function handle(BookingEvent $event)
    {
        $admins = User::whereIn('user_type', [1])->get();
        Notification::send($admins, new BookingNotification($event->user));
        Notification::send($event->company, new BookingNotification($event->user));
        Notification::send($event->user, new BookingNotification($event->user));

        // Mail::to($event->user->email)->send(new BookingMail($event->values));
    }
}
