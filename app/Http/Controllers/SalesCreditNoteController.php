<?php

namespace App\Http\Controllers;

use App\Models\SalesCreditNote;
use App\Models\ItemInformation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SalesCreditNoteController extends Controller
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
        try {
            $items = ItemInformation::all()->pluck('itemNm', 'itemCd');
            return view('salescreditnote.create', compact('items'));
        } catch (\Exception $e) {
            \Log::info('CREATE VIEW ERROR');
            \lOG::info($e);
            redirect()->back()->with('error', 'Could Not Render Page');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('REQ DATA');
            \Log::info($request->all());

            $data = $request->all();
            $url = 'https://etims.your-apps.biz/api/AddSaleCreditNote';

            $response = Http::withHeaders([
                'key' => '123456'
                ])->post($url, $data);

            \Log::info('SALES API RESPONSE');
            \Log::info($response);

            SalesCreditNote::create([
                'orgInvoiceNo' => $data['orgInvoiceNo'],
                'customerName' => $data['customerName'],
                'customerTin' => $data['customerTin'],
                'creditNoteReason' => $data['creditNoteReason'],
                'creditNoteDate' => $data['creditNoteDate'],
                'salesType' => $data['salesType'],
                'paymentType' => $data['paymentType'],
                'traderInvoiceNo' => $data['traderInvoiceNo'],
                'confirmDate' => $data['confirmDate'],
                'salesDate' => $data['salesDate'],
                'stockReleseDate' => $data['stockReleseDate'],
                'receiptPublishDate' => $data['receiptPublishDate'],
                'occurredDate' => $data['occurredDate'],
                'invoiceStatusCode' => $data['invoiceStatusCode'],
                'isPurchaseAccept' => $data['isPurchaseAccept'],
                'isStockIOUpdate' => $data['isStockIOUpdate'],
                'mapping' => $data['mapping'],
                'remark' => $data['remark']
            ]);
            return response()->json([
                'status' => 'success',
                'message' => 'Sale Added Successfuly'
            ]);
        } catch (\Exception $e) {
            \Log::info('ADD SALE ERROR');
            \Log::info($e);
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(SalesCreditNote $salesCreditNote)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SalesCreditNote $salesCreditNote)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SalesCreditNote $salesCreditNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SalesCreditNote $salesCreditNote)
    {
        //
    }
}
