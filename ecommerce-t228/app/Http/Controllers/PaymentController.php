<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Exception;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    private $headers = [
    "Access-Control-Allow-Origin" => "*",
    "Content-type" => "application/json",
    ];

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $payments = Payment::all();
            $message = $payments ? "Payments found" : "Payments not found";
            $status = 200;
            $response = [
                'data' => $payments ?? '',
                'message' => $message,
                'status' => $status,
            ];
            return response()->json(compact('response'))->withHeaders($this->headers);
        } catch (Exception $error) {
            $response = array(
                'message' => 'Something went wrong',
                'status' => 500,
                'error' => $error
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            $request->validate([
                'sale_id' => 'required',
                'amount' => 'required'
            ]);

            $payment = Payment::create([
                'sale_id' => $request->sale_id,
                'amount' => $request->amount
            ]);

            $message = $payment ? "Payments created" : "Payments cannot be created";
            $status = 201;
            $response = [
                'data' => $payment ?? '',
                'message' => $message,
                'status' => $status,
            ];
            return response()->json(compact('response'))->withHeaders($this->headers);
        } catch (Exception $error) {
            $response = array(
                'message' => 'Something went wrong',
                'status' => 500,
                'error' => $error
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $payment = Payment::find($id);
            $message = $payment ? "Payment found" : "Payment not found";
            $status = 200;
            $response = [
                'data' => $payment ?? '',
                'message' => $message,
                'status' => $status,
            ];
            return response()->json(compact('response'))->withHeaders($this->headers);
        } catch (Exception $error) {
            $response = array(
                'message' => 'Something went wrong',
                'status' => 500,
                'error' => $error
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            $payment = Payment::find($id);
            $message = $payment ? "Payment updated" : "Payment cannot be updated";
            $status = $payment ? 202 : 404;


            if ($payment) {
                $payment->update($request->only(['sale_id', 'amount']));
            }

            $response = [
                'data' => $payment ?? '',
                'message' => $message,
                'status' => $status,
            ];
            return response()->json(compact('response'))->withHeaders($this->headers);
        } catch (Exception $error) {
            $response = array(
                'message' => 'Something went wrong',
                'status' => 500,
                'error' => $error
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $payment = Payment::find($id);

            if ($payment) {
                $payment->delete($id);
            }
            $message = $payment ? "Payment destroyed" : "Payment cannot be destroyed";
            $status = $payment ? 202 : 404;
            $response = [
                'message' => $message,
                'status' => $status,
            ];
            return response()->json(compact('response'))->withHeaders($this->headers);
        } catch (Exception $error) {
            $response = array(
                'message' => 'Something went wrong',
                'status' => 500,
                'error' => $error
            );
        }
    }
}
