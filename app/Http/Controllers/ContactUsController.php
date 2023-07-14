<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $detail = auth()->user();

        return view('contact-us', ['details' => $detail]);
    }

    public function adminSupport()
    {
        $getMessages = ContactUs::orderBy('priority', 'DESC')->get();

        return view('admin/message', ['messages' => $getMessages]);
    }

    public function companySupport()
    {
        $getMessages = ContactUs::where('type', '=', 'emr')->get();

        return view('company/message', ['messages' => $getMessages]);
    }

    public function emailCustomer(Request $request, $id, $user_id)
    {
        $email_message = $request->input('email_message');

        $this->user_detail = User::where('id', '=', $user_id)->first();

        Mail::raw($email_message, function ($message) {
            $message->to($this->user_detail->email, $this->user_detail->username);
            $message->subject('Emergency Vehicle Replacement');
            $message->priority(3);
        });

        $values = [
            'status' => 'Emailed'
        ];

        ContactUs::where('id', '=', $id)->update($values);

        return redirect()->back()->with('alert', 'User emailed successfully');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required',
            'email' => 'required',
            'contact_num' => 'required',
            'message' => 'required',
            'type' => 'required',
        ]);

        $priority = '';

        if ($request->input('type') == 'emr') {
            $priority = 'top';
        } elseif ($request->input('type') == 'req_car') {
            $priority = 'medium';
        } elseif ($request->input('type') == 'others') {
            $priority = 'low';
        } else {
            echo 'Error!';
        }

        $values = [
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'contact_num' => $request->input('contact_num'),
            'message' => $request->input('message'),
            'type' => $request->input('type'),
            'priority' => $priority,
            'user_id' => $request->get('id')
        ];

        ContactUs::insert($values);

        return view('thank')->with('alert', 'Contact posted successfully.');
    }
}
