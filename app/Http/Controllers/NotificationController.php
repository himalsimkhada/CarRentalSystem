<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        if (auth()->check()) {
            $notifications = auth()->user()->unreadNotifications;
        } else if (auth()->guard('company')->check()) {
            $notifications = auth()->guard('company')->user()->unreadNotifications;
        }

        return view('notification.index', ['notifications' => $notifications]);
    }

    public function getUnreadNotificationCount()
    {
        if (auth()->check()) {
            $count = auth()->user()->unreadNotifications()->count();
        } else if (auth()->guard('company')->check()) {
            $count = auth()->guard('company')->user()->unreadNotifications()->count();
        }

        return response()->json(['count' => $count]);
    }

    public function markNotification(Request $request)
    {
        if (auth()->guard('company')->check()) {
            auth()->guard('company')->user()
                ->unreadNotifications
                ->when($request->input('id'), function ($query) use ($request) {
                    return $query->where('id', $request->input('id'));
                })
                ->markAsRead();
        } else if (auth()->check()) {
            auth()->user()
                ->unreadNotifications
                ->when($request->input('id'), function ($query) use ($request) {
                    return $query->where('id', $request->input('id'));
                })
                ->markAsRead();
        }

        return response()->noContent();
    }
}
