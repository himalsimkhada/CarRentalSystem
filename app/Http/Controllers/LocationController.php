<?php

namespace App\Http\Controllers;

use App\Models\CarCompany;
use App\Models\Location;
use Illuminate\Http\Request;

class LocationController extends Controller
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
        $locations = Location::where('company_id', '=', $company_id)->get();

        return view('/company/location', ['displays' => $locations]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Location $location)
    {
        $owner_id = auth()->user()->id;
        $company_id = CarCompany::where('owner_id', '=', $owner_id)->first()->id;

        $validatedData = $request->validate([
            'location' => 'required|string',
        ]);

        $values = [
            'location' => $request->input('location'),
            'company_id' => $company_id
        ];
        $location->insert($values);

        return redirect()->back()->with('alert', 'Added successfully');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location, $id)
    {
        $validatedData = $request->validate([
            'location' => 'required|string',
        ]);
        $values = [
            'location' => $request->input('location')
        ];
        $location->where('id', '=', $id)->update($values);

        return redirect()->back()->with('alert', 'Updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location, $id)
    {
        $location->where('id', '=', $id)->delete();

        return redirect()->back()->with('alert', 'Deleted successfully');
    }
}
