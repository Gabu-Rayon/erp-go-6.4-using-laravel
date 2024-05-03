<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\ItemInformation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sales.index');
    }

    public function sendSalesTransactions()
    {
        return view('sales.saletransactions');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $items = ItemInformation::all()->pluck('itemNm', 'itemCd');
            return view('sales.create', compact('items'));
        } catch (\Exception $e) {
            \Log::info('Sales Create Render Error');
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
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
            $url = 'https://etims.your-apps.biz/api/AddSale';

            $response = Http::withHeaders([
                'key' => '123456'
                ])->post($url, $data);

            \Log::info('SALES API RESPONSE');
            \Log::info($response);

            Sales::create([
                'customerName' => $data['customerName'],
                'customerTin' => $data['customerTin'],
                'customerNo' => $data['customerNo'],
                'customerMobileNo' => $data['customerMobileNo'],
                'salesType' => $data['salesType'],
                'paymentType' => $data['paymentType'],
                'traderInvoiceNo' => $data['traderInvoiceNo'],
                'confirmDate' => $data['confirmDate'],
                'salesDate' => $data['salesDate'],
                'stockReleseDate' => $data['stockReleseDate'],
                'receiptPublishDate' => $data['receiptPublishDate'],
                'occurredDate' => $data['occurredDate'],
                'formDataObject' => $data['formDataObject'],
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
    public function show(Sales $sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sales $sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sales $sales)
    {
        //
    }
}
