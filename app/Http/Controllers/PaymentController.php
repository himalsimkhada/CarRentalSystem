<?php

namespace App\Http\Controllers;

use App\Events\PaymentEvent;
use App\Models\Booking;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaymentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function handlePayment(Request $request)
    {
        $id = $request->input('id');
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $booking = Booking::find($id);
        if (!$booking) {
            return redirect()->route('user.index.booking')->with('error', 'Invalid booking ID.');
        }
        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success.payment', ['id' => $booking->id]),
                "cancel_url" => route('paypal.cancel.payment'),
            ],
            "purchase_units" => [
                0 => [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $booking->final_cost,
                    ],
                ],
            ],
        ]);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }
            return redirect()
                ->route('paypal.cancel.payment')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('user.index.booking')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function paymentCancel()
    {
        return redirect()
            ->route('user.index.booking')
            ->with('error', 'You have canceled the transaction.');
    }

    public function paymentSuccess(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $provider->getAccessToken();
            $response = $provider->capturePaymentOrder($request['token']);
            if (isset($response['status']) && $response['status'] == 'COMPLETED') {
                $values = [
                    'paypal_payer_id' => $response['payer']['payer_id'],
                    'transaction_id' => $response['id'],
                    'paypal_email_address' => $response['payer']['email_address'],
                    'create_time' => $response['purchase_units'][0]['payments']['captures'][0]['create_time'],
                    'update_time' => $response['purchase_units'][0]['payments']['captures'][0]['update_time'],
                    'paypal_payer_name' => $response['payer']['name']['given_name'] . ' ' . $response['payer']['name']['surname'],
                    'amount' => $response['purchase_units'][0]['payments']['captures'][0]['amount']['value'],
                    'address' => $response['purchase_units'][0]['shipping']['address']['address_line_1'] ?? null,
                    'booking_id' => $id,
                ];
                $invoice = Invoice::create($values);

                $booking = Booking::find($id);
                $user = auth()->user();
                $car = $booking->car;
                $company = $car->company;

                if (!$booking) {
                    return redirect()->route('user.index.booking')->with('error', 'Invalid booking ID.');
                }

                $booking->payment = $id;
                $booking->save();

                event(new PaymentEvent($user, $company, $values));

                DB::commit();

                return redirect()->route('user.index.booking')->with('success', 'Transaction complete.');
            } else {
                DB::rollBack();
                return redirect()->route('user.index.booking')->with('error', $response['message'] ?? 'Something went wrong.');
            }
        } catch (\Exception $e) {
            var_dump($e);
            DB::rollBack();
            return redirect()->route('user.index.booking')->with('error', 'Error occurred. Payment reverted.');
        }
    }

}
