<?php

namespace App\Http\Controllers;

use App\Models\WishListProducts;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListProductController extends Controller
{
    private $headers = [
    "Access-Control-Allow-Origin" => "*",
    "Content-type" => "application/json",
    ];

    public function storeView(Request $request)
    {
        $request->validate([
            'product_id' => 'required',
            'wish_list_id' => 'required'
        ]);

        $existingWishList = WishListProducts::where('product_id', $request->product_id)
            ->where('wish_list_id', Auth::user()->wish_list->id)
            ->first();

        if ($existingWishList) {
            return redirect()->route('wish_list');
        }

        WishListProducts::create([
            'product_id' => $request->product_id,
            'wish_list_id' => $request->wish_list_id
        ]);

        return redirect()->route('wish_list')->with("message", "Agregado a favoritos");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroyView(string $id)
    {
        $wishListProduct = WishListProducts::findOrFail($id);
        $wishListProduct->delete();
        return redirect()->back()->with("message", "Producto eliminado");
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $wishListProducts = WishListProducts::all();
            $message = $wishListProducts ? "Wish List Products found" : "Wish List Products not found";
            $status = 200;
            $response = [
                'data' => $wishListProducts ?? '',
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
                'name' => 'required'
            ]);
            $wishListProduct = WishListProducts::create([
                'product_id' => $request->product_id,
                'wish_list_id' => $request->wish_list_id
            ]);
            $message = $wishListProduct ? "Wish List Products created" : "WishListProducts cannot be created";
            $status = 201;
            $response = [
                'data' => $wishListProduct ?? '',
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
            $wishListProduct = WishListProducts::find($id);
            $message = $wishListProduct ? "WishListProduct found" : "WishListProduct not found";
            $status = 200;
            $response = [
                'data' => $wishListProduct ?? '',
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
            $wishListProduct = WishListProducts::find($id);
            $message = $wishListProduct ? "Wish List Product updated" : "Wish List Product cannot be updated";
            $status = $wishListProduct ? 202 : 404;


            if ($wishListProduct) {
                $wishListProduct->update($request->only([
                    'product_id',
                    'wish_list_id',
                ]));
            }

            $response = [
                'data' => $wishListProduct ?? '',
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
            $wishListProduct = WishListProducts::find($id);

            if ($wishListProduct) {
                $wishListProduct->delete($id);
            }
            $message = $wishListProduct ? "Wish List Product destroyed" : "Wish List Product cannot be destroyed";
            $status = $wishListProduct ? 202 : 404;
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
