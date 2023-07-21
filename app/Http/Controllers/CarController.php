<?php

namespace App\Http\Controllers;

use App\DataTables\CarsDataTable;
use App\Models\BookingType;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\Company;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Validation\Rule;
use Intervention\Image\Facades\Image;

class CarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CarsDataTable $dataTable)
    {
        return $dataTable->render('car.index');
    }

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

    public function create()
    {
        $car = new Car();
        $car->load('type');
        $types = BookingType::all();

        return view('car.create-edit', ['car' => $car, 'types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('availability') == null) {
            $availability = 0;
        } else {
            $availability = 1;
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
            'booking_type_id' => 'required',
        ]);
        $company_id = auth()->guard('company')->user()->id;

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
            'booking_type_id' => $request->input('booking_type_id'),
        ];

        Car::insert($values);

        return redirect()->back()->with('alert', 'Car successfully added.');
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $car = Car::with('type')->where('id', '=', $id)->first();
        $types = BookingType::all();

        return view('car.create-edit', ['car' => $car, 'types' => $types]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $id = Crypt::decrypt($request->input('id'));
        $company_id = auth()->guard('company')->user()->id;

        if ($request->input('availability') == null) {
            $availability = 0;
        } else {
            $availability = 1;
        }
        $getImg = $request->file('primary_image');

        $validatedData = $request->validate([
            'model' => 'required|string',
            'model_year' => 'required',
            'brand' => 'required|string',
            'color' => 'required|string',
            'plate_number' => 'required|string|' . Rule::unique('cars')->ignore($id),
            'booking_type_id' => 'required|' . Rule::unique('cars')->ignore($id),
        ]);

        $values = [
            'model' => $request->input('model'),
            'description' => $request->input('description'),
            'model_year' => $request->input('model_year'),
            'brand' => $request->input('brand'),
            'color' => $request->input('color'),
            'plate_number' => $request->input('plate_number'),
            'availability' => $availability,
            'company_id' => $company_id,
            'booking_type_id' => $request->input('booking_type_id'),
        ];

        if ($getImg) {
            $extension = $getImg->extension();
            $img = Image::make($getImg)->fit(250);
            $path = public_path('images/car/images');
            $filename = $request->input('plate_number') . '-' . $request->input('model') . '_' . time() . '.' . $extension;
            $img->save($path . '/' . $filename);

            $values = ['primary_image' => $filename];

            Car::where('id', '=', $id)->update($values);
        }

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
        $response = $car->where('id', $id)->delete();

        // return redirect()->back()->with('alert', 'Car successfully deleted.');
        return response()->json($response);
    }
}
