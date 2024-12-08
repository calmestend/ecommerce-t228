<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Exception;
use Illuminate\Http\Request;

class ProductController extends Controller
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
            $products = Product::all();
            $message = $products ? "Products found" : "Categories not found";
            $status = 200;
            $response = [
                'data' => $products ?? '',
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
                'name' => 'required',
                'description' => 'required',
                'thumbnail' => 'required',
                'cost' => 'required',
                'price' => 'required',
                'category_id' => 'required',
            ]);
            $product = Product::create([
                'name' => $request->name,
                'description' => $request->description,
                'thumbnail' => $request->thumbnail,
                'cost' => $request->cost,
                'price' => $request->price,
                'category_id' => $request->category_id,
            ]);
            $message = $product ? "Products created" : "Categories cannot be created";
            $status = 201;
            $response = [
                'data' => $product ?? '',
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
            $product = Product::find($id);
            $message = $product ? "Product found" : "Product not found";
            $status = 200;
            $response = [
                'data' => $product ?? '',
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
            $product = Product::find($id);
            $message = $product ? "Product updated" : "Product cannot be updated";
            $status = $product ? 202 : 404;


            if ($product) {
                $product->update($request->only([
                    'name',
                    'description',
                    'thumbnail',
                    'cost',
                    'price',
                    'category_id',
                ]));
            }

            $response = [
                'data' => $product ?? '',
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
            $product = Product::find($id);

            if ($product) {
                $product->delete($id);
            }
            $message = $product ? "Product destroyed" : "Product cannot be destroyed";
            $status = $product ? 202 : 404;
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
