<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Invoice;

class InvoiceController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $data = $request
        $codeean13 = $request->codeean13;
        $invoice = $request->invoice;

        // \Log::debug('codeean13');
        // \Log::debug($codeean13);

        // \Log::debug('invoice');
        // \Log::debug($invoice);

        return response()->json(['result' => ['result' => Invoice::add($codeean13, $invoice)]]);
    }

    public function get(Request $request)
    {
        \Log::debug('invoice');
        \Log::debug($request->invoice);
        $result = Invoice::getByInvoice($request->invoice);
        \Log::debug('result');
        \Log::debug(json_encode($result));
        return response()->json($result);
    }

}
