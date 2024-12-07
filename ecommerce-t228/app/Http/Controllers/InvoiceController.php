<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'sale_id' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'rfc' => 'required',
            'cartItems' => 'required',
        ]);

        $invoice = Invoice::create(['sale_id' => $request->sale_id]);

        $issuer = [
            'rfc' => "RFCEXAMPLE",
            'address' => 'Address Example',
            'email' => 'email@example.com',
            'phone_number' => '+123 123 123 1234'
        ];

        $receiver = [
            'invoice_id' => $invoice->id,
            'rfc' => $request->rfc,
            'address' => $request->address,
            'phone_number' => $request->phone_number,
            'email' => Auth::user()->email,
            'name' => Auth::user()->name,
            'date' => date("Y/m/d")
        ];

        $cartItems = json_decode($request->cartItems, true);

        $total = array_reduce($cartItems, function ($carry, $item) {
            return $carry + $item['stock']['product']['price'] * $item['quantity'];
        }, 0);

        $subtotal = $total / 1.16;
        $iva = $total - $subtotal;

        $pdf = Pdf::loadView('invoice', compact(['issuer', 'receiver', 'cartItems', 'total', 'subtotal', 'iva']));

        $fileName = 'invoices/' . $invoice->id . '.pdf';
        Storage::put($fileName, $pdf->output());

        return response()->download(storage_path('app/private/' . $fileName));
    }
}
