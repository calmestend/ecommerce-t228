<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Exception;
use Illuminate\Http\Request;

class StockController extends Controller
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
            $stocks = Stock::all();
            $message = $stocks ? "Stocks found" : "Stocks not found";
            $status = 200;
            $response = [
                'data' => $stocks ?? '',
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
                'product_id' => 'required',
                'quantity' => 'required',
            ]);
            $stock = Stock::create(['name' => $request->name]);
            $message = $stock ? "Stocks created" : "Stocks cannot be created";
            $status = 201;
            $response = [
                'data' => $stock ?? '',
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
            $stock = Stock::find($id);
            $message = $stock ? "Stock found" : "Stock not found";
            $status = 200;
            $response = [
                'data' => $stock ?? '',
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
            $stock = Stock::find($id);
            $message = $stock ? "Stock updated" : "Stock cannot be updated";
            $status = $stock ? 202 : 404;


            if ($stock) {
                $stock->update($request->only([
                    'product_id',
                    'quantity'
                ]));
            }

            $response = [
                'data' => $stock ?? '',
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
            $stock = Stock::find($id);

            if ($stock) {
                $stock->delete($id);
            }
            $message = $stock ? "Stock destroyed" : "Stock cannot be destroyed";
            $status = $stock ? 202 : 404;
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
