<?php

namespace App\Http\Controllers;

use App\Events\PartnerRequest;
use App\Events\ReqApproved;
use App\Events\ReqDenied;
use App\Mail\PartnerCompany;
use App\Models\Company;
use App\Models\PartnerReq;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PartnerReqController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('user.request-partner');
    }

    public function adminReq()
    {
        // $getDetails = PartnerReq::all();
        $getDetails = PartnerReq::select('*', 'partner_reqs.id AS req_id')
            ->join('users', 'users.id', '=', 'partner_reqs.user_id')
            ->where('approved', '=', 'waiting')
            ->get();

        return view('admin.partner-requests', ['details' => $getDetails]);
    }

    public function approved(Request $request)
    {
        $application_id = $request['r_id'];

        $partner = PartnerReq::where('id', '=', $application_id)->first();

        $user = User::where('id', '=', $partner->user_id)->first();

        $details = PartnerReq::where('id', '=', $application_id)->get()->toArray();

        foreach ($details as $detail) {
            $values = [
                'name' => $detail['company_name'],
                'description' => $detail['company_description'],
                'address' => $detail['company_address'],
                'contact' => $detail['company_contact'],
                'registration_number' => $detail['company_reg'],
                'email' => $detail['company_email'],
                'owner_id' => $detail['user_id']
            ];

            $approve = [
                'approved' => 'approved',
            ];

            PartnerReq::where('id', '=', $application_id)->update($approve);

            event(new ReqApproved($user));

            Company::insert($values);
        }

        return redirect()->route('admin.requests')->with('alert', 'Request approved.');
    }

    public function denied(Request $request)
    {
        $application_id = $request['deny_id'];

        $partner_id = PartnerReq::where('id', '=', $application_id)->first();

        $user = User::where('id', '=', $partner_id->user_id)->first();

        PartnerReq::where('id', '=', $application_id)->update(['approved' => 'denied']);

        event(new ReqDenied($user));

        return redirect()->back()->with('alert', 'Request Denied');
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
            'company_reg' => 'required|string|unique:companies,registration_number',
            'company_email' => 'required|string|unique:companies,email',
        ]);

        $values = [
            'company_name' => $request->input('company_name'),
            'company_description' => $request->input('company_description'),
            'company_address' => $request->input('company_address'),
            'company_contact' => $request->input('company_contact'),
            'company_reg' => $request->input('company_reg'),
            'company_email' => $request->input('company_email'),
            'user_id' => auth()->user()->id,
            'approved' => 'waiting'
        ];

        PartnerReq::insert($values);

        Mail::to(auth()->user()->email)->send(new PartnerCompany($values));

        event(new PartnerRequest($user));

        return view('user.partner-req-message');
    }
}
