<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use App\Models\WishListProducts;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListController extends Controller
{
    private $headers = [
    "Access-Control-Allow-Origin" => "*",
    "Content-type" => "application/json",
    ];

    /**
     * Display a listing of the resource.
     */
    public function indexView()
    {
        $wishListId = Auth::user()->wish_list->id;
        $wishList = WishList::findOrFail($wishListId);
        $wishListProducts = WishListProducts::where('wish_list_id', $wishList->id)->get();

        return view('client.wish_list', compact('wishListProducts'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $wishLists = WishList::all();
            $message = $wishLists ? "Wish Lists found" : "Wish Lists not found";
            $status = 200;
            $response = [
                'data' => $wishLists ?? '',
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
            $wishList = WishList::create(['user_id' => $request->user_id]);
            $message = $wishList ? "Wish Lists created" : "Wish Lists cannot be created";
            $status = 201;
            $response = [
                'data' => $wishList ?? '',
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
            $wishList = WishList::find($id);
            $message = $wishList ? "Wish List found" : "Wish List not found";
            $status = 200;
            $response = [
                'data' => $wishList ?? '',
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
            $wishList = WishList::find($id);
            $message = $wishList ? "Wish List updated" : "Wish List cannot be updated";
            $status = $wishList ? 202 : 404;


            if ($wishList) {
                $wishList->update($request->only(['user_id']));
            }

            $response = [
                'data' => $wishList ?? '',
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
            $wishList = WishList::find($id);

            if ($wishList) {
                $wishList->delete($id);
            }
            $message = $wishList ? "Wish List destroyed" : "Wish List cannot be destroyed";
            $status = $wishList ? 202 : 404;
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
