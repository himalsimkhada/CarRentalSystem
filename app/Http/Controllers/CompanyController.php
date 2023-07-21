<?php

namespace App\Http\Controllers;

use App\DataTables\CompaniesDataTable;
use App\Models\Booking;
use App\Models\Car;
use App\Models\Company;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CompaniesDataTable $dataTable)
    {
        return $dataTable->render('company.index');
    }
    public function dashboard()
    {
        // $company_id = Company::where('id', auth()->guard('company')->user()->id)->first()->id;
        $company_id = auth()->guard('company')->user()->id;

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

    public function reservations()
    {
        $company_id = auth()->guard('company')->user()->id;
        // $company_id = Company::where('d', auth()->guard('company')->user()->id)->first()->id;

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

        // $owner_id = auth()->guard('company')->user()->id;
        // $company_id = Company::where('owner_id', '=', $owner_id)->first()->id;
        $company_id = auth()->guard('company')->user()->id;

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

    public function create()
    {
        $company = new Company();

        return view('company.create-edit', compact('company'));
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
        ];

        User::where('id', '=', $request->input('owner_id'))->update(['user_type' => 2]);

        Company::insert($values);

        return redirect()->back()->with('alert', 'Company successfully added!');
    }

    public function edit($id)
    {
        $company = Company::with('user')->where('id', Crypt::decrypt($id))->first();

        return view('company.create-edit', compact('company'));
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
        $detail = Company::where('id', Crypt::decrypt(request()->get('id')))->first();

        $validatedData = $request->validate([
            'name' => 'required|string|' . Rule::unique('companies')->ignore($detail->id),
            'contact' => 'required|string',
            'address' => 'required|string',
            'registration_number' => 'required|string|' . Rule::unique('companies')->ignore($detail->id),
        ]);

        $getImg = $request->file('logo');

        $values = [
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'address' => $request->input('address'),
            'contact' => $request->input('contact'),
            'registration_number' => $request->input('registration_number'),
        ];

        if ($getImg) {
            $extension = $getImg->extension();
            $img = Image::make($getImg)->fit(250);
            $path = public_path('images/company/profile_images');
            $filename = $detail->name . '_' . $detail->registration_number . '.' . $extension;
            $img->save($path . '/' . $filename);

            $values = ['logo' => $filename];

            Company::where('id', $detail->id)->update($values);
        }

        Company::where('id', '=', $detail->id)->update($values);

        return redirect()->back()->with('alert', 'Company successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarCompany  $carCompany
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $carCompany, $id)
    {
        $response = $carCompany->where('id', $id)->delete();
        // return redirect()->back()->with('alert', 'Company successfully deleted!');
        return response()->json($response);
    }
}
