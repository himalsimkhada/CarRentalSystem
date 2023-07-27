<?php

namespace App\Http\Controllers;

use App\DataTables\BookingTypesDataTable;
use App\Models\BookingType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BookingTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(BookingTypesDataTable $dataTable)
    {
        return $dataTable->render('booking_type.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $type = new BookingType();
        return view('booking_type.create-edit', compact('type'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): RedirectResponse
    {
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|unique:booking_types',
                'luggage_no' => 'required|integer',
                'people_no' => 'required|integer',
                'cost' => 'required',
                'late_fee' => 'required',
            ]);

            $values = [
                'name' => $request->input('name'),
                'luggage_no' => $request->input('luggage_no'),
                'people_no' => $request->input('people_no'),
                'cost' => $request->input('cost'),
                'late_fee' => $request->input('late_fee'),
            ];

            DB::beginTransaction();

            BookingType::insert($values);

            DB::commit();

            return redirect()->route('admin.index.type')->with(['type' => 'success', 'message' => 'Booking type added successfully.']);
        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while storing booking type: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();
            $errorMessage = $e->getMessage();
            Log::error("Error occurred while storing booking type: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while adding the booking type. Please try again later.']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $type = BookingType::where('id', $id)->first();
        return view('booking_type.create-edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookingType  $bookingType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, BookingType $bookingType): RedirectResponse
    {
        $id = Crypt::decrypt($request->get('id'));

        try {
            $request->validate([
                'name' => 'required|unique:booking_types,name,' . $id,
                'luggage_no' => 'required|integer',
                'people_no' => 'required|integer',
                'cost' => 'required',
                'late_fee' => 'required|integer',
            ]);

            $values = [
                'name' => $request->input('name'),
                'luggage_no' => $request->input('luggage_no'),
                'people_no' => $request->input('people_no'),
                'cost' => $request->input('cost'),
                'late_fee' => $request->input('late_fee'),
            ];

            DB::beginTransaction();

            // Perform the data update
            $bookingType->where('id', $id)->update($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'Booking type edited successfully.']);
        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while updating booking type: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while updating booking type: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while editing the booking type. Please try again later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookingType  $bookingType
     * @return \Illuminate\Http\Response
     */
    public function destroy(BookingType $bookingType, $id)
    {
        $response = $bookingType->where('id', $id)->delete();
        return response()->json($response);
    }
}
