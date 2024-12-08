<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Exception;
use Illuminate\Http\Request;

class SaleController extends Controller
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
            $sales = Sale::all();
            $message = $sales ? "Sales found" : "Sales not found";
            $status = 200;
            $response = [
                'data' => $sales ?? '',
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
                'user_id' => 'required'
            ]);
            $sale = Sale::create(['user_id' => $request->name]);
            $message = $sale ? "Sales created" : "Sales cannot be created";
            $status = 201;
            $response = [
                'data' => $sale ?? '',
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
            $sale = Sale::find($id);
            $message = $sale ? "Sale found" : "Sale not found";
            $status = 200;
            $response = [
                'data' => $sale ?? '',
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
            $sale = Sale::find($id);
            $message = $sale ? "Sale updated" : "Sale cannot be updated";
            $status = $sale ? 202 : 404;


            if ($sale) {
                $sale->update($request->only(['user_id']));
            }

            $response = [
                'data' => $sale ?? '',
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
            $sale = Sale::find($id);

            if ($sale) {
                $sale->delete($id);
            }
            $message = $sale ? "Sale destroyed" : "Sale cannot be destroyed";
            $status = $sale ? 202 : 404;
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
