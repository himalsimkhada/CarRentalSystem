<?php

namespace App\Http\Controllers;

use App\Events\CarReserved;
use App\Mail\BookingMail;
use App\Models\Booking;
use App\Models\BookingType;
use App\Models\Car;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class BookingController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromIndex(Request $request)
    {
        $userData = auth()->user();
        $id = auth()->user()->id;
        $check_exists = Booking::where('user_id', '=', $id)
            ->exists();
        $booking_ongoing = Booking::where('user_id', '=', $id)
            ->where('status', '=', 'ongoing')
            ->exists();

        $booking_type = $request->get('bookingtype');
        $booking_types = BookingType::where('name', '=', $booking_type)->first();

        $s_date = date_create($request->get('pickdate'));
        $d_date = date_create($request->get('dropdate'));

        $date_diff = date_diff($s_date, $d_date);

        $day = $date_diff->format('%a');

        $final_cost = $booking_types->cost * $day;

        $car_id = $request->get('car-id');

        $company_id = Car::where('id', $car_id)->first()->company_id;

        $company = Company::with('user')->where('id', $company_id)->first();

        if (!$check_exists) {
            $change_availability = [
                'availability' => 0
            ];
            Car::where('id', '=', $request->get('car-id'))->update($change_availability);

            $values = [
                'booking_date' => date('Y-m-d H:i:s'),
                'date' => $request->get('pickdate'),
                'return_date' => $request->get('dropdate'),
                'status' => 'ongoing',
                'final_cost' => $final_cost,
                'payment' => 0,
                'booking_type_id' => $booking_types->id,
                'car_id' => $request->get('car-id'),
                'user_id' => auth()->user()->id,
                'location_id' => 1
            ];
            Booking::insert($values);

            Mail::to(auth()->user()->email)->send(new BookingMail($values));

            event(new CarReserved($userData, $company, $car_id));

            return redirect()->route('user.reservation')->with('alert', 'Successfully booked.');
        } elseif ($check_exists) {
            if (!$booking_ongoing) {
                $change_availability = [
                    'availability' => 0
                ];
                Car::where('id', '=', $request->get('car-id'))->update($change_availability);

                $values = [
                    'booking_date' => date('Y-m-d H:i:s'),
                    'date' => $request->get('pickdate'),
                    'return_date' => $request->get('dropdate'),
                    'status' => 'ongoing',
                    'final_cost' => $final_cost,
                    'payment' => 0,
                    'booking_type_id' => $booking_types->id,
                    'car_id' => $request->get('car-id'),
                    'user_id' => auth()->user()->id,
                    'location_id' => 1
                ];
                Booking::insert($values);

                Mail::to(auth()->user()->email)->send(new BookingMail($values));

                event(new CarReserved($userData, $company, $car_id));

                return redirect()->route('user.reservation')->with('alert', 'Successfully booked.');
            } else {
                return redirect()->back()->with('alert', 'Booking already exists from the user.');
            }
        } else {
            return redirect()->back()->with('alert', 'Error. Please try again.');
        }
    }

    public function storeFromList(Request $request)
    {
        $userData = auth()->user();

        $id = auth()->user()->id;

        $check_exists = Booking::where('user_id', '=', $id)
            ->exists();
        $booking_ongoing = Booking::where('user_id', '=', $id)
            ->where('status', '=', 'ongoing')
            ->exists();

        $booking_type = $request->get('bookingtype');
        $booking_get = BookingType::where('name', '=', $booking_type)->first();

        $s_date = date_create($request->get('date'));
        $d_date = date_create($request->get('return_date'));

        $date_diff = date_diff($s_date, $d_date);

        $day = $date_diff->format('%a');

        $final_cost = $booking_get->cost * $day;

        $car_id = $request->get('car-id');

        $company_id = Car::where('id', '=', $car_id)->first()->company_id;

        $company = Company::where('id', $company_id)->first();

        if (!$check_exists) {
            $change_availability = [
                'availability' => 0
            ];
            Car::where('id', '=', $request->input('car_id'))->update($change_availability);

            $values = [
                'booking_date' => date('Y-m-d H:i:s'),
                'date' => $request->input('date'),
                'return_date' => $request->input('return_date'),
                'status' => 'ongoing',
                'final_cost' => $final_cost,
                'payment' => 0,
                'booking_type_id' => $booking_get->id,
                'car_id' => $request->input('car_id'),
                'user_id' => auth()->user()->id,
                'location_id' => 1
            ];
            Booking::insert($values);

            Mail::to(auth()->user()->email)->send(new BookingMail($values));

            event(new CarReserved($userData, $company, $car_id));

            return redirect()->route('user.reservation')->with('alert', 'Successfully booked.');
        } elseif ($check_exists) {
            if (!$booking_ongoing) {
                $change_availability = [
                    'availability' => 0
                ];
                Car::where('id', '=', $request->input('car_id'))->update($change_availability);

                $values = [
                    'booking_date' => date('Y-m-d H:i:s'),
                    'date' => $request->input('date'),
                    'return_date' => $request->input('return_date'),
                    'status' => 'ongoing',
                    'final_cost' => $final_cost,
                    'payment' => 0,
                    'booking_type_id' => $booking_get->id,
                    'car_id' => $request->input('car_id'),
                    'user_id' => auth()->user()->id,
                    'location_id' => 1
                ];
                Booking::insert($values);

                Mail::to(auth()->user()->email)->send(new BookingMail($values));

                event(new CarReserved($userData, $company, $car_id));

                return redirect()->route('user.reservation')->with('alert', 'Successfully booked.');
            } else {
                return redirect()->back()->with('alert', 'Booking already exists from the user.');
            }
        } else {
            return redirect()->back()->with('alert', 'Error. Please try again.');
        }
    }

    public static function paidVal()
    {
        $id = auth()->user()->id;
        $values = [
            'payment' => 1
        ];
        Booking::where('user_id', '=', $id)->update($values);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking, $id)
    {
        $car_id = $booking->where('id', '=', $id)->first();

        $change_availability = [
            'availability' => 1
        ];

        Car::where('id', '=', $car_id->car_id)->update($change_availability);

        $booking->where('id', '=', $id)->delete();

        return redirect()->back()->with('alert', 'Reservation cancelled successfully.');
    }
}
