<?php

namespace App\Http\Controllers;

use App\Models\BookingType;
use App\Models\Car;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PagesController extends Controller
{
    public function index()
    {
        $data = BookingType::all();
        $locations = Location::all();

        $deals = Car::select('cars.*')
            ->join('booking_types', 'booking_types.id', '=', 'cars.booking_type_id')
            ->orderBy('booking_types.cost', 'ASC')
            ->limit(4)
            ->get();

        $popular = Car::select('cars.*', DB::raw('COUNT(bookings.car_id) AS count'))
            ->join('bookings', 'bookings.car_id', '=', 'cars.id')
            ->groupBy('car_id')
            ->orderBy('count', 'DESC')
            ->get();

        return view('index', ['data' => $data, 'locations' => $locations, 'deals' => $deals, 'pop_deals' => $popular]);
    }

    public function listing(Request $request)
    {
        $booking_type = BookingType::all();
        $locations = Location::all();

        $location = $request->input('picklocation');
        $pick_date = $request->input('picking-date');
        $drop_date = $request->input('dropping-date');
        $type = $request->input('booking-type');

        $display_list = Car::select('cars.*', 'booking_types.people_no')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->join('locations', 'locations.company_id', '=', 'companies.id')
            ->join('booking_types', 'booking_types.id', '=', 'cars.booking_type_id')
            ->where('locations.location', '=', $location)
            ->where('booking_types.name', '=', $type)
            ->where('cars.availability', '=', 1)
            ->get();

        return view('listing', ['list' => $display_list, 'pickdate' => $pick_date, 'dropdate' => $drop_date, 'bookingtype' => $type, 'booking_type' => $booking_type, 'location' => $location, 'locations' => $locations]);
    }

    public function car_list(Request $request)
    {
        $display_all = Car::with('image', 'type')->where('availability', '=', 1)->get();

        $srtpricedesc = BookingType::select('*')
            ->join('cars', 'cars.booking_type_id', '=', 'booking_types.id')
            ->orderBy('booking_types.cost', 'DESC')
            ->get();

        $srtpriceasc = BookingType::select('*')
            ->join('cars', 'cars.booking_type_id', '=', 'booking_types.id')
            ->orderBy('booking_types.cost', 'ASC')
            ->get();

        $location = $request->get('search-location');

        $searchLoc = BookingType::select('*')
            ->join('cars', 'cars.booking_type_id', '=', 'booking_types.id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->join('locations', 'locations.company_id', 'companies.id')
            ->where('locations.location', 'LIKE', '%' . $location . '%')
            ->get();

        return view('/car-listing', ['lists' => $display_all, 'pricedesc' => $srtpricedesc, 'priceasc' => $srtpriceasc, 'location' => $searchLoc]);
    }
}
