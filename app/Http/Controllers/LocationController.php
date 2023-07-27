<?php

namespace App\Http\Controllers;

use App\DataTables\LocationsDataTable;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class LocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LocationsDataTable $dataTable)
    {
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
    public function store(Request $request, Location $location): RedirectResponse
    {
        try {
            $company_id = auth()->guard('company')->user()->id;

            $validatedData = $request->validate([
                'name' => 'required|string|unique:locations',
            ]);

            DB::beginTransaction();

            $values = [
                'name' => $request->input('name'),
                'company_id' => $company_id,
            ];

            // Insert the data into the locations table
            $location->insert($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'New location added successfully.']);
        } catch (ValidationException $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while storing the location: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while storing the location: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while storing the location. Please try again later.']);
        }
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
    public function update(Request $request, Location $location): RedirectResponse
    {
        try {
            $id = Crypt::decrypt($request->input('id'));

            $validatedData = $request->validate([
                'name' => 'required|string|unique:locations,name,' . $id,
            ]);

            DB::beginTransaction();

            $values = [
                'name' => $request->input('name'),
            ];

            // Update the location record
            $location->where('id', $id)->update($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'Location edited successfully.']);
        } catch (ValidationException $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while updating the location: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while updating the location: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while updating the location. Please try again later.']);
        }
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
