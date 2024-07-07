<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInvoiceRequest;
use App\Http\Requests\UpdateInvoiceRequest;
use App\Models\Invoice;
use App\Utils\InvoiceTableFetcher;

class InvoiceController extends Controller
{

    public function table()
    {
        $f = new InvoiceTableFetcher();

        return response()->json([
            "table" => $f->get(request()->query())
        ]);

    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $list = Invoice::all();

        foreach ($list as $item)
            $item->products;

        return response($list);
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
    public function store(StoreInvoiceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->products;

        return response()->json(["invoice" => $invoice]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}
