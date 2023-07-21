<?php

namespace App\Listeners;

use App\Events\CarReserved;
use App\Models\User;
use App\Notifications\NewReservationNotification;
use App\Notifications\NewReservationNotificationCompany;
use App\Notifications\NewReservationNotificationCurUser;
use Illuminate\Support\Facades\Notification;

class SendNewReservationNotification
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
    public function handle(CarReserved $event)
    {
        $curr_user = auth()->user()->id;

        $admins = User::whereIn('user_type', [1])->get();

        $user = User::where('id', '=', $curr_user)->get();

        Notification::send($admins, new NewReservationNotification($event->user));
        Notification::send($event->company, new NewReservationNotificationCompany($event->user));
        Notification::send($user, new NewReservationNotificationCurUser($event->user));
    }
}
