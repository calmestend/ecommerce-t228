<?php

namespace App\Http\Controllers;

use App\Models\SaleStock;
use Exception;
use Illuminate\Http\Request;

class SaleStockController extends Controller
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
            $saleStocks = SaleStock::all();
            $message = $saleStocks ? "Sale Stock found" : "Sale Stock not found";
            $status = 200;
            $response = [
                'data' => $saleStocks ?? '',
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
                'stock_id' => 'required',
                'quantity' => 'required',
            ]);
            $saleStock = SaleStock::create(['name' => $request->name]);
            $message = $saleStock ? "Sale Stock created" : "Sale Stock cannot be created";
            $status = 201;
            $response = [
                'data' => $saleStock ?? '',
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
            $saleStock = SaleStock::find($id);
            $message = $saleStock ? "Sale Stock found" : "Sale Stock not found";
            $status = 200;
            $response = [
                'data' => $saleStock ?? '',
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
            $saleStock = SaleStock::find($id);
            $message = $saleStock ? "Sale Stock updated" : "Sale Stock cannot be updated";
            $status = $saleStock ? 202 : 404;


            if ($saleStock) {
                $saleStock->update($request->only([
                    'sale_id',
                    'stock_id',
                    'quantity',
                ]));
            }

            $response = [
                'data' => $saleStock ?? '',
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
            $saleStock = SaleStock::find($id);

            if ($saleStock) {
                $saleStock->delete($id);
            }
            $message = $saleStock ? "Sale Stock destroyed" : "Sale Stock cannot be destroyed";
            $status = $saleStock ? 202 : 404;
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
