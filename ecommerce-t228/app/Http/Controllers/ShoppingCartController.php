<?php

namespace App\Http\Controllers;

use App\Models\Stock;
use Illuminate\Http\Request;

class ShoppingCartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        $cartItems = [];

        foreach ($cart as $stockId => $item) {
            $stock = Stock::findOrFail($stockId);
            $subtotal = $stock->product->price * $item['quantity'];
            $cartItems[] = [
                'stock' => $stock,
                'quantity' => $item['quantity'],
                'subtotal' => $subtotal
                ];
            $total += $subtotal;
        }

        return view('client.shopping_cart', compact('total', 'cartItems'));
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
            'stock_id' => 'required'
        ]);

        $stock = Stock::findOrFail($request->stock_id);
        $cart = session()->get('cart', []);

        if (isset($cart[$stock->id])) {
            $request->validate(
                [
                'quantity' => [
                    'required',
                    'integer',
                    'max:' . ($stock->quantity - $cart[$stock->id]['quantity']),
                    'min:1',
                    ]
                ],
                [
                    'quantity.max' => 'The quantity cannot exceed the available stock',
                    'quantity.min' => 'The quantity cannot exceed the available stock'
                ]
            );

            $cart[$stock->id]['quantity'] += $request->quantity;
            session()->put('cart', $cart);
            return redirect()->route('shopping_cart');
        }

        $request->validate([
            'quantity' => [
                'required', 'integer', 'max:' . ($stock->quantity),
                'min: 1',
            ]
        ]);

        $cart[$stock->id] = ['quantity' => (int) $request->quantity];
        session()->put('cart', $cart);
        return redirect()->route('shopping_cart');
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
    public function destroy(string $stock_id)
    {
        $cart = session()->get('cart', []);
        if (isset($cart[$stock_id])) {
            unset($cart[$stock_id]);
            session()->put('cart', $cart);
        }
        return redirect()->back();
    }

    public function destroyAll()
    {
        //
    }
}
