<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Company;
use App\Models\User;

class AdminController extends Controller
{
    public function dashboard()
    {
        $count_users = User::where('user_type', '=', 3)->count();
        $count_companies = Company::all()->count();
        $count_cars = Car::all()->count();
        $count_reservations = Booking::all()->count();
        $count_today = Booking::whereDate('booking_date', '=', date('Y-m-d'))->count();

        return view('admin.dashboard', ['count_cars' => $count_cars, 'count_companies' => $count_companies, 'count_users' => $count_users, 'count_reservations' => $count_reservations, 'count_today' => $count_today]);
    }
}
