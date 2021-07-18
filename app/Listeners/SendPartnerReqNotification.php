<?php

namespace App\Listeners;

use App\Events\PartnerRequest;
use App\Models\User;
use App\Notifications\NewPartnerReqNotification;
use App\Notifications\NewPartnerRequestNotificationUser;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendPartnerReqNotification
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
    public function handle(PartnerRequest $event)
    {
        $admins = User::whereIn('user_type', [1])->get();

        Notification::send($admins, new NewPartnerReqNotification($event->user));
        Notification::send($event->user, new NewPartnerRequestNotificationUser($event->user));
    }
}
