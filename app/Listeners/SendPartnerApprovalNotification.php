<?php

namespace App\Listeners;

use App\Events\ReqApproved;
use App\Models\User;
use App\Notifications\NewPartnerApprovedNotification;
use App\Notifications\NewRequestApprovedNotificationUser;
use Illuminate\Support\Facades\Notification;

class SendPartnerApprovalNotification
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
    public function handle(ReqApproved $event)
    {
        $admins = User::whereIn('user_type', [1])->get();

        Notification::send($admins, new NewPartnerApprovedNotification($event->user));
        Notification::send($event->user, new NewRequestApprovedNotificationUser($event->user));
    }
}
