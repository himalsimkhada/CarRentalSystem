<?php

namespace App\Http\Controllers;

use App\Models\BookingType;
use Illuminate\Http\Request;

class BookingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = BookingType::all();

        return view('/admin/booking-type', ['types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:booking_types',
            'luggage_no' => 'required|integer',
            'people_no' => 'required|integer',
            'cost' => 'required',
            'late_fee' => 'required',
        ]);

        $values = [
            'name' => $request->input('name'),
            'luggage_no' => $request->input('luggage_no'),
            'people_no' => $request->input('people_no'),
            'cost' => $request->input('cost'),
            'late_fee' => $request->input('late_fee')
        ];

        BookingType::insert($values);

        return redirect()->back()->with('alert', 'Booking type added successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookingType  $bookingType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingType $bookingType)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'luggage_no' => 'required|integer',
            'people_no' => 'required|integer',
            'cost' => 'required',
            'late_fee' => 'required',
        ]);

        $values = [
            'name' => $request->input('name'),
            'luggage_no' => $request->input('luggage_no'),
            'people_no' => $request->input('people_no'),
            'cost' => $request->input('cost'),
            'late_fee' => $request->input('late_fee')
        ];

        BookingType::where('id', '=', $request->get('id'))->update($values);

        return redirect()->back()->with('alert', 'Booking type successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingType  $bookingType
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingType $bookingType, $id)
    {
        $bookingType->where('id', '=', $id)->delete();

        return redirect()->back()->with('alert', 'Booking type successfully deleted.');
    }
}
