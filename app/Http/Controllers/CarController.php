<?php

namespace App\Http\Controllers;

use App\DataTables\CarsDataTable;
use App\Models\BookingType;
use App\Models\Car;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
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

    public function create()
    {
        $car = new Car();
        $car->load('bookingType');
        $types = BookingType::all();

        return view('car.create-edit', ['car' => $car, 'types' => $types]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        if ($request->input('availability') == null) {
            $availability = 0;
        } else {
            $availability = 1;
        }

        try {
            $validatedData = $request->validate([
                'model' => 'required|string',
                'model_year' => 'required',
                'brand' => 'required|string',
                'color' => 'required|string',
                'plate_number' => 'required|string|unique:cars',
                'primary_image' => 'required|image',
                'booking_type_id' => 'required',
            ]);

            $getImage = $request->file('primary_image');
            $extension = $getImage->extension();
            $img = Image::make($getImage)->fit(300);
            $filename = $request->input('plate_number') . '-' . $request->input('model') . '_' . time() . '.' . $extension;
            $path = 'images/car/images/' . $filename;
            $img->save(public_path($path));

            $company_id = auth()->guard('company')->user()->id;

            $values = [
                'model' => $request->input('model'),
                'description' => $request->input('description'),
                'model_year' => $request->input('model_year'),
                'brand' => $request->input('brand'),
                'color' => $request->input('color'),
                'plate_number' => $request->input('plate_number'),
                'availability' => $availability,
                'primary_image' => $path,
                'company_id' => $company_id,
                'booking_type_id' => $request->input('booking_type_id'),
            ];

            DB::beginTransaction();

            Car::insert($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'New car added successfully.']);
        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while adding a new car: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while adding a new car: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while adding a new car. Please try again later.']);
        }
    }

    public function edit($id)
    {
        $id = Crypt::decrypt($id);
        $car = Car::with('bookingType')->where('id', '=', $id)->first();
        $types = BookingType::all();

        return view('car.create-edit', ['car' => $car, 'types' => $types]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request): RedirectResponse
    {
        $id = Crypt::decrypt($request->input('id'));
        $company_id = auth()->guard('company')->user()->id;

        $availability = $request->input('availability') === null ? 0 : 1;

        $getImg = $request->file('primary_image');

        try {
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
                $filename = $request->input('plate_number') . '-' . $request->input('model') . '_' . time() . '.' . $extension;
                $path = 'images/car/images/' . $filename;
                $img->save(public_path($path));

                $values['primary_image'] = $path;
            }

            DB::beginTransaction();

            Car::where('id', $id)->update($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'Car successfully edited.']);
        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while editing the car: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while editing the car: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while editing the car. Please try again later.']);
        }
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
        return response()->json($response);
    }
}
