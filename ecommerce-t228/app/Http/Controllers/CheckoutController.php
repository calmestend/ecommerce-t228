<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Sale;
use App\Models\SaleStock;
use App\Models\Stock;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public static function success()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        $cartItems = [];
        $saleIsCreated = false;
        $saleId = 0;

        foreach ($cart as $stockId => $item) {
            $stock = Stock::findOrFail($stockId);
            $total += $stock->product->price * $item['quantity'];

            $cartItems[] = [
                'stock' => $stock,
                'quantity' => $item['quantity'],
            ];

            if (!$saleIsCreated) {
                $sale = Sale::create([ 'user_id' => Auth::user()->id ]);
                $saleId = $sale->id;
                $saleIsCreated = true;
            }

            $stock->quantity -= $item['quantity'];
            $stock->save();
            SaleStock::create([
                'sale_id' => $saleId,
                'stock_id' => $stock->id,
                'quantity' => $item['quantity']
            ]);
        }

        Payment::create([
            'sale_id' => $saleId,
            'amount' => $total
        ]);

        session()->forget('cart');
        return view('client.checkout', compact(['cartItems', 'saleId']));
    }

}