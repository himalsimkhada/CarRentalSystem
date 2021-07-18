<?php

namespace App\Providers;

use App\Events\BookingPaid;
use App\Events\CarReserved;
use App\Events\PartnerRequest;
use App\Events\ReqApproved;
use App\Events\ReqDenied;
use App\Listeners\SendNewReservationNotification;
use App\Listeners\SendNewUserNotification;
use App\Listeners\SendPartnerApprovalNotification;
use App\Listeners\SendPartnerReqDeniedNotification;
use App\Listeners\SendPartnerReqNotification;
use App\Listeners\SendPaymentNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
            SendNewUserNotification::class,
        ],

        CarReserved::class => [
            SendNewReservationNotification::class,
        ],

        BookingPaid::class => [
            SendPaymentNotification::class,
        ],

        PartnerRequest::class => [
            SendPartnerReqNotification::class,
        ],

        ReqApproved::class => [
            SendPartnerApprovalNotification::class,
        ],

        ReqDenied::class => [
            SendPartnerReqDeniedNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
