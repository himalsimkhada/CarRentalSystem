<?php

namespace App\Http\Controllers;

use App\DataTables\PartnerReqsDataTable;
use App\Models\PartnerReq;
use App\Models\User;
use Illuminate\Http\Request;

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

        // Company::insert($values);
        // }

        return redirect()->route('admin.index.partner-req')->with('alert', 'Request approved.');
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
    public function store(Request $request)
    {
        $user = auth()->user();

        $validatedData = $request->validate([
            'company_name' => 'required|string|unique:companies,name',
            'company_contact' => 'required|string',
            'company_address' => 'required|string',
            'registration_number' => 'required|string|unique:companies,registration_number',
            'company_email' => 'required|string|unique:companies,email',
        ]);

        $values = [
            'company_name' => $request->input('company_name'),
            'company_description' => $request->input('company_description'),
            'company_address' => $request->input('company_address'),
            'company_contact' => $request->input('company_contact'),
            'registration_number' => $request->input('registration_number'),
            'company_email' => $request->input('company_email'),
            'status' => 'waiting',
        ];

        PartnerReq::insert($values);

        return redirect()->back()->with('alert', 'Thank you. We will get to you soon.');
    }
}
