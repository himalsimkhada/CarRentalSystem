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
        $path = public_path('images/car/images');
        $filename = $car->plate_number . '-' . $request->input('model') . '_' . time() . '.' . $extension;
        $img->save($path . '/' . $filename);

        $validatedData = $request->validate([
            'image' => 'required|image',
        ]);

        $values = [
            'image' => $filename,
            'car_id' => $car->id,
        ];

        CarImage::insert($values);

        return redirect()->back()->with('alert', 'New image added.');
    }
}
