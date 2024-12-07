<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PayPalController extends Controller
{
    /**
     * Render the paypal payment
     */
    public function payment(Request $request)
    {
        $request->validate(['total' => 'required']);
        $total = $request->input('total');

        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('shopping_cart'),
            ],
            "purchase_units" => [
                0 => [
                "amount" => [
                    "currency_code" => "MXN",
                    "value" => $total
                    ]
                ]
            ]
        ]);

        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $links) {
                if ($links['rel'] == 'approve') {
                    return redirect()->away($links['href']);
                }
            }

            return redirect()
                ->route('paypal.cancel')
                ->with('error', 'Something went wrong.');
        } else {
            return redirect()
                ->route('shopping_cart')
                ->with('error', $response['message'] ?? 'Something went wrong.');
        }

    }

    /**
     * Payment Canceled
     */
    public function cancel()
    {
        redirect()->route('shopping_cart');
    }

    /**
     *  Payment finished successfully
     */
    public function success(Request $request)
    {
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);

        if (!isset($response['status'])) {
            abort(404);
        }

        if ($response['status'] == 'COMPLETED') {
            return CheckoutController::success();
        } else {
            return redirect()->route('shopping_cart');
        }
    }
}
