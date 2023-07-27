<?php

namespace App\Http\Controllers;

use App\DataTables\LocationsDataTable;
use App\Models\Location;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LocationsDataTable $dataTable) {
        return $dataTable->render('location.index');
    }

    public function create()
    {
        $location = new Location();

        return view('location.create-edit', compact('location'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Location $location)
    {
        $company_id = auth()->guard('company')->user()->id;

        $validatedData = $request->validate([
            'name' => 'required|string|unique:locations',
        ]);

        $values = [
            'name' => $request->input('name'),
            'company_id' => $company_id
        ];
        $location->insert($values);

        return redirect()->back()->with(['type' => 'success', 'message' => 'New location added successfully.']);
    }

    public function edit($id)
    {
        $location = Location::where('id', $id)->first();

        return view('location.create-edit', compact('location'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Location $location)
    {
        $id = Crypt::decrypt($request->input('id'));
        $validatedData = $request->validate([
            'name' => 'required|string||' . Rule::unique('locations')->ignore($id),
        ]);
        $values = [
            'name' => $request->input('name')
        ];
        $location->where('id', $id)->update($values);

        return redirect()->back()->with(['type' => 'success', 'message' => 'Location edited successfully.']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Location  $location
     * @return \Illuminate\Http\Response
     */
    public function destroy(Location $location, $id)
    {
        $response = $location->where('id', '=', $id)->delete();

        return response()->json($response);
    }
}
