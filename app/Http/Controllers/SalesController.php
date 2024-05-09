<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use App\Models\SalesTypeCode;
use App\Models\PaymentTypeCodes;
use App\Models\InvoiceStatusCode;
use App\Models\Customer;
use App\Models\SalesItems;
use App\Models\ItemInformation;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\SalesCreditNoteItems;
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
     function customerNumber()
    {
        $latest = Customer::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->customer_id + 1;
    }
    
    public function create()
    {
        try {
            $items = ItemInformation::all()->pluck('itemNm', 'itemCd');
            $salesTypeCodes = SalesTypeCode::all()->pluck('saleTypeValue', 'saleTypeCode');
            $paymentTypeCodes = PaymentTypeCodes::all()->pluck('payment_type_code', 'code');
            $invoiceStatusCodes = InvoiceStatusCode::all()->pluck('invoiceStatusValue', 'invoiceStatusCode');
            $customers = Customer::all()->pluck('name', 'customer_id');
            return view('sales.create', compact(
                'items',
                'salesTypeCodes',
                'customers',
                'paymentTypeCodes',
                'invoiceStatusCodes'
            ));
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
            \Log::info('SALE REQ DATA');
            \Log::info($request->all());

            $data = $request->all();

            $itemsDataList = [];
            foreach ($data['items'] as $item) {
                \Log::info('SALE ITEM DATA');
                \Log::info($item);
                $itemExprDt = str_replace('-', '', $item['itemExprDate']);
                $itemExprDate = date('Ymd', strtotime($itemExprDt));

                $itemsDataList[] = [
                    "itemCode" => $item['itemCode'],
                    "itemClassCode" => $item['itemClassCode'],
                    "itemTypeCode" => $item['itemTypeCode'],
                    "itemName" => $item['itemName'],
                    "orgnNatCd" => $item['orgnNatCd'],
                    "taxTypeCode" => $item['taxTypeCode'],
                    "unitPrice" => $item['unitPrice'],
                    "isrcAplcbYn" => $item['isrcAplcbYn'],
                    "pkgUnitCode" => $item['pkgUnitCode'],
                    "pkgQuantity" => $item['pkgQuantity'],
                    "qtyUnitCd" => $item['qtyUnitCd'],
                    "quantity" => $item['quantity'],
                    "discountRate" => $item['discountRate'],
                    "discountAmt" => $item['discountAmt'],
                    "itemExprDate" => $itemExprDate,
                ];
            }

            \Log::info('ITEMS DATA LIST');
            \Log::info($itemsDataList);


            $url = 'https://etims.your-apps.biz/api/AddSale';

            $response = Http::withOptions(['verify' => false])->withHeaders([
                'key' => '123456'
                ])->post($url, [
                        "customerNo" => $data['customerNo'],
                        "customerTin" => $data['customerTin'],
                        "customerName" => $data['customerName'],
                        "customerMobileNo" => $data['customerMobileNo'],
                        "salesType" => $data['salesType'],
                        "paymentType" => $data['paymentType'],
                        "traderInvoiceNo" => $data['traderInvoiceNo'],
                        "confirmDate" => str_replace('-', '', $data['confirmDate']),
                        "salesDate" => str_replace('-', '', $data['salesDate']),
                        "stockReleseDate" => str_replace('-', '', $data['stockReleseDate']),
                        "receiptPublishDate" => str_replace('-', '', $data['receiptPublishDate']),
                        "occurredDate" => str_replace('-', '', $data['occurredDate']),
                        "invoiceStatusCode" => $data['invoiceStatusCode'],
                        "remark" => $data['remark'],
                        "isPurchaseAccept" => $data['isPurchaseAccept'],
                        "isStockIOUpdate" => $data['isStockIOUpdate'],
                        "mapping" => $data['mapping'],
                        "saleItemList" => $itemsDataList
                ]);

            \Log::info('SALES API RESPONSE');
            \Log::info($response);
            \Log::info('SALES API DATE STUFF');

            if ($response['statusCode'] == 400) {
                return redirect()->back()->with('error', 'Trader invoice number already exists');
            }

            $sale = Sales::create([
                'customerName' => $data['customerName'],
                'customerTin' => $data['customerTin'],
                'customerNo' => $data['customerNo'],
              'customer_id' => $this->customerNumber(),
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

            $saleItems = $data['items'];

            foreach ($itemsDataList as $saleItem) {
                SalesItems::create([
                    'sales_credit_note_id' => $sale->id,
                    'customer_id' => $this->customerNumber(),
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
            return redirect()->to('sales')->with('success', 'Added Sale Successfully');
        } catch (\Exception $e) {
            \Log::info('ADD SALE ERROR');
            \Log::info($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
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