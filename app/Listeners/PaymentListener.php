<?php

namespace App\Listeners;

use App\Events\PaymentEvent;
use App\Mail\CompanyPaymentRecieveMail;
use App\Mail\UserPaymentMail;
use App\Models\User;
use App\Notifications\PaymentNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification;

class PaymentListener
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
    public function handle(PaymentEvent $event)
    {
        $admin = User::whereIn('user_type', [1])->get();

        Notification::send($admin, new PaymentNotification($event->user));
        Notification::send($event->company, new PaymentNotification($event->company));
        Notification::send($event->user, new PaymentNotification($event->user));
        // Mail::to($event->user->email)->send(new UserPaymentMail($event->values));
        // Mail::to($event->company->email)->send(new CompanyPaymentRecieveMail($event->values, $event->company));
    }
}
