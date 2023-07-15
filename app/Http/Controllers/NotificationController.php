<?php

namespace App\Http\Controllers;

use App\Notifications\NewPartnerApprovedNotification;
use App\Notifications\NewPartnerReqDeniedNotification;
use App\Notifications\NewPartnerReqNotification;
use App\Notifications\NewPartnerRequestNotificationUser;
use App\Notifications\NewPaymentNotificationCompany;
use App\Notifications\NewPaymentNotificationCurUser;
use App\Notifications\NewRequestApprovedNotificationUser;
use App\Notifications\NewRequestDeniedNotificationUser;
use App\Notifications\NewReservationNotification;
use App\Notifications\NewUserRegisteredNotification;
use App\Notifications\PaymentNotification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notification()
    {
        $notificationsRegistered = auth()->user()->unreadNotifications->whereIn('type', [NewUserRegisteredNotification::class]);
        $notificationsReserved = auth()->user()->unreadNotifications->whereIn('type', [NewReservationNotification::class]);
        $notificationsPayment = auth()->user()->unreadNotifications->whereIn('type', [PaymentNotification::class]);
        $notificationsRequest = auth()->user()->unreadNotifications->whereIn('type', [NewPartnerReqNotification::class]);
        $notificationsApproved = auth()->user()->unreadNotifications->whereIn('type', [NewPartnerApprovedNotification::class]);
        $notificationsDenied = auth()->user()->unreadNotifications->whereIn('type', [NewPartnerReqDeniedNotification::class]);

        $allNotifications = auth()->user()->unreadNotifications;

        return view('admin.notifications', ['notifications' => $allNotifications]);
    }

    public function companyNotifications()
    {
        $allNotifications = auth()->user()->unreadNotifications;

        return view('company.notifications', ['notifications' => $allNotifications]);
    }

    public function userNotifications()
    {
        $allNotifications = auth()->user()->unreadNotifications;

        return view('user.notifications', ['notifications' => $allNotifications]);
    }

    public function markNotification(Request $request)
    {
        auth()->user()
            ->unreadNotifications
            ->when($request->input('id'), function ($query) use ($request) {
                return $query->where('id', $request->input('id'));
            })
            ->markAsRead();

        return response()->noContent();
    }
}
