<?php

namespace App\Http\Controllers;

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
        $getImage = $request->file('image');
        $extension = $getImage->extension();
        $img = Image::make($getImage)->fit(150);
        $path = public_path('images\car\images');
        $filename = $request->input('plate_number') . '-' . $request->input('model') . '_' . time() . '.' . $extension;
        $img->save($path . '/' . $filename);

        $validatedData = $request->validate([
            'image' => 'required|image',
        ]);

        $values = [
            'image' => $filename,
            'car_id' => $request->get('id')
        ];

        CarImage::insert($values);

        return redirect()->back()->with('alert', 'New image added.');
    }
}
