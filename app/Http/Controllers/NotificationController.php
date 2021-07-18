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
use App\Notifications\NewReservationNotificationCompany;
use App\Notifications\NewReservationNotificationCurUser;
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

        return view('admin.notifications', ['notificationsRegistered' => $notificationsRegistered, 'notificationsReserved' => $notificationsReserved, 'notificationsPayment' => $notificationsPayment, 'notificationsRequest' => $notificationsRequest, 'notificationsApproved' => $notificationsApproved, 'notificationsDenied' => $notificationsDenied]);
    }

    public function companyNotifications()
    {
        $notificationsReserved = auth()->user()->unreadNotifications->whereIn('type', [NewReservationNotificationCompany::class]);
        $notificationsPayment = auth()->user()->unreadNotifications->whereIn('type', [NewPaymentNotificationCompany::class]);

        return view('company.notifications', ['notificationsReserved' => $notificationsReserved, 'notificationsPayment' => $notificationsPayment]);
    }

    public function userNotifications()
    {
        $notificationsReserved = auth()->user()->unreadNotifications->whereIn('type', [NewReservationNotificationCurUser::class]);
        $notificationsPayment = auth()->user()->unreadNotifications->whereIn('type', [NewPaymentNotificationCurUser::class]);
        $notificationsRequest = auth()->user()->unreadNotifications->whereIn('type', [NewPartnerRequestNotificationUser::class]);
        $notificationsApproved = auth()->user()->unreadNotifications->whereIn('type', [NewRequestApprovedNotificationUser::class]);
        $notificationsDenied = auth()->user()->unreadNotifications->whereIn('type', [NewRequestDeniedNotificationUser::class]);

        return view('user.notifications', ['notificationsReserved' => $notificationsReserved, 'notificationsPayment' => $notificationsPayment, 'notificationsRequest' => $notificationsRequest, 'notificationsApproved' => $notificationsApproved, 'notificationDenied' => $notificationsDenied]);
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
