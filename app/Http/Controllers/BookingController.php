<?php

namespace App\Http\Controllers;

use App\DataTables\BookingsDataTable;
use App\Events\BookingEvent;
use App\Models\Booking;
use App\Models\BookingType;
use App\Models\Car;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{

    public function index(BookingsDataTable $dataTable)
    {
        return $dataTable->render('booking.index');
    }

    public function show($id)
    {
        $booking = Booking::with(['user', 'car', 'bookingType'])->where('id', $id)->first();

        return view('booking.show', ['booking' => $booking]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeFromIndex(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;

        $existingBooking = Booking::where('user_id', $userId)->exists();
        $ongoingBooking = Booking::where('user_id', $userId)->where('status', 'ongoing')->exists();

        $bookingType = BookingType::where('name', $request->input('bookingtype'))->firstOrFail();

        $startDate = date_create($request->input('pickdate'));
        $endDate = date_create($request->input('dropdate'));
        $daysDifference = date_diff($startDate, $endDate)->format('%a');
        $finalCost = $bookingType->cost * $daysDifference;

        $car = Car::findOrFail($request->input('car-id'));
        $company = $car->company;

        try {
            DB::beginTransaction();

            if (!$existingBooking || !$ongoingBooking) {
                $car->update(['availability' => 0]);
                $bookingType->update(['count_reservation' => ($bookingType->count_reservation + 1)]);

                $values = [
                    'booking_date' => now(),
                    'date' => $request->input('pickdate'),
                    'return_date' => $request->input('dropdate'),
                    'status' => 'ongoing',
                    'final_cost' => $finalCost,
                    'payment' => 0,
                    'booking_type_id' => $bookingType->id,
                    'car_id' => $request->input('car-id'),
                    'user_id' => $userId,
                    'location_id' => 1,
                ];
                Booking::insert($values);

                event(new BookingEvent($user, $company, $values));

                DB::commit();
                return redirect()->route('user.index.booking')->with(['type' => 'success', 'message' => 'Booking successful.']);
            } else {
                DB::rollBack();
                return redirect()->back()->with(['type' => 'error', 'message' => 'Booking already exists from the user.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['type' => 'error', 'message' => 'Error. Please try again.']);
        }
    }

    public function storeFromList(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;

        $existingBooking = Booking::where('user_id', $userId)->exists();
        $ongoingBooking = Booking::where('user_id', $userId)->where('status', 'ongoing')->exists();

        $bookingType = BookingType::where('name', $request->input('bookingtype'))->firstOrFail();

        $startDate = date_create($request->input('date'));
        $endDate = date_create($request->input('return_date'));
        $daysDifference = date_diff($startDate, $endDate)->format('%a');
        $finalCost = $bookingType->cost * $daysDifference;

        $carId = $request->input('car-id');
        $car = Car::findOrFail($carId);
        $company = $car->company;

        try {
            DB::beginTransaction();

            if (!$existingBooking || !$ongoingBooking) {
                $car->update(['availability' => 0]);
                $bookingType->update(['count_reservation' => ($bookingType->count_reservation + 1)]);

                $values = [
                    'booking_date' => now(),
                    'date' => $request->input('date'),
                    'return_date' => $request->input('return_date'),
                    'status' => 'ongoing',
                    'final_cost' => $finalCost,
                    'payment' => 0,
                    'booking_type_id' => $bookingType->id,
                    'car_id' => $carId,
                    'user_id' => $userId,
                    'location_id' => 1,
                ];
                Booking::insert($values);

                event(new BookingEvent($user, $company, $values));

                DB::commit();
                return redirect()->route('user.index.booking')->with(['type' => 'success', 'message' => 'Booking successful.']);
            } else {
                DB::rollBack();
                return redirect()->back()->with(['type' => 'error', 'message' => 'Booking already exists from the user.']);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['type' => 'error', 'message' => 'Error. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Booking  $booking
     * @return \Illuminate\Http\Response
     */
    public function destroy(Booking $booking, $id)
    {
        try {
            DB::beginTransaction();

            $bookingData = $booking->findOrFail($id);
            $response = $bookingData->delete();
            $bookingData->bookingType->update(['count_reservation' => ($bookingData->bookingType->count_reservation - 1)]);
            $bookingData->car->update(['availability' => 1]);

            DB::commit();
            return response()->json($response);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['type' => 'error', 'message' => 'Error canceling reservation. Please try again.']);
        }
    }
}
