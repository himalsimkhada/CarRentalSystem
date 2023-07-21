<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminController extends Controller
{
    public function index()
    {
        $count_users = User::where('user_type', '=', 3)->count();
        $count_companies = Company::all()->count();
        $count_cars = Car::all()->count();
        $count_reservations = Booking::all()->count();

        $count_today = Booking::whereDate('booking_date', '=', date('Y-m-d'))->count();

        return view('/admin/dashboard', ['count_cars' => $count_cars, 'count_companies' => $count_companies, 'count_users' => $count_users, 'count_reservations' => $count_reservations, 'count_today' => $count_today]);
    }

    public function reservations()
    {
        // $owner_id = Auth::user()->id;
        // $company_id = Company::where('owner_id', '=', $owner_id)->first()->id;

        $reservations = User::select('users.id AS user_id', 'users.username', 'users.email', 'cars.id AS car_id', 'bookings.date', 'cars.model', 'bookings.return_date', 'booking_types.name AS type_name', 'bookings.id AS booking_id')
            ->join('bookings', 'bookings.user_id', '=', 'users.id')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->join('booking_types', 'booking_types.id', '=', 'bookings.booking_type_id')
        // ->where('car_companies.id', '=', $company_id)
        // ->where('status', '=', 0)
            ->get();

        return view('/admin/reservation', ['reservations' => $reservations]);
    }

    public function addAdmin(Request $request)
    {
        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'contact' => 'required|string',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'email' => 'required|email|unique:users',
            'username' => 'required|string|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $values = [
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'contact' => $request->input('contact'),
            'address' => $request->input('address'),
            'date_of_birth' => $request->input('date_of_birth'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => $request->input('password'),
            'user_type' => 1,
        ];

        User::insert($values);

        return redirect()->back()->with('alert', 'Admin user added!');
    }

    public function editAdmin(Request $request)
    {
        $id = $request->get('id');

        $user = User::where('id', '=', $id)->first();

        $validatedData = $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'contact' => 'required|string',
            'address' => 'required|string',
            'date_of_birth' => 'required|date',
            'email' => 'required|email|' . Rule::unique('users')->ignore($user->id),
            'username' => 'required|string|' . Rule::unique('users')->ignore($user->id),
            'password' => 'required|string|min:8',
        ]);

        $values = [
            'firstname' => $request->input('firstname'),
            'lastname' => $request->input('lastname'),
            'contact' => $request->input('contact'),
            'address' => $request->input('address'),
            'date_of_birth' => $request->input('date_of_birth'),
            'email' => $request->input('email'),
            'username' => $request->input('username'),
            'password' => Hash::make($request->input('password')),
        ];

        User::where('id', '=', $id)->update($values);

        return redirect()->back()->with('alert', 'Admin user edited!');
    }
}
