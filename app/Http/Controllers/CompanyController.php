<?php

namespace App\Http\Controllers;

use App\DataTables\CompaniesDataTable;
use App\Models\Company;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Intervention\Image\Facades\Image;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CompaniesDataTable $dataTable)
    {
        return $dataTable->render('company.index');
    }
    public function dashboard()
    {
        $today = Carbon::today()->startOfDay();
        $company = auth()->guard('company')->user();
        $count_cars = $company->cars->count();
        $count_reservations = $company->bookings->count();
        $count_today = $company->bookings->where('booking_date',  '>=', $today)->count();
        $count_users = User::select('*')
            ->join('bookings', 'bookings.user_id', '=', 'users.id')
            ->join('cars', 'cars.id', '=', 'bookings.car_id')
            ->join('companies', 'companies.id', '=', 'cars.company_id')
            ->where('companies.id', '=', $company->id)
            ->distinct('users.id')
            ->count();

        return view('company.dashboard', ['count_cars' => $count_cars, 'count_users' => $count_users, 'count_reservations' => $count_reservations, 'count_today' => $count_today]);
    }

    public function create()
    {
        $company = new Company();

        return view('company.create-edit', compact('company'));
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
                'name' => 'required|string|unique:companies',
                'contact' => 'required|string',
                'address' => 'required|string',
                'registration_number' => 'required|string|unique:companies',
                'email' => 'required|string|unique:companies',
            ]);

            $values = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'address' => $request->input('address'),
                'contact' => $request->input('contact'),
                'registration_number' => $request->input('registration_number'),
                'email' => $request->input('email'),
            ];

            DB::beginTransaction();

            User::where('id', '=', $request->input('owner_id'))->update(['user_type' => 2]);

            Company::insert($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'Company added successfully.']);
        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while adding the company: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while adding the company: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while adding the company. Please try again later.']);
        }
    }

    public function edit($id)
    {
        $company = Company::where('id', Crypt::decrypt($id))->first();

        return view('company.create-edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CarCompany  $carCompany
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request): RedirectResponse
    {
        $detail = Company::where('id', Crypt::decrypt(request()->get('id')))->first();

        try {
            $validatedData = $request->validate([
                'name' => 'required|string|' . Rule::unique('companies')->ignore($detail->id),
                'contact' => 'required|string',
                'address' => 'required|string',
                'registration_number' => 'required|string|' . Rule::unique('companies')->ignore($detail->id),
            ]);

            $getImg = $request->file('logo');

            $values = [
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'address' => $request->input('address'),
                'contact' => $request->input('contact'),
                'registration_number' => $request->input('registration_number'),
            ];

            if ($getImg) {
                $extension = $getImg->extension();
                $img = Image::make($getImg)->fit(250);
                $filename = $detail->name . '_' . $detail->registration_number . '.' . $extension;
                $path = 'images/company/profile_images/' . $filename;
                $img->save(public_path($path));

                $values['logo'] = $path;
            }

            DB::beginTransaction();
            Company::where('id', $detail->id)->update($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'Company successfully edited']);
        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while editing the company: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while editing the company: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while editing the company. Please try again later.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CarCompany  $carCompany
     * @return \Illuminate\Http\Response
     */
    public function destroy(Company $carCompany, $id)
    {
        $response = $carCompany->where('id', $id)->delete();
        // return redirect()->back()->with('alert', 'Company successfully deleted!');
        return response()->json($response);
    }
}
