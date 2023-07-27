<?php

namespace App\Http\Controllers;

use App\DataTables\ContactUsDataTable;
use App\Models\ContactUs;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;

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

    public function emailCustomer(Request $request, $id, $user_id): RedirectResponse
    {
        try {
            $email_message = $request->input('result');
            $user_detail = User::where('id', '=', $user_id)->first();

            Mail::raw($email_message, function ($message) use ($user_detail) {
                $message->to($user_detail->email, $user_detail->username);
                $message->subject('Emergency Vehicle Replacement');
                $message->priority(3);
            });

            DB::beginTransaction();

            $values = [
                'status' => 'Emailed',
            ];

            // Update the status of the ContactUs record
            ContactUs::where('id', '=', $id)->update($values);

            DB::commit();

            return redirect()->back()->with(['type' => 'success', 'message' => 'User emailed successfully.']);
        } catch (\Exception $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while emailing the user: $errorMessage");

            return redirect()->back()->with(['type' => 'error', 'message' => 'An error occurred while emailing the user. Please try again later.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
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
                throw new \Exception('Invalid type.');
            }

            DB::beginTransaction();

            $values = [
                'fullname' => $request->input('fullname'),
                'email' => $request->input('email'),
                'contact_num' => $request->input('contact_num'),
                'message' => $request->input('message'),
                'type' => $request->input('type'),
                'priority' => $priority,
                'user_id' => $request->get('id'),
            ];

            // Insert the data into the ContactUs table
            ContactUs::insert($values);

            DB::commit();

            return view('thank')->with(['type' => 'success', 'message' => 'Messaged successfully.']);
        } catch (ValidationException $e) {
            $errorMessage = $e->getMessage();
            Log::error("Validation error occurred while storing the contact message: $errorMessage");

            throw $e;
        } catch (\Throwable $e) {
            DB::rollback();

            $errorMessage = $e->getMessage();
            Log::error("Error occurred while storing the contact message: $errorMessage");

            return view('thank')->with(['type' => 'error', 'message' => 'An error occurred while storing the contact message. Please try again later.']);
        }
    }

}
