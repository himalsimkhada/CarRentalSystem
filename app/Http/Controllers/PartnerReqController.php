<?php

namespace App\Http\Controllers;

use App\DataTables\PartnerReqsDataTable;
use App\Models\PartnerReq;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class PartnerReqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PartnerReqsDataTable $dataTable)
    {
        return $dataTable->render('partner-req.index');
    }

    public function create()
    {
        return view('partner-req.create');
    }

    public function approve(Request $request, $id)
    {
        // $partner = PartnerReq::where('id', '=', $application_id)->first();

        // $user = User::where('id', '=', $partner->user_id)->first();

        // $details = PartnerReq::where('id', '=', $application_id)->get()->toArray();

        // foreach ($details as $detail) {
        //     $values = [
        //         'name' => $detail['company_name'],
        //         'description' => $detail['company_description'],
        //         'address' => $detail['company_address'],
        //         'contact' => $detail['company_contact'],
        //         'registration_number' => $detail['registration_number'],
        //         'email' => $detail['company_email'],
        //     ];

        $approve = [
            'status' => 'approved',
        ];

        PartnerReq::where('id', $id)->update($approve);

        return redirect()->back()->with(['type' => 'success', 'message' => 'Request Approved.']);
    }

    public function deny(Request $request, $id)
    {
        $response = PartnerReq::where('id', '=', $id)->update(['status' => 'denied']);

        return response()->json($response);
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
            $user = auth()->user();

            $validatedData = $request->validate([
                'company_name' => 'required|string|unique:companies,name',
                'company_contact' => 'required|string',
                'company_address' => 'required|string',
                'registration_number' => 'required|string|unique:companies,registration_number',
                'company_email' => 'required|string|unique:companies,email',
            ]);

            DB::beginTransaction();

            $values = [
                'company_name' => $request->input('company_name'),
                'company_description' => $request->input('company_description'),
                'company_address' => $request->input('company_address'),
                'company_contact' => $request->input('company_contact'),
                'registration_number' => $request->input('registration_number'),
                'company_email' => $request->input('company_email'),
                'status' => 'waiting',
            ];

            // Insert the data into the PartnerReq table
            PartnerReq::insert($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'Thank you. We will get to you soon.']);
        } catch (ValidationException $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while storing the partner request: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while storing the partner request: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while processing the partner request. Please try again later.']);
        }
    }

}
