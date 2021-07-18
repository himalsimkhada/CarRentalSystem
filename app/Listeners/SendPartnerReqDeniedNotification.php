<?php

namespace App\Listeners;

use App\Events\ReqDenied;
use App\Models\User;
use App\Notifications\NewPartnerReqDeniedNotification;
use App\Notifications\NewRequestDeniedNotificationUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendPartnerReqDeniedNotification
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
    public function handle(ReqDenied $event)
    {
        $admins = User::whereIn('user_type', [1])->get();

        Notification::send($admins, new NewPartnerReqDeniedNotification($event->user));
        Notification::send($event->user, new NewRequestDeniedNotificationUser($event->user));
    }
}
