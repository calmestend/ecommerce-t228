<?php

namespace App\Http\Controllers;

use App\Models\WishListProducts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishListProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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

        return redirect()->route('wish_list');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $wishListProduct = WishListProducts::findOrFail($id);
        $wishListProduct->delete();
        return redirect()->back();
    }
}
