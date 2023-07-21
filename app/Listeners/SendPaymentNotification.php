<?php

namespace App\Listeners;

use App\Events\BookingPaid;
use App\Models\User;
use App\Notifications\NewPaymentNotificationCompany;
use App\Notifications\NewPaymentNotificationCurUser;
use App\Notifications\PaymentNotification;
use Illuminate\Support\Facades\Notification;

class SendPaymentNotification
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
     * @param  object  $event
     * @return void
     */
    public function handle(BookingPaid $event)
    {
        $curr_user = auth()->user()->id;

        $user = User::where('id', '=', $curr_user)->get();

        $admins = User::whereIn('user_type', [1])->get();

        Notification::send($admins, new PaymentNotification($event->user));
        Notification::send($event->company, new NewPaymentNotificationCompany($event->user));
        Notification::send($user, new NewPaymentNotificationCurUser($event->user));
    }
}
