<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notification()
    {
        $allNotifications = auth()->user()->unreadNotifications;

        return view('admin.notifications', ['notifications' => $allNotifications]);
    }

    public function companyNotifications()
    {
        $allNotifications = auth()->guard('company')->user()->unreadNotifications;

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
