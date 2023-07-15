<?php

namespace App\Http\Controllers;

use App\Events\BookingPaid;
use App\Mail\CompanyPaymentRecieveMail;
use App\Mail\UserPaymentMail;
use App\Models\Booking;
use App\Models\Car;
use App\Models\CarCompany;
use App\Models\Invoice;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PaymentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $userDetails = auth()->user();

        $booking_id = $request->get('booking_id');

        $car_id = $request->get('car_id');

        $company_id = Car::where('id', '=', $car_id)->first()->company_id;

        $company_detail = CarCompany::where('id', '=', $company_id)->first();
        $company_owner_detail = User::where('id', $company_detail->owner_id)->first();

        $values = [
            'paypal_payer_id' => $request->input('paypal_payer_id'),
            'transaction_id' => $request->input('paypal_id'),
            'paypal_email_address' => $request->input('paypal_email_address'),
            'create_time' => $request->input('create_time'),
            'update_time' => $request->input('update_time'),
            'paypal_payer_name' => $request->input('paypal_payer_name'),
            'amount' => $request->input('amount'),
            'address' => $request->input('address'),
            'booking_id' => $booking_id
        ];

        Invoice::insert($values);

        $booking_val = [
            'payment' => 1
        ];
        Booking::where('id', '=', $booking_id)->update($booking_val);

        event(new BookingPaid($userDetails, $company_owner_detail, $car_id));

        Mail::to(auth()->user()->email)->send(new UserPaymentMail($values));

        Mail::to($company_detail->email)->send(new CompanyPaymentRecieveMail($values, $company_detail));

        return redirect()->route('user.reservation')->with('alert', 'Payment completed and transaction is saved.');
    }
}
