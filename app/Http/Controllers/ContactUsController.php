<?php

namespace App\Http\Controllers;

use App\DataTables\ContactUsDataTable;
use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ContactUsDataTable $dataTable)
    {
        return $dataTable->render('contact-us.index');
    }

    public function create()
    {
        $user = auth()->user();

        return view('contact-us.create', ['user' => $user]);
    }


    public function emailCustomer(Request $request, $id, $user_id)
    {
        $email_message = $request->input('result');
        $user_detail = User::where('id', '=', $user_id)->first();

        Mail::raw($email_message, function ($message) use ($user_detail) {
            $message->to($user_detail->email, $user_detail->username);
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
