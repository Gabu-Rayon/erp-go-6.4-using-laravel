<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\SalesItems;
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
        $sales = Sales::all();
        return view('sales.index', compact('sales'));
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
                'invoiceStatusCode' => $data['invoiceStatusCode'],
                'isPurchaseAccept' => $data['isPurchaseAccept'],
                'isStockIOUpdate' => $data['isStockIOUpdate'],
                'mapping' => $data['mapping'],
                'remark' => $data['remark']
            ]);

            $saleItems = $data['saleItemList'];

            foreach ($saleItems as $saleItem) {
                SalesCreditNoteItems::create([
                    'sales_credit_note_id' => $salesCreditNote->id,
                    'itemCode' => $saleItem['itemCode'],
                    'itemClassCode' => $saleItem['itemClassCode'],
                    'itemTypeCode' => $saleItem['itemTypeCode'],
                    'itemName' => $saleItem['itemName'],
                    'orgnNatCd' => $saleItem['orgnNatCd'],
                    'taxTypeCode' => $saleItem['taxTypeCode'],
                    'unitPrice' => $saleItem['unitPrice'],
                    'isrcAplcbYn' => $saleItem['isrcAplcbYn'],
                    'pkgUnitCode' => $saleItem['pkgUnitCode'],
                    'pkgQuantity' => $saleItem['pkgQuantity'],
                    'qtyUnitCd' => $saleItem['qtyUnitCd'],
                    'quantity' => $saleItem['quantity'],
                    'discountRate' => $saleItem['discountRate'],
                    'discountAmt' => $saleItem['discountAmt'],
                    'itemExprDate' => $saleItem['itemExprDate'],
                ]);
            }
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
    public function show(Sales $sale)
    {
        $items = SalesItems::where('sales_id', 4)->get();
        return view('sales.show', compact('sale', 'items'));
    }

    public function print(Sales $sale)
    {
        try {
            return redirect()->back()->with('success', 'Successfully Printed');
        } catch (\Exception $e) {
            \Log::info('PRINTING ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancel(Sales $sale)
    {
        try {
            return redirect()->back()->with('success', 'Successfully Cancelled');
        } catch (\Exception $e) {
            \Log::info('CANCELLING ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function creditNote(Sales $sale)
    {
        try {
            return view('sales.creditnote');
        } catch (\Exception $e) {
            \Log::info('CANCELLING ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sales $sale)
    {
        return view('sales.edit', compact('sale'));
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
