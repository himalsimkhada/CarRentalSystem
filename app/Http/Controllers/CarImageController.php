<?php

namespace App\Http\Controllers;

use App\Models\Car;
use App\Models\CarImage;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class CarImageController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $car = Car::findOrFail($request->input('id'));
        $getImage = $request->file('image');
        $extension = $getImage->extension();
        $img = Image::make($getImage)->fit(150);
        $filename = $car->plate_number . '-' . $car->model . '_' . time() . '.' . $extension;
        $path = 'images/car/images/'.$filename;
        $img->save(public_path($path));

        $validatedData = $request->validate([
            'image' => 'required|image',
        ]);

        $values = [
            'image' => $path,
            'car_id' => $car->id,
        ];

        CarImage::insert($values);

        return redirect()->back()->with('alert', 'New image added.');
    }
}
