<?php

namespace App\Http\Controllers;

use App\Models\BookingType;
use App\Models\Car;
use App\Models\CarCompany;
use App\Models\CarImage;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getDetail(Request $request)
    {
        $booking_type_list = BookingType::all();
        $locations = Location::all();

        $car_id = $request->get('car-id');
        $pick_date = $request->get('date');
        $drop_date = $request->get('return');
        $type = $request->get('type');

        $get_type = Car::with('type')->where('id', '=', $car_id)->first()->type->name;

        $cars = Car::with(['company', 'type', 'image'])->where('id', '=', $car_id)->get();

        $images = CarImage::with('car')->where('car_id', '=', $car_id)->get();

        return view('car-detail', ['car_detail' => $cars, 'pickdate' => $pick_date, 'dropdate' => $drop_date, 'bookingtype' => $type, 'types' => $booking_type_list, 'type_name' => $get_type, 'images' => $images, 'locations' => $locations]);
    }

    public function getCategory(Request $request, $id)
    {
        $getcars = Car::select('*')
            ->join('booking_types', 'booking_types.id', '=', 'cars.booking_type_id')
            ->where('booking_types.id', '=', $id)
            ->get();

        $srtpricedesc = BookingType::select('*')
            ->join('cars', 'cars.booking_type_id', '=', 'booking_types.id')
            ->where('booking_types.id', '=', $id)
            ->orderBy('booking_types.cost', 'DESC')
            ->get();

        $srtpriceasc = BookingType::select('*')
            ->join('cars', 'cars.booking_type_id', '=', 'booking_types.id')
            ->where('booking_types.id', '=', $id)
            ->orderBy('booking_types.cost', 'ASC')
            ->get();

        $location = $request->get('search-location');

        $searchLoc = Car::select('*')
            ->join('booking_types', 'booking_types.id', '=', 'cars.booking_type_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->join('locations', 'locations.company_id', 'companies.id')
            ->where('locations.location', 'LIKE', '%' . $location . '%')
            ->where('booking_types.id', '=', $id)
            ->get();


        return view('car-list-category', ['lists' => $getcars, 'pricedesc' => $srtpricedesc, 'priceasc' => $srtpriceasc, 'location' => $searchLoc]);
    }

    public function addview()
    {
        // $list = Car::with('type')->get();
        $list = BookingType::all();
        return view('company.add-car', ['lists' => $list]);
    }

    public function editCar(Request $request)
    {
        $get_id = $request->get('edit-id');

        $cars = Car::with('type')->where('id', '=', $get_id)->get();

        $displayCompany = Car::with('company')->get();
        $displayType = BookingType::all();

        return view('/edit/car', ['cars' => $cars, 'companies' => $displayCompany, 'types' => $displayType]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $owner_id = auth()->user()->id;
        $availability = '';

        if ($request->input('availability') == 'on') {
            $availability = 1;
        } else {
            $availability = 0;
        }

        $getImage = $request->file('primary_image');
        $extension = $getImage->extension();
        $img = Image::make($getImage)->fit(300);
        $path = public_path('images/car/images');
        $filename = $request->input('plate_number') . '-' . $request->input('model') . '_' . time() . '.' . $extension;
        $img->save($path . '/' . $filename);

        $validatedData = $request->validate([
            'model' => 'required|string',
            'model_year' => 'required',
            'brand' => 'required|string',
            'color' => 'required|string',
            'plate_number' => 'required|string|unique:cars',
            'primary_image' => 'required|image',
        ]);
        $company_id = CarCompany::where('owner_id', '=', $owner_id)->first()->id;

        $values = [
            'model' => $request->input('model'),
            'description' => $request->input('description'),
            'model_year' => $request->input('model_year'),
            'brand' => $request->input('brand'),
            'color' => $request->input('color'),
            'plate_number' => $request->input('plate_number'),
            'availability' => $availability,
            'primary_image' => $filename,
            'company_id' => $company_id,
            'booking_type_id' => $request->input('booking_type_id')
        ];

        Car::insert($values);

        return redirect()->back()->with('alert', 'Car successfully added.');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        $id = $request->get('car-id');
        $car = Car::where('id', '=', $id)->first();
        $owner_id = auth()->user()->id;
        $company_id = CarCompany::where('owner_id', '=', $owner_id)->first()->id;
        $availability = '';

        if ($request->input('availability') == 'on') {
            $availability = 1;
        } else {
            $availability = 0;
        }

        $getImage = $request->file('primary_image');
        $extension = $getImage->extension();
        $img = Image::make($getImage)->fit(250);
        $path = public_path('images/car/images');
        $filename = $request->input('plate_number') . '-' . $request->input('model') . '_' . time() . '.' . $extension;
        $img->save($path . '/' . $filename);

        $validatedData = $request->validate([
            'model' => 'required|string',
            'model_year' => 'required',
            'brand' => 'required|string',
            'color' => 'required|string',
            'plate_number' => 'required|string|' . Rule::unique('cars')->ignore($car->id),
            'primary_image' => 'required|image',
        ]);

        $values = [
            'model' => $request->input('model'),
            'description' => $request->input('description'),
            'model_year' => $request->input('model_year'),
            'brand' => $request->input('brand'),
            'color' => $request->input('color'),
            'plate_number' => $request->input('plate_number'),
            'availability' => $availability,
            'primary_image' => $filename,
            'company_id' => $company_id,
            'booking_type_id' => $request->input('bookingtype_id'),
        ];

        Car::where('id', '=', $id)->update($values);

        return redirect()->back()->with('alert', 'Car successfully edited.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car, $id)
    {
        $car->where('id', '=', $id)->delete();

        return redirect()->back()->with('alert', 'Car successfully deleted.');
    }
}
