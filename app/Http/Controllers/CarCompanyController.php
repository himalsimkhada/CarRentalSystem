<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Car;
use App\Models\CarCompany;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class CarCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $owner_id = auth()->user()->id;
        $company_id = CarCompany::where('owner_id', '=', $owner_id)->first()->id;

        $count_cars = Car::with('company')->where('company_id', '=', $company_id)->count();

        $count_users = User::select('*')
            ->join('bookings', 'bookings.user_id', '=', 'users.id')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->where('companies.id', '=', $company_id)
            ->count();

        $count_reservations = Booking::select('*')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->where('companies.id', '=', $company_id)
            ->count();

        $count_today = Booking::select('*')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->where('companies.id', '=', $company_id)
            ->whereDate('booking_date', '=', date('Y-m-d'))
            ->count();

        return view('/company/dashboard', ['count_cars' => $count_cars, 'count_users' => $count_users, 'count_reservations' => $count_reservations, 'count_today' => $count_today]);
    }

    public function cars()
    {
        $owner_id = Auth::id();

        $company_id = CarCompany::where('owner_id', '=', $owner_id)->first()->id;

        $lists = Car::with('type')->where('company_id', '=', $company_id)->get();

        return view('/company/car', ['car_lists' => $lists]);
    }

    public function reservations()
    {
        $owner_id = Auth::user()->id;
        $company_id = CarCompany::where('owner_id', '=', $owner_id)->first()->id;

        $srtPaid = User::select('users.id AS user_id', 'users.username', 'users.email', 'cars.id AS car_id', 'bookings.date AS date', 'cars.model', 'bookings.return_date', 'booking_types.name AS type_name', 'bookings.id AS booking_id', 'bookings.payment')
            ->join('bookings', 'bookings.user_id', '=', 'users.id')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->join('booking_types', 'booking_types.id', '=', 'bookings.booking_type_id')
            ->where('companies.id', '=', $company_id)
            ->orderBy('bookings.payment', 'DESC')
            ->get();

        $srtUnpaid = User::select('users.id AS user_id', 'users.username', 'users.email', 'cars.id AS car_id', 'bookings.date AS date', 'cars.model', 'bookings.return_date', 'booking_types.name AS type_name', 'bookings.id AS booking_id', 'bookings.payment')
            ->join('bookings', 'bookings.user_id', '=', 'users.id')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->join('booking_types', 'booking_types.id', '=', 'bookings.booking_type_id')
            ->where('companies.id', '=', $company_id)
            ->orderBy('bookings.payment', 'ASC')
            ->get();

        $reservations = User::select('users.id AS user_id', 'users.username', 'users.email', 'cars.id AS car_id', 'bookings.date AS date', 'cars.model', 'bookings.return_date', 'booking_types.name AS type_name', 'bookings.id AS booking_id', 'bookings.payment')
            ->join('bookings', 'bookings.user_id', '=', 'users.id')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->join('booking_types', 'booking_types.id', '=', 'bookings.booking_type_id')
            ->where('companies.id', '=', $company_id)
            ->get();

        return view('/company/reservation', ['reservations' => $reservations, 'srtPaid' => $srtPaid, 'srtUnpaid' => $srtUnpaid]);
    }

    public function reservation_details(Request $request)
    {
        $reservation_id = $request->get('reservation-id');

        $owner_id = Auth::user()->id;
        $company_id = CarCompany::where('owner_id', '=', $owner_id)->first()->id;

        $reservation_details = User::select('users.id AS user_id', 'users.username', 'users.firstname', 'users.lastname', 'users.email', 'cars.id AS car_id', 'bookings.date', 'cars.model', 'bookings.return_date', 'booking_types.name AS type_name', 'bookings.id AS booking_id', 'bookings.location_id', 'cars.plate_number', 'users.address AS user_address', 'users.contact AS user_contact', 'bookings.status AS booking_status', 'booking_types.people_no', 'cars.color', 'cars.model_year', 'cars.brand', 'bookings.payment')
            ->join('bookings', 'bookings.user_id', '=', 'users.id')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->join('booking_types', 'booking_types.id', '=', 'bookings.booking_type_id')
            ->where('companies.id', '=', $company_id)
            ->where('bookings.id', '=', $reservation_id)
            ->get();

        return view('/company/reservation-detail', ['reservation_details' => $reservation_details]);
    }

    public function editCompanyProfile()
    {
        $owner_id = auth()->user()->id;

        $company_details = CarCompany::with('user')->where('owner_id', '=', $owner_id)->get();

        return view('/company/edit-company', ['details' => $company_details]);
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
            'name' => 'required|string|unique:companies',
            'contact' => 'required|string',
            'address' => 'required|string',
            'registration_number' => 'required|string|unique:companies',
            'email' => 'required|string|unique:companies',
        ]);
        $values = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'contact' => $request->input('contact'),
            'registration_number' => $request->input('registration_number'),
            'email' => $request->input('email'),
            'logo' => 'null',
            'owner_id' => $request->input('owner_id')
        ];

        User::where('id', '=', $request->input('owner_id'))->update(['user_type' => 2]);

        CarCompany::insert($values);

        return redirect()->back()->with('alert', 'Company successfully added!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarCompany  $carCompany
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $owner_id = auth()->user()->id;
        $detail = CarCompany::where('owner_id', '=', $owner_id)->first();

        $validatedData = $request->validate([
            'name' => 'required|string|' . Rule::unique('companies')->ignore($detail->id),
            'contact' => 'required|string',
            'address' => 'required|string',
            // 'registration_number' => 'required|string|' . Rule::unique('companies')->ignore($detail->id),
            'logo' => 'required|image',
        ]);

        $getImg = $request->file('logo');
        $extension = $getImg->extension();
        $img = Image::make($getImg)->fit(250);
        $path = public_path('images\company\profile_images');
        $filename = $detail->name . '_' . '.' . $extension;
        $img->save($path . '/' . $filename);

        $values = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'contact' => $request->input('contact'),
            'registration_number' => $request->input('registration_number'),
            'logo' => $filename
        ];

        CarCompany::where('id', '=', $detail->id)->update($values);

        return redirect()->back()->with('alert', 'Company successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarCompany  $carCompany
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarCompany $carCompany, $id)
    {
        $carCompany->where('id', '=', $id)->delete();

        return redirect()->back()->with('alert', 'Company successfully deleted!');
    }
}
