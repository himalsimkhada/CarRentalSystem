<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class CarImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        $car = Car::findOrFail($request->input('id'));
        $getImage = $request->file('image');
        $extension = $getImage->extension();
        $img = Image::make($getImage)->fit(150);
        $filename = $car->plate_number . '-' . $car->model . '_' . time() . '.' . $extension;
        $path = 'images/car/images/' . $filename;
        $img->save(public_path($path));

        try {
            $validatedData = $request->validate([
                'image' => 'required|image',
            ]);

            $values = [
                'image' => $path,
                'car_id' => $car->id,
            ];

            DB::beginTransaction();

            CarImage::insert($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'New car images have been added.']);
        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while adding new car images: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while adding new car images: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while adding new car images. Please try again later.']);
        }
    }
}
