<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
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
            $invoices = Invoice::all();
            $message = $invoices ? "Invoices found" : "Invoices not found";
            $status = 200;
            $response = [
                'data' => $invoices ?? '',
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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $invoice = Invoice::find($id);
            $message = $invoice ? "Invoice found" : "Invoice not found";
            $status = 200;
            $response = [
                'data' => $invoice ?? '',
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
            $invoice = Invoice::find($id);
            $message = $invoice ? "Invoice updated" : "Invoice cannot be updated";
            $status = $invoice ? 202 : 404;


            if ($invoice) {
                $invoice->update($request->only(['address', 'sale_id', 'phone_number', 'rfc', 'cartItems']));
            }

            $response = [
                'data' => $invoice ?? '',
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
            $invoice = Invoice::find($id);

            if ($invoice) {
                $invoice->delete($id);
            }
            $message = $invoice ? "Invoice destroyed" : "Invoice cannot be destroyed";
            $status = $invoice ? 202 : 404;
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
    public static function createPDF(Request $request)
    {
        $request->validate([
            'sale_id' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'rfc' => 'required',
            'cartItems' => 'required',
        ]);

        $issuer = [
            'rfc' => "RFCEXAMPLE",
            'address' => 'Address Example',
            'email' => 'email@example.com',
            'phone_number' => '+123 123 123 1234'
        ];

        $receiver = [
            'invoice_id' => $request->sale_id,
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

        $fileName = 'invoices/' . $request->sale_id . '.pdf';
        Storage::put($fileName, $pdf->output());
    }


    public static function createXML(Request $request)
    {
        $request->validate([
            'sale_id' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'rfc' => 'required',
            'cartItems' => 'required',
        ]);

        $issuer = [
            'rfc' => "RFCEXAMPLE",
            'address' => 'Address Example',
            'email' => 'email@example.com',
            'phone_number' => '+123 123 123 1234'
        ];

        $receiver = [
            'invoice_id' => $request->sale_id,
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

        $xmlContent = InvoiceController::generateXml([
            'issuer' => $issuer,
            'receiver' => $receiver,
            'cartItems' => $cartItems,
            'total' => $total,
            'subtotal' => $subtotal,
            'iva' => $iva
        ]);

        $fileName = 'invoices/' . $request->sale_id . '.xml';
        Storage::put($fileName, $xmlContent);
    }

    public function downloadPdf(Request $request)
    {
        return response()->download(storage_path('app/private/invoices/' . $request->sale_id . ".pdf"));
    }

    public function downloadXml(Request $request)
    {
        return response()->download(storage_path('app/private/invoices/' . $request->sale_id . ".xml"));
    }

    private static function generateXml($data)
    {
        $dom = new \DOMDocument('1.0', 'UTF-8');
        $dom->formatOutput = true;

        $root = $dom->createElement('Invoice');
        $dom->appendChild($root);

        $issuerXml = $dom->createElement('Issuer');
        $root->appendChild($issuerXml);

        foreach ($data['issuer'] as $key => $value) {
            $issuerXml->appendChild($dom->createElement(ucfirst($key), htmlspecialchars($value)));
        }

        $receiverXml = $dom->createElement('Receiver');
        $root->appendChild($receiverXml);

        foreach ($data['receiver'] as $key => $value) {
            $receiverXml->appendChild($dom->createElement(ucfirst($key), htmlspecialchars($value)));
        }

        $cartItemsXml = $dom->createElement('CartItems');
        $root->appendChild($cartItemsXml);

        foreach ($data['cartItems'] as $item) {
            $itemXml = $dom->createElement('Item');
            $cartItemsXml->appendChild($itemXml);

            $itemXml->appendChild($dom->createElement('ProductName', htmlspecialchars($item['stock']['product']['name'])));
            $itemXml->appendChild($dom->createElement('Price', number_format($item['stock']['product']['price'], 2)));
            $itemXml->appendChild($dom->createElement('Quantity', $item['quantity']));
            $itemXml->appendChild($dom->createElement('Total', number_format($item['stock']['product']['price'] * $item['quantity'], 2)));
        }

        $totalsXml = $dom->createElement('Totals');
        $root->appendChild($totalsXml);

        $totalsXml->appendChild($dom->createElement('Subtotal', number_format($data['subtotal'], 2)));
        $totalsXml->appendChild($dom->createElement('IVA', number_format($data['iva'], 2)));
        $totalsXml->appendChild($dom->createElement('Total', number_format($data['total'], 2)));

        return $dom->saveXML();
    }

}
