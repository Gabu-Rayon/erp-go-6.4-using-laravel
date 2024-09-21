<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Plan;
use App\Models\User;
use App\Models\Details;
use App\Models\Invoice;
use App\Models\Utility;
use App\Models\Customer;
use App\Models\CreditNote;
use App\Models\BankAccount;
use App\Models\CustomField;
use App\Models\StockReport;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\SalesTypeCode;
use App\Exports\InvoiceExport;
use App\Models\InvoicePayment;
use App\Models\InvoiceProduct;
use App\Models\ProductService;
use App\Models\PaymentTypeCodes;
use App\Models\TransactionLines;
use App\Models\WarehouseProduct;
use App\Models\InvoiceStatusCode;
use App\Models\ItemClassification;
use Illuminate\Support\Facades\DB;
use App\Models\InvoiceBankTransfer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use App\Models\ProductServiceCategory;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            $customer = Customer::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $customer->prepend('Select Customer', '');
            $status = Invoice::$statues;
            \Log::info('CREATOR ID');
            \Log::info(\Auth::user()->creatorId());
            $query = Invoice::where('created_by', '=', \Auth::user()->creatorId());

            if (!empty($request->customer)) {
                $query->where('customer_id', '=', $request->customer);
            }
            if (count(explode('to', $request->issue_date)) > 1) {
                $date_range = explode(' to ', $request->issue_date);
                $query->whereBetween('issue_date', $date_range);
            } elseif (!empty($request->issue_date)) {
                $date_range = [$request->issue_date, $request->issue_date];
                $query->whereBetween('issue_date', $date_range);
            }
            if (!empty($request->status)) {
                $query->where('status', '=', $request->status);
            }
            $invoices = $query->get();

            return view('invoice.index', compact('invoices', 'customer', 'status'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function create($customerId)
    {
        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'invoice')->get();
            $invoice_number = \Auth::user()->invoiceNumberFormat($this->invoiceNumber());
            $customers = Customer::where('created_by', \Auth::user()->creatorId())->get()->pluck('customerName', 'id');
            $customers->prepend('Select Customer', '');
            $category = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->where('type', 'income')->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');
            $product_services = ProductService::all()->pluck('itemNm', 'itemCd');
            $product_services->prepend('--', '');
            $salesTypeCodes = SalesTypeCode::all()->pluck('saleTypeCode', 'code');
            $paymentTypeCodes = PaymentTypeCodes::all()->pluck('payment_type_code', 'code');
            $invoiceStatusCodes = InvoiceStatusCode::all()->pluck('invoiceStatusCode', 'code');
            $taxationtype = Details::where('cdCls', '04')->pluck('userDfnCd1', 'cd');

            return view(
                'invoice.create',
                compact(
                    'customers',
                    'invoice_number',
                    'product_services',
                    'category',
                    'customFields',
                    'customerId',
                    'salesTypeCodes',
                    'paymentTypeCodes',
                    'invoiceStatusCodes',
                    'taxationtype'
                )
            );
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function customer(Request $request)
    {
        $customer = Customer::where('id', '=', $request->id)->first();
        return view('invoice.customer_detail', compact('customer'));
    }

    public function product(Request $request)
    {
        $data['product'] = $product = ProductService::find($request->product_id);
        $data['unit'] = (!empty($product->unit)) ? $product->unit->name : '';
        $data['taxRate'] = $taxRate = !empty($product->tax_id) ? $product->taxRate($product->tax_id) : 0;
        $data['taxes'] = !empty($product->tax_id) ? $product->tax($product->tax_id) : 0;
        $salePrice = $product->sale_price;
        $quantity = 1;
        $taxPrice = ($taxRate / 100) * ($salePrice * $quantity);
        $data['totalAmount'] = ($salePrice * $quantity);

        return json_encode($data);
    }


    /****************************************************************
     * Post the data to api EnPoint
     * 
     ***************************************************************************/
    public function store(Request $request)
    {
        // Log the entire request data
        \Log::info('Invoice Data received From the Form:', $request->all());

        try {
            if (
                \Auth::user()->type == 'company'
                || \Auth::user()->type == 'accountant'
            ) {
                $validator = $this->validateInvoice($request);
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }
                $data = $request->all();
                $customer = Customer::find($data['customer_id']);
                \Log::info('Invoice Customer', ['customer' => $customer]);

                $apiRequestData = $this->prepareApiRequestData($data, $customer);
                \Log::info('Invoice Api Data to being Posted :', ['apiRequestData' => $apiRequestData]);

                $saleItemList = $this->prepareSaleItemList($data['items']);
                $apiRequestData['saleItemList'] = $saleItemList;
                \Log::info('Invoice  REQ DATA To Be Posted to the Api ', ['apiRequestData' => $apiRequestData]);

                //Send data to AddSale API
                $url = env('ETIMS_API_ENDPOINT') . 'AddSaleV2';
                $response = Http::withOptions(['verify' => false])
                    ->withHeaders(['key' => env('ETIMS_API_KEY')])
                    ->post($url, $apiRequestData);


                if ($response->failed()) {
                    if ($response->json('statusCode') == 400 && $response->json('message') == 'Trader invoice number is alrady exist') {
                        return redirect()->back()->with('error', 'Trader invoice number already exists.');
                    }
                    return redirect()->back()->with('error', 'Failed to post invoice data.');
                }

                // Log the response of the AddSale API call
                \Log::info('SALES Invoice API RESPONSE', ['response' => $response->json()]);
                \Log::info('API Response Status Code For Posting Invoice Data: ' . $response->status());
                \Log::info('API Request Invoice Being Posted: ' . json_encode($apiRequestData));
                \Log::info('API Response Body For Posting Invoice Data: ' . $response->body());

                if ($response['statusCode'] == 400) {
                    return redirect()->back()->with('error', $response['message']);
                }

                // Store API response data in local database
                $apiResponseData = $response->json();

                // Prepare data for ItemOpeningStock API
                // $openingItemsLists = $this->prepareOpeningItemsList($saleItemList);
                // $itemOpeningStockRequestData = [
                //     "openingItemsLists" => $openingItemsLists
                // ];

                // // Send data to ItemOpeningStock API
                // $url = 'https://etims.your-apps.biz/api/ItemOpeningStock';
                // $response = Http::withOptions(['verify' => false])
                //     ->withHeaders([
                //         'accept' => '*/*',
                //         'key' => '123456',
                //         'Content-Type' => 'application/json'
                //     ])
                //     ->post($url, $itemOpeningStockRequestData);

                // \Log::info('ITEM OPENING STOCK API RESPONSE', ['response' => $response->json()]);
                // \Log::info('API Response Status Code For Posting Opening Stock Data: ' . $response->status());
                // \Log::info('API Request Opening Stock Data Posted: ' . json_encode($itemOpeningStockRequestData));
                // \Log::info('API Response Body For Posting Opening Stock Data: ' . json_encode($response->body()));

                // if ($response->failed()) {
                //     return redirect()->back()->with('error', 'Failed to sync item opening stock');
                // }

                $totalAmount = $this->calculateTotalAmount($saleItemList);
                $inv = $this->createInvoice($data, $customer, $totalAmount, $apiResponseData);
                $this->createInvoiceProducts($saleItemList, $inv, $data['customer_id']);

                // Update the quantities in product_services and warehouse_products tables
                foreach ($saleItemList as $item) {
                    // Update quantity in product_services
                    $productService = ProductService::where('itemCd', $item['itemCode'])->first();
                    if ($productService && $productService->quantity !== null) {
                        $productService->quantity -= $item['quantity'];
                        $productService->save();
                    }
                    \Log::info('TOTAL AMT');
                    \Log::info($totalAmount);

                    // Update quantity in warehouse_products
                    $warehouseProduct = WarehouseProduct::where('product_id', $productService->id)->first();
                    if ($warehouseProduct && $warehouseProduct->quantity !== null) {
                        $warehouseProduct->quantity -= $item['quantity'];
                        // $warehouseProduct->pkgQuantity  -= $item['pkgQuantity'];
                        $warehouseProduct->save();
                    }
                }

                return redirect()->to('invoice')->with('success', 'Sale Created Successfully');
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } catch (\Exception $e) {
            \Log::error('ADD INV ERROR', ['exception' => $e]);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    private function validateInvoice($request)
    {
        return \Validator::make($request->all(), [
            'customer_id' => 'required',
            'issue_date' => 'required',
            'due_date' => 'required',
            'category_id' => 'required',
            'traderInvoiceNo' => 'required|max:50|min:1',
            'items' => 'required|array',
            'items.*.itemCode' => 'required',
            'items.*.quantity' => 'required',
            'items.*.pkgQauntity' => 'required',
            'items.*.price' => 'required',
            'items.*.discount' => 'required',
            'items.*.tax' => 'required',
            'items.*.taxAmount' => 'required',
            'items.*.description' => 'required',
            'items.*.itemExpDate' => 'nullable',
        ]);
    }

    private function prepareApiRequestData($data, $customer)
    {
        return [
            "customerNo" => $customer->customerNo,
            "customerTin" => $customer->customerTin,
            "customerName" => $customer->name,
            "customerMobileNo" => $customer->contact,
            "salesType" => $data['salesType'],
            "paymentType" => $data['paymentType'],
            "traderInvoiceNo" => $data['traderInvoiceNo'],
            "confirmDate" => $this->formatDateTime($data['confirmDate']),
            "salesDate" => $this->formatDate($data['salesDate']),
            "stockReleseDate" => $this->formatDateTime($data['stockReleseDate']),
            "receiptPublishDate" => $this->formatDateTime($data['receiptPublishDate']),
            "occurredDate" => $this->formatDate($data['occurredDate']),
            "invoiceStatusCode" => $data['invoiceStatusCode'],
            "remark" => $data['remark'],
            "isPurchaseAccept" => $data['isPurchaseAccept'],
            //is Stock IO Update should always be true 
            "isStockIOUpdate" => true,
            // "isStockIOUpdate" => $data['isStockIOUpdate'],

            //Mapping will be the id of the Invoice_id autogenrated by the system 
            // "mapping" => $data['mapping'],
            "mapping" => $this->invoiceNumber(),
            "saleItemList" => []
        ];
    }

    private function prepareSaleItemList($items)
    {
        $saleItemList = [];

        foreach ($items as $item) {
            \Log::info('MAVITU');
            \Log::info($item);
            $itemDetails = ProductService::where('itemCd', $item['itemCode'])->first();
            $itemExprDate = $this->formatDate($item['itemExprDate']);
            $saleItemList[] = [
                "itemCode" => $itemDetails->itemCd,
                "itemClassCode" => $itemDetails->itemClsCd,
                "itemTypeCode" => $itemDetails->itemTyCd,
                "itemName" => $itemDetails->itemNm,
                "orgnNatCd" => $itemDetails->orgnNatCd,
                "taxTypeCode" => $itemDetails->taxTyCd,
                "unitPrice" => $item['price'],
                "isrcAplcbYn" => $itemDetails->isrcAplcbYn,
                "pkgUnitCode" => $itemDetails->pkgUnitCd,
                "pkgQuantity" => $item['pkgQuantity'],
                "tax" => $item['tax'],
                "qtyUnitCd" => $itemDetails->qtyUnitCd,
                "quantity" => $item['quantity'],
                "discountRate" => $item['discount'],
                "discountAmt" => $item['discountAmount'],
                "itemExprDate" => $itemExprDate
            ];
        }

        return $saleItemList;
    }

    private function prepareOpeningItemsList($saleItemList)
    {
        $openingItemsLists = [];

        foreach ($saleItemList as $item) {
            $openingItemsLists[] = [
                "itemCode" => $item['itemCode'],
                "quantity" => $item['quantity'],
                "packageQuantity" => $item['pkgQuantity']
            ];
        }

        return $openingItemsLists;
    }

    private function formatDate($date)
    {
        return date('Ymd', strtotime(str_replace('-', '', $date)));
    }

    private function formatDateTime($dateTime)
    {
        return date('YmdHis', strtotime($dateTime));
    }

    private function calculateDiscountAmount($packageQuantity, $quantity, $unitPrice, $discountRate)
    {
        $totalItems = $packageQuantity * $quantity;
        $totalPriceBeforeDiscount = $totalItems * $unitPrice;
        return ($totalPriceBeforeDiscount * $discountRate) / 100;
    }

    private function calculateTotalAmount($saleItemList)
    {
        $totalAmount = 0;
        foreach ($saleItemList as $item) {
            $totalAmount += $item['pkgQuantity'] * $item['quantity'] * $item['unitPrice'];
        }
        return $totalAmount;
    }

    private function createInvoice($data, $customer, $totalAmount, $apiResponseData)
    {
        $salesDate = $this->formatDate($data['salesDate']);

        return Invoice::create([
            'invoice_id' => $this->invoiceNumber(),
            'customer_id' => $data['customer_id'],
            'issue_date' => $data['issue_date'],
            'due_date' => $data['due_date'],
            'send_date' => $data['send_date'],
            'category_id' => $data['category_id'],
            'ref_number' => $data['ref_number'],
            'status' => 0,
            'shipping_display' => null,
            'discount_apply' => null,
            'created_by' => \Auth::user()->creatorId(),
            'response_trderInvoiceNo' => $apiResponseData['data']['tranderInvoiceNo'],
            'response_invoiceNo' => $apiResponseData['data']['invoiceNo'],
            'orgInvoiceNo' => $data['orgInvoiceNo'] ?? null,
            'customerTin' => $customer->customerTin,
            'customerName' => $customer->name,
            'saleType' => $data['salesType'],
            'receptTypeCode' => null,
            'paymentTypeCode' => $data['paymentType'],
            'salesSttsCode' => $data['invoiceStatusCode'],
            'confirmDate' => $data['confirmDate'],
            'salesDate' => $salesDate,
            'stockReleaseDate' => $data['stockReleseDate'],
            'cancelReqDate' => null,
            'cancelDate' => null,
            'refundDate' => null,
            'refundReasonCd' => null,
            'totalItemCnt' => null,
            'taxableAmtA' => null,
            'taxableAmtB' => null,
            'taxableAmtC' => null,
            'taxableAmtD' => null,
            'taxRateA' => null,
            'taxRateB' => null,
            'taxRateC' => null,
            'taxRateD' => null,
            'taxAmtA' => null,
            'taxAmtB' => null,
            'taxAmtC' => null,
            'taxAmtD' => null,
            'totalTaxableAmt' => null,
            'totalTaxAmt' => null,
            'totalAmt' => $totalAmount,
            'prchrAcptcYn' => null,
            'remark' => $data['remark'],
            'regrNm' => null,
            'regrId' => null,
            'modrNm' => null,
            'modrId' => null,
            'receipt_CustomerTin' => null,
            'receipt_CustomerMblNo' => null,
            'receipt_RptNo' => null,
            'receipt_RcptPbctDt' => null,
            'receipt_TrdeNm' => null,
            'receipt_Adrs' => null,
            'receipt_TopMsg' => null,
            'receipt_BtmMsg' => null,
            'receipt_PrchrAcptcYn' => null,
            'createdDate' => null,
            'isKRASynchronized' => null,
            'kraSynchronizedDate' => null,
            'isStockIOUpdate' => $apiResponseData['data']['isStockIOUpdate'],
            'resultCd' => $apiResponseData['statusCode'],
            'resultMsg' => $apiResponseData['message'],
            'resultDt' => null,
            'response_CurRcptNo' => null,
            'response_TotRcptNo' => null,
            'response_IntrlData' => $apiResponseData['data']['scuInternalData'],
            'response_RcptSign' => $apiResponseData['data']['scuReceiptSignature'],
            'response_SdcDateTime' => $apiResponseData['data']['sdcDateTime'],
            'response_SdcId' => $apiResponseData['data']['sdcid'],
            'response_MrcNo' => $apiResponseData['data']['sdcmrcNo'],
            'qrCodeURL' => $apiResponseData['data']['scuqrCode'],
        ]);
    }

    private function createInvoiceProducts($saleItemList, $inv, $customerId)
    {
        foreach ($saleItemList as $item) {
            $itemDetails = ProductService::where('itemCd', $item['itemCode'])->first();
            $itemExprDate = $this->formatDate($item['itemExprDate']);
            InvoiceProduct::create([
                'product_id' => $itemDetails['id'],
                'invoice_id' => $inv['invoice_id'],
                'quantity' => $item['quantity'],
                'tax' => $itemDetails->taxTyCd,
                'discount' => $item['discountAmt'],
                'price' => $this->calculateTotalAmount([
                    ['pkgQuantity' => $item['pkgQuantity'], 'quantity' => $item['quantity'], 'unitPrice' => $item['unitPrice']]
                ]),
                'customer_id' => $customerId,
                "itemCode" => $itemDetails->itemCd,
                "itemClassCode" => $itemDetails->itemClsCd,
                "itemTypeCode" => $itemDetails->itemTyCd,
                "itemName" => $itemDetails->itemNm,
                "orgnNatCd" => $itemDetails->orgnNatCd,
                "taxTypeCode" => $itemDetails->taxTyCd,
                "unitPrice" => $item['unitPrice'],
                "isrcAplcbYn" => $itemDetails->isrcAplcbYn,
                "pkgUnitCode" => $itemDetails->pkgUnitCd,
                "pkgQuantity" => $item['pkgQuantity'],
                "qtyUnitCd" => $itemDetails->qtyUnitCd,
                "discountRate" => $item['discountRate'],
                "discountAmt" => $this->calculateDiscountAmount(
                    $item['pkgQuantity'],
                    $item['quantity'],
                    $item['unitPrice'],
                    $item['discountRate']
                ),
                "itemExprDate" => $itemExprDate
            ]);
        }
    }
    public function edit($ids)
    {
        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            $id = Crypt::decrypt($ids);
            $invoice = Invoice::find($id);
            $invoice_number = \Auth::user()->invoiceNumberFormat($invoice->invoice_id);
            $customers = Customer::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $category = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->where('type', 'income')->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');
            $product_services = ProductService::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $invoice->customField = CustomField::getData($invoice, 'invoice');
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'invoice')->get();

            return view('invoice.edit', compact('customers', 'product_services', 'invoice', 'invoice_number', 'category', 'customFields'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function update(Request $request, Invoice $invoice)
    {

        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            if ($invoice->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'customer_id' => 'required',
                        'issue_date' => 'required',
                        'due_date' => 'required',
                        'category_id' => 'required',
                        'items' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->route('invoice.index')->with('error', $messages->first());
                }
                $invoice->customer_id = $request->customer_id;
                $invoice->issue_date = $request->issue_date;
                $invoice->due_date = $request->due_date;
                $invoice->ref_number = $request->ref_number;
                //                $invoice->discount_apply = isset($request->discount_apply) ? 1 : 0;
                $invoice->category_id = $request->category_id;
                $invoice->save();

                Utility::starting_number($invoice->invoice_id + 1, 'invoice');
                CustomField::saveData($invoice, $request->customField);
                $products = $request->items;

                for ($i = 0; $i < count($products); $i++) {
                    $invoiceProduct = InvoiceProduct::find($products[$i]['id']);

                    if ($invoiceProduct == null) {
                        $invoiceProduct = new InvoiceProduct();
                        $invoiceProduct->invoice_id = $invoice->id;

                        Utility::total_quantity('minus', $products[$i]['quantity'], $products[$i]['item']);

                        $updatePrice = ($products[$i]['price'] * $products[$i]['quantity']) + ($products[$i]['itemTaxPrice']) - ($products[$i]['discount']);
                        Utility::updateUserBalance('customer', $request->customer_id, $updatePrice, 'credit');
                    } else {
                        Utility::total_quantity('plus', $invoiceProduct->quantity, $invoiceProduct->product_id);
                    }

                    if (isset($products[$i]['item'])) {
                        $invoiceProduct->product_id = $products[$i]['item'];
                    }

                    $invoiceProduct->quantity = $products[$i]['quantity'];
                    $invoiceProduct->tax = $products[$i]['tax'];
                    $invoiceProduct->discount = $products[$i]['discount'];
                    $invoiceProduct->price = $products[$i]['price'];
                    $invoiceProduct->description = $products[$i]['description'];
                    $invoiceProduct->save();

                    if ($products[$i]['id'] > 0) {
                        Utility::total_quantity('minus', $products[$i]['quantity'], $invoiceProduct->product_id);
                    }

                    //Product Stock Report
                    $type = 'invoice';
                    $type_id = $invoice->id;
                    StockReport::where('type', '=', 'invoice')->where('type_id', '=', $invoice->id)->delete();
                    $description = $products[$i]['quantity'] . '  ' . __(' quantity sold in invoice') . ' ' . \Auth::user()->invoiceNumberFormat($invoice->invoice_id);
                    if (empty($products[$i]['id'])) {
                        Utility::addProductStock($products[$i]['item'], $products[$i]['quantity'], $type, $description, $type_id);
                    }
                }

                TransactionLines::where('reference_id', $invoice->id)->where('reference', 'Invoice')->delete();

                $invoice_products = InvoiceProduct::where('invoice_id', $invoice->id)->get();
                foreach ($invoice_products as $invoice_product) {
                    $product = ProductService::find($invoice_product->product_id);
                    $totalTaxPrice = 0;
                    if ($invoice_product->tax != null) {
                        $taxes = \App\Models\Utility::tax($invoice_product->tax);
                        foreach ($taxes as $tax) {
                            $taxPrice = \App\Models\Utility::taxRate($tax->rate, $invoice_product->price, $invoice_product->quantity, $invoice_product->discount);
                            $totalTaxPrice += $taxPrice;
                        }
                    }

                    $itemAmount = ($invoice_product->price * $invoice_product->quantity) - ($invoice_product->discount) + $totalTaxPrice;

                    $data = [
                        'account_id' => $product->sale_chartaccount_id,
                        'transaction_type' => 'Credit',
                        'transaction_amount' => $itemAmount,
                        'reference' => 'Invoice',
                        'reference_id' => $invoice->id,
                        'reference_sub_id' => $product->id,
                        'date' => $invoice->issue_date,
                    ];
                    Utility::addTransactionLines($data);
                }

                return redirect()->route('invoice.index')->with('success', __('Invoice successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function invoiceNumber()
    {
        $latest = Invoice::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->invoice_id + 1;
    }

    public function show($ids)
    {

        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'customer'
        ) {
            try {
                $id = Crypt::decrypt($ids);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('Invoice Not Found.'));
            }
            $id = Crypt::decrypt($ids);
            $invoice = Invoice::with(['creditNote', 'payments.bankAccount', 'items.product'])->find($id);

            if (!empty($invoice->created_by) == \Auth::user()->creatorId()) {
                $invoicePayment = InvoicePayment::where('invoice_id', $invoice->id)->first();

                $customer = $invoice->customer;
                // Retrieve associated sales products
                $iteams = InvoiceProduct::where('invoice_id', $invoice->invoice_id)->get();

                $user = \Auth::user();

                // start for storage limit note
                $invoice_user = User::find($invoice->created_by);
                $user_plan = Plan::getPlan($invoice_user->plan);
                // end for storage limit note

                $invoice->customField = CustomField::getData($invoice, 'invoice');
                $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'invoice')->get();

                return view('invoice.view', compact('invoice', 'customer', 'iteams', 'invoicePayment', 'customFields', 'user', 'invoice_user', 'user_plan'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Invoice $invoice, Request $request)
    {
        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            if ($invoice->created_by == \Auth::user()->creatorId()) {
                foreach ($invoice->payments as $invoices) {
                    Utility::bankAccountBalance($invoices->account_id, $invoices->amount, 'debit');

                    $invoicepayment = InvoicePayment::find($invoices->id);
                    $invoices->delete();
                    $invoicepayment->delete();
                }

                if ($invoice->customer_id != 0 && $invoice->status != 0) {
                    Utility::updateUserBalance('customer', $invoice->customer_id, $invoice->getDue(), 'debit');
                }


                TransactionLines::where('reference_id', $invoice->id)->where('reference', 'Invoice')->delete();
                TransactionLines::where('reference_id', $invoice->id)->Where('reference', 'Invoice Payment')->delete();

                CreditNote::where('invoice', '=', $invoice->id)->delete();

                InvoiceProduct::where('invoice_id', '=', $invoice->invoice_id)->delete();
                $invoice->delete();
                return redirect()->route('invoice.index')->with('success', __('Invoice successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function productDestroy(Request $request)
    {

        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            $invoiceProduct = InvoiceProduct::find($request->id);

            if ($invoiceProduct) {
                $invoice = Invoice::find($invoiceProduct->invoice_id);
                $productService = ProductService::find($invoiceProduct->product_id);

                Utility::updateUserBalance('customer', $invoice->customer_id, $request->amount, 'debit');

                TransactionLines::where('reference_sub_id', $productService->id)->where('reference', 'Invoice')->delete();

                InvoiceProduct::where('id', '=', $request->id)->delete();
            }


            return redirect()->back()->with('success', __('Invoice product successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function customerInvoice(Request $request)
    {
        if (\Auth::user()->type == 'customer') {

            $status = Invoice::$statues;
            $query = Invoice::where('customer_id', '=', \Auth::user()->id)->where('status', '!=', '0')->where('created_by', \Auth::user()->creatorId());

            if (!empty($request->issue_date)) {
                $date_range = explode(' - ', $request->issue_date);
                $query->whereBetween('issue_date', $date_range);
            }

            if (!empty($request->status)) {
                $query->where('status', '=', $request->status);
            }
            $invoices = $query->get();

            return view('invoice.index', compact('invoices', 'status'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function customerInvoiceShow($id)
    {

        $invoice = Invoice::with('payments.bankAccount')->find($id);

        $user = User::where('id', $invoice->created_by)->first();
        if ($invoice->created_by == $user->creatorId()) {
            $customer = $invoice->customer;
            $iteams = $invoice->items;

            if ($user->type == 'super admin') {
                return view('invoice.view', compact('invoice', 'customer', 'iteams', 'user'));
            } elseif ($user->type == 'company') {
                return view('invoice.customer_invoice', compact('invoice', 'customer', 'iteams', 'user', 'taxationtype'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function sent($id)
    {

        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            // Send Email
            $setings = Utility::settings();

            if ($setings['customer_invoice_sent'] == 1) {
                $invoice = Invoice::where('id', $id)->first();
                $invoice->send_date = date('Y-m-d');
                $invoice->status = 1;
                $invoice->save();

                $customer = Customer::where('id', $invoice->customer_id)->first();
                $invoice->name = !empty($customer) ? $customer->name : '';
                $invoice->invoice = \Auth::user()->invoiceNumberFormat($invoice->invoice_id);

                $invoiceId = Crypt::encrypt($invoice->id);
                $invoice->url = route('invoice.pdf', $invoiceId);

                Utility::updateUserBalance('customer', $customer->id, $invoice->getTotal(), 'credit');

                $invoice_products = InvoiceProduct::where('invoice_id', $invoice->id)->get();
                foreach ($invoice_products as $invoice_product) {
                    $product = ProductService::find($invoice_product->product_id);
                    $totalTaxPrice = 0;
                    // Manually specify tax rates based on taxTypeCode
                    switch ($invoice_product->taxTypeCode) {
                        case 'B':
                            $taxRate = 16 / 100; // 16%
                            break;
                        case 'E':
                            $taxRate = 8 / 100; // 8%
                            break;
                        default:
                            $taxRate = 0; // No tax
                    }

                    // Calculate tax price based on the manually specified tax rate
                    $taxPrice = \App\Models\Utility::taxRate($taxRate, $invoice_product->price, $invoice_product->quantity, $invoice_product->discount);
                    // Add the tax price to the total tax price
                    $totalTaxPrice += $taxPrice;

                    $itemAmount = ($invoice_product->price * $invoice_product->quantity) - ($invoice_product->discount) + $totalTaxPrice;

                    $data = [
                        'account_id' => $product->sale_chartaccount_id,
                        'transaction_type' => 'Credit',
                        'transaction_amount' => $itemAmount,
                        'reference' => 'Invoice',
                        'reference_id' => $invoice->id,
                        'reference_sub_id' => $product->id,
                        'date' => $invoice->issue_date,
                    ];
                    Utility::addTransactionLines($data);
                }

                $customerArr = [

                    'customer_name' => $customer->name,
                    'customer_email' => $customer->email,
                    'invoice_name' => $customer->name,
                    'invoice_number' => $invoice->invoice,
                    'invoice_url' => $invoice->url,

                ];
                $resp = Utility::sendEmailTemplate('customer_invoice_sent', [$customer->id => $customer->email], $customerArr);

                return redirect()->back()->with('success', __('Invoice successfully sent.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function resent($id)
    {
        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            $invoice = Invoice::where('id', $id)->first();

            $customer = Customer::where('id', $invoice->customer_id)->first();
            $invoice->name = !empty($customer) ? $customer->name : '';
            $invoice->invoice = \Auth::user()->invoiceNumberFormat($invoice->invoice_id);

            $invoiceId = Crypt::encrypt($invoice->id);
            $invoice->url = route('invoice.pdf', $invoiceId);
            $customerArr = [

                'customer_name' => $customer->name,
                'customer_email' => $customer->email,
                'invoice_name' => $customer->name,
                'invoice_number' => $invoice->invoice,
                'invoice_url' => $invoice->url,

            ];
            $resp = Utility::sendEmailTemplate('customer_invoice_sent', [$customer->id => $customer->email], $customerArr);

            return redirect()->back()->with('success', __('Invoice successfully sent.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function payment($invoice_id)
    {
        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            $invoice = Invoice::where('id', $invoice_id)->first();

            $customers = Customer::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $categories = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $accounts = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' ',holder_name) AS name"))->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('invoice.payment', compact('customers', 'categories', 'accounts', 'invoice'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function createPayment(Request $request, $invoice_id)
    {
        $invoice = Invoice::find($invoice_id);
        if ($invoice->getDue() < $request->amount) {
            return redirect()->back()->with('error', __('Invoice payment amount should not greater than subtotal.'));
        }

        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'date' => 'required',
                    'amount' => 'required',
                    'account_id' => 'required',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $invoicePayment = new InvoicePayment();
            $invoicePayment->invoice_id = $invoice_id;
            $invoicePayment->date = $request->date;
            $invoicePayment->amount = $request->amount;
            $invoicePayment->account_id = $request->account_id;
            $invoicePayment->payment_method = 0;
            $invoicePayment->reference = $request->reference;
            $invoicePayment->description = $request->description;
            if (!empty($request->add_receipt)) {
                //storage limit
                $image_size = $request->file('add_receipt')->getSize();
                $result = Utility::updateStorageLimit(\Auth::user()->creatorId(), $image_size);
                if ($result == 1) {
                    $fileName = time() . "_" . $request->add_receipt->getClientOriginalName();
                    $request->add_receipt->storeAs('', $fileName);
                    $invoicePayment->add_receipt = $fileName;
                }
            }

            $invoicePayment->save();

            $invoice = Invoice::where('id', $invoice_id)->first();
            $due = $invoice->getDue();
            $total = $invoice->getTotal();
            if ($invoice->status == 0) {
                $invoice->send_date = date('Y-m-d');
                $invoice->save();
            }

            if ($due <= 0) {
                $invoice->status = 4;
                $invoice->save();
            } else {
                $invoice->status = 3;
                $invoice->save();
            }
            $invoicePayment->user_id = $invoice->customer_id;
            $invoicePayment->user_type = 'Customer';
            $invoicePayment->type = 'Partial';
            $invoicePayment->created_by = \Auth::user()->id;
            $invoicePayment->payment_id = $invoicePayment->id;
            $invoicePayment->category = 'Invoice';
            $invoicePayment->account = $request->account_id;

            Transaction::addTransaction($invoicePayment);
            $customer = Customer::where('id', $invoice->customer_id)->first();

            $payment = new InvoicePayment();
            $payment->name = $customer['name'];
            $payment->date = \Auth::user()->dateFormat($request->date);
            $payment->amount = \Auth::user()->priceFormat($request->amount);
            $payment->invoice = 'invoice ' . \Auth::user()->invoiceNumberFormat($invoice->invoice_id);
            $payment->dueAmount = \Auth::user()->priceFormat($invoice->getDue());

            Utility::updateUserBalance('customer', $invoice->customer_id, $request->amount, 'debit');

            Utility::bankAccountBalance($request->account_id, $request->amount, 'credit');

            $invoicePayments = InvoicePayment::where('invoice_id', $invoice->id)->get();
            foreach ($invoicePayments as $invoicePayment) {

                $accountId = BankAccount::find($invoicePayment->account_id);
                $data = [
                    'account_id' => $accountId->chart_account_id,
                    'transaction_type' => 'Debit',
                    'transaction_amount' => $invoicePayment->amount,
                    'reference' => 'Invoice Payment',
                    'reference_id' => $invoice->id,
                    'reference_sub_id' => $invoicePayment->id,
                    'date' => $invoicePayment->date,
                ];
                Utility::addTransactionLines($data);
            }

            // Send Email
            $setings = Utility::settings();
            if ($setings['new_invoice_payment'] == 1) {
                $customer = Customer::where('id', $invoice->customer_id)->first();
                $invoicePaymentArr = [
                    'invoice_payment_name' => $customer->name,
                    'invoice_payment_amount' => $payment->amount,
                    'invoice_payment_date' => $payment->date,
                    'payment_dueAmount' => $payment->dueAmount,

                ];

                $resp = Utility::sendEmailTemplate('new_invoice_payment', [$customer->id => $customer->email], $invoicePaymentArr);
            }

            //webhook
            $module = 'New Invoice Payment';
            $webhook = Utility::webhookSetting($module);
            if ($webhook) {
                $parameter = json_encode($invoice);
                $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);
                if ($status == true) {
                    return redirect()->back()->with('success', __('Payment successfully added.') . ((isset($result) && $result != 1) ? '<br> <span class="text-danger">' . $result . '</span>' : '') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
                } else {
                    return redirect()->back()->with('error', __('Webhook call failed.'));
                }
            }
            return redirect()->back()->with('success', __('Payment successfully added.') . ((isset($result) && $result != 1) ? '<br> <span class="text-danger">' . $result . '</span>' : '') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
        }
    }

    public function paymentDestroy(Request $request, $invoice_id, $payment_id)
    {
        //        dd($invoice_id,$payment_id);

        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            $payment = InvoicePayment::find($payment_id);

            InvoicePayment::where('id', '=', $payment_id)->delete();

            InvoiceBankTransfer::where('id', '=', $payment_id)->delete();

            TransactionLines::where('reference_sub_id', $payment_id)->where('reference', 'Invoice Payment')->delete();

            $invoice = Invoice::where('id', $invoice_id)->first();
            $due = $invoice->getDue();
            $total = $invoice->getTotal();

            if ($due > 0 && $total != $due) {
                $invoice->status = 3;
            } else {
                $invoice->status = 2;
            }

            if (!empty($payment->add_receipt)) {
                //storage limit
                $file_path = '/uploads/payment/' . $payment->add_receipt;
                $result = Utility::changeStorageLimit(\Auth::user()->creatorId(), $file_path);
            }

            $invoice->save();
            $type = 'Partial';
            $user = 'Customer';
            Transaction::destroyTransaction($payment_id, $type, $user);

            Utility::updateUserBalance('customer', $invoice->customer_id, $payment->amount, 'credit');

            Utility::bankAccountBalance($payment->account_id, $payment->amount, 'debit');

            return redirect()->back()->with('success', __('Payment successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function paymentReminder($invoice_id)
    {

        //        dd($invoice_id);
        $invoice = Invoice::find($invoice_id);
        $customer = Customer::where('id', $invoice->customer_id)->first();
        $invoice->dueAmount = \Auth::user()->priceFormat($invoice->getDue());
        $invoice->name = $customer['name'];
        $invoice->date = \Auth::user()->dateFormat($invoice->send_date);
        $invoice->invoice = \Auth::user()->invoiceNumberFormat($invoice->invoice_id);

        //For Notification
        $setting = Utility::settings(\Auth::user()->creatorId());
        $customer = Customer::find($invoice->customer_id);
        $reminderNotificationArr = [
            'invoice_number' => \Auth::user()->invoiceNumberFormat($invoice->invoice_id),
            'customer_name' => $customer->name,
            'user_name' => \Auth::user()->name,
        ];

        //Twilio Notification
        if (isset($setting['twilio_reminder_notification']) && $setting['twilio_reminder_notification'] == 1) {
            Utility::send_twilio_msg($customer->contact, 'invoice_payment_reminder', $reminderNotificationArr);
        }

        // Send Email
        $setings = Utility::settings();
        if ($setings['new_payment_reminder'] == 1) {
            $invoice = Invoice::find($invoice_id);
            $customer = Customer::where('id', $invoice->customer_id)->first();
            $invoice->dueAmount = \Auth::user()->priceFormat($invoice->getDue());
            $invoice->name = $customer['name'];
            $invoice->date = \Auth::user()->dateFormat($invoice->send_date);
            $invoice->invoice = \Auth::user()->invoiceNumberFormat($invoice->invoice_id);

            $reminderArr = [

                'payment_reminder_name' => $invoice->name,
                'invoice_payment_number' => $invoice->invoice,
                'invoice_payment_dueAmount' => $invoice->dueAmount,
                'payment_reminder_date' => $invoice->date,

            ];

            $resp = Utility::sendEmailTemplate('new_payment_reminder', [$customer->id => $customer->email], $reminderArr);
        }

        return redirect()->back()->with('success', __('Payment reminder successfully send.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
    }

    public function customerInvoiceSend($invoice_id)
    {
        return view('customer.invoice_send', compact('invoice_id'));
    }

    public function customerInvoiceSendMail(Request $request, $invoice_id)
    {
        $validator = \Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
            ]
        );
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $email = $request->email;
        $invoice = Invoice::where('id', $invoice_id)->first();

        $customer = Customer::where('id', $invoice->customer_id)->first();
        $invoice->name = !empty($customer) ? $customer->name : '';
        $invoice->invoice = \Auth::user()->invoiceNumberFormat($invoice->invoice_id);

        $invoiceId = Crypt::encrypt($invoice->id);
        $invoice->url = route('invoice.pdf', $invoiceId);

        try {
            Mail::to($email)->send(new CustomerInvoiceSend($invoice));
        } catch (\Exception $e) {
            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
        }

        return redirect()->back()->with('success', __('Invoice successfully sent.') . ((isset($smtp_error)) ? '<br> <span class="text-danger">' . $smtp_error . '</span>' : ''));
    }

    public function shippingDisplay(Request $request, $id)
    {
        $invoice = Invoice::find($id);

        if ($request->is_display == 'true') {
            $invoice->shipping_display = 1;
        } else {
            $invoice->shipping_display = 0;
        }
        $invoice->save();

        return redirect()->back()->with('success', __('Shipping address status successfully changed.'));
    }

    public function duplicate($invoice_id)
    {
        if (\Auth::user()->type == 'company') {
            $invoice = Invoice::where('id', $invoice_id)->first();
            $duplicateInvoice = new Invoice();
            $duplicateInvoice->invoice_id = $this->invoiceNumber();
            $duplicateInvoice->customer_id = $invoice['customer_id'];
            $duplicateInvoice->issue_date = date('Y-m-d');
            $duplicateInvoice->due_date = $invoice['due_date'];
            $duplicateInvoice->send_date = null;
            $duplicateInvoice->category_id = $invoice['category_id'];
            $duplicateInvoice->ref_number = $invoice['ref_number'];
            $duplicateInvoice->status = 0;
            $duplicateInvoice->shipping_display = $invoice['shipping_display'];
            $duplicateInvoice->created_by = $invoice['created_by'];
            $duplicateInvoice->save();

            if ($duplicateInvoice) {
                $invoiceProduct = InvoiceProduct::where('invoice_id', $invoice_id)->get();
                foreach ($invoiceProduct as $product) {
                    $duplicateProduct = new InvoiceProduct();
                    $duplicateProduct->invoice_id = $duplicateInvoice->id;
                    $duplicateProduct->product_id = $product->product_id;
                    $duplicateProduct->quantity = $product->quantity;
                    $duplicateProduct->tax = $product->tax;
                    $duplicateProduct->discount = $product->discount;
                    $duplicateProduct->price = $product->price;
                    $duplicateProduct->save();
                }
            }

            return redirect()->back()->with('success', __('Invoice duplicate successfully.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function previewInvoice($template, $color)
    {

        $objUser = \Auth::user();
        $settings = Utility::settings();
        $invoice = new Invoice();

        $customer = new \stdClass();
        $customer->email = '<Email>';
        $customer->shipping_name = '<Customer Name>';
        $customer->shipping_country = '<Country>';
        $customer->shipping_state = '<State>';
        $customer->shipping_city = '<City>';
        $customer->shipping_phone = '<Customer Phone Number>';
        $customer->shipping_zip = '<Zip>';
        $customer->shipping_address = '<Address>';
        $customer->billing_name = '<Customer Name>';
        $customer->billing_country = '<Country>';
        $customer->billing_state = '<State>';
        $customer->billing_city = '<City>';
        $customer->billing_phone = '<Customer Phone Number>';
        $customer->billing_zip = '<Zip>';
        $customer->billing_address = '<Address>';

        $totalTaxPrice = 0;
        $taxesData = [];

        $items = [];
        for ($i = 1; $i <= 3; $i++) {
            $item = new \stdClass();
            $item->name = 'Item ' . $i;
            $item->quantity = 1;
            $item->tax = 5;
            $item->discount = 50;
            $item->price = 100;
            $item->unit = 1;
            $item->description = 'XYZ';

            $taxes = [
                'Tax 1',
                'Tax 2',
            ];

            $itemTaxes = [];
            foreach ($taxes as $k => $tax) {
                $taxPrice = 10;
                $totalTaxPrice += $taxPrice;
                $itemTax['name'] = 'Tax ' . $k;
                $itemTax['rate'] = '10 %';
                $itemTax['price'] = '$10';
                $itemTax['tax_price'] = 10;
                $itemTaxes[] = $itemTax;
                if (array_key_exists('Tax ' . $k, $taxesData)) {
                    $taxesData['Tax ' . $k] = $taxesData['Tax 1'] + $taxPrice;
                } else {
                    $taxesData['Tax ' . $k] = $taxPrice;
                }
            }
            $item->itemTax = $itemTaxes;
            $items[] = $item;
        }

        $invoice->invoice_id = 1;
        $invoice->issue_date = date('Y-m-d H:i:s');
        $invoice->due_date = date('Y-m-d H:i:s');
        $invoice->itemData = $items;
        $invoice->status = 0;
        $invoice->totalTaxPrice = 60;
        $invoice->totalQuantity = 3;
        $invoice->totalRate = 300;
        $invoice->totalDiscount = 10;
        $invoice->taxesData = $taxesData;
        $invoice->created_by = $objUser->creatorId();

        $invoice->customField = [];
        $customFields = [];

        $preview = 1;
        $color = '#' . $color;
        $font_color = Utility::getFontColor($color);

        $logo = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo_dark');
        $invoice_logo = Utility::getValByName('invoice_logo');
        if (isset($invoice_logo) && !empty($invoice_logo)) {
            $img = Utility::get_file('invoice_logo/') . $invoice_logo;
        } else {
            $img = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));
        }

        return view('invoice.templates.' . $template, compact('invoice', 'preview', 'color', 'img', 'settings', 'customer', 'font_color', 'customFields'));
    }

    public function invoice($invoice_id)
    {
        $settings = Utility::settings();

        $invoiceId = Crypt::decrypt($invoice_id);
        $invoice = Invoice::where('id', $invoiceId)->first();

        $data = DB::table('settings');
        $data = $data->where('created_by', '=', $invoice->created_by);
        $data1 = $data->get();

        foreach ($data1 as $row) {
            $settings[$row->name] = $row->value;
        }

        $customer = $invoice->customer;
        $items = [];
        $totalTaxPrice = 0;
        $totalQuantity = 0;
        $totalRate = 0;
        $totalDiscount = 0;
        $taxesData = [];
        foreach ($invoice->items as $product) {
            $item = new \stdClass();
            $item->name = !empty($product->product) ? $product->product->name : '';
            $item->quantity = $product->quantity;
            $item->pkgQuantity = $product->pkgQuantity;
            $item->tax = $product->tax;
            $item->unit = !empty($product->product) ? $product->product->unit_id : '';
            $item->discount = $product->discount;
            $item->unitPrice = $product->quantity * $product->pkgQuantity * $product->unitPrice;
            $item->taxTypeCode = $product->taxTypeCode;
            $item->price = $product->price;
            $item->description = $product->description;

            $totalQuantity += $item->quantity;
            $totalRate += $item->price;
            $totalDiscount += $item->discount;

            $taxes = Utility::tax($product->tax);

            $items[] = $item;
        }

        $invoice->itemData = $items;
        $invoice->totalTaxPrice = $totalTaxPrice;
        $invoice->totalQuantity = $totalQuantity;
        $invoice->totalRate = $totalRate;
        $invoice->totalDiscount = $totalDiscount;
        $invoice->taxesData = $taxesData;
        $invoice->customField = CustomField::getData($invoice, 'invoice');
        $customFields = [];
        if (!empty(\Auth::user())) {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'invoice')->get();
        }
        //
        //        $logo         = asset(Storage::url('uploads/logo/'));
        //        $company_logo = Utility::getValByName('company_logo_dark');
        //        $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));

        $logo = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo_dark');
        $settings_data = Utility::settingsById($invoice->created_by);
        $invoice_logo = $settings_data['invoice_logo'];
        if (isset($invoice_logo) && !empty($invoice_logo)) {
            $img = Utility::get_file('invoice_logo/') . $invoice_logo;
        } else {
            $img = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));
        }

        if ($invoice) {
            $color = '#' . $settings['invoice_color'];
            $font_color = Utility::getFontColor($color);

            \Log::info('iteam(item)');
            \Log::info($items);

            return view('invoice.templates.' . $settings['invoice_template'], compact('items', 'invoice', 'color', 'settings', 'customer', 'img', 'font_color', 'customFields'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function saveTemplateSettings(Request $request)
    {

        $post = $request->all();
        unset($post['_token']);

        if (isset($post['invoice_template']) && (!isset($post['invoice_color']) || empty($post['invoice_color']))) {
            $post['invoice_color'] = "ffffff";
        }

        if ($request->invoice_logo) {
            $dir = 'invoice_logo/';
            $invoice_logo = \Auth::user()->id . '_invoice_logo.png';
            $validation = [
                'mimes:' . 'png',
                'max:' . '20480',
            ];
            $path = Utility::upload_file($request, 'invoice_logo', $invoice_logo, $dir, $validation);

            if ($path['flag'] == 0) {
                return redirect()->back()->with('error', __($path['msg']));
            }
            $post['invoice_logo'] = $invoice_logo;
        }

        foreach ($post as $key => $data) {
            \DB::insert(
                'insert into settings (`value`, `name`,`created_by`) values (?, ?, ?) ON DUPLICATE KEY UPDATE `value` = VALUES(`value`) ',
                [
                    $data,
                    $key,
                    \Auth::user()->creatorId(),
                ]
            );
        }

        return redirect()->back()->with('success', __('Invoice Setting updated successfully'));
    }

    public function items(Request $request)
    {
        $items = InvoiceProduct::where('invoice_id', $request->invoice_id)->where('product_id', $request->product_id)->first();

        return json_encode($items);
    }

    public function invoiceLink($invoiceId)
    {
        try {
            $id = Crypt::decrypt($invoiceId);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Invoice Not Found.'));
        }

        $id = Crypt::decrypt($invoiceId);
        \Log::info('INVOICE ID');
        \Log::info($invoiceId);
        $invoice = Invoice::with(['creditNote', 'payments.bankAccount', 'items.product.unit'])->where('invoice_id', $id)->first();

        \Log::info('INVOICE');
        \Log::info($invoice);

        $settings = Utility::settingsById($invoice->created_by);

        if (!empty($invoice)) {

            $user_id = $invoice->created_by;
            $user = User::find($user_id);
            $invoicePayment = InvoicePayment::where('invoice_id', $invoice->id)->get();
            $customer = $invoice->customer;
            $iteams = $invoice->items;
            $invoice->customField = CustomField::getData($invoice, 'invoice');
            $customFields = CustomField::where('module', '=', 'invoice')->get();
            $company_payment_setting = Utility::getCompanyPaymentSetting($user_id);

            // start for storage limit note
            $user_plan = Plan::find($user->plan);
            // end for storage limit note

            return view('invoice.customer_invoice', compact('settings', 'invoice', 'customer', 'iteams', 'invoicePayment', 'customFields', 'user', 'company_payment_setting', 'user_plan'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function export()
    {
        $name = 'invoice_' . date('Y-m-d i:h:s');
        $data = Excel::download(new InvoiceExport(), $name . '.xlsx');
        ob_end_clean();

        return $data;
    }

    public function getItem($itemCd)
    {
        try {
            $itemInfo = ProductService::where('itemCd', $itemCd)->first();
            return response()->json([
                'message' => 'success',
                'data' => $itemInfo
            ]);
        } catch (\Exception $e) {
            \Log::info('Get Item Error');
            \Log::info($e);
            return response()->json([
                'message' => 'error',
                'error' => $e->getMessage()
            ]);
        }
    }




    public function getSalesByTraderInvoiceNo(Request $request)
    {
        // Log the incoming request
        \Log::info('Synchronization request received:', $request->all());

        // Validate the trader invoice number input
        $request->validate([
            'SalesByTraderInvoiceNo' => 'required|integer',
        ], [
            'SalesByTraderInvoiceNo.required' => __('Data is required for synchronization.'),
        ]);

        // Get the trader invoice number
        $traderInvoiceNo = $request->input('SalesByTraderInvoiceNo');
        \Log::info('Trader Invoice No for synchronization request:', ['Trader Invoice' => $traderInvoiceNo]);

        try {
            // Make the API call
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['key' => '123456'])
                ->get("https://etims.your-apps.biz/api/GetSalesByTraderInvoiceNo", [
                    'traderInvoiceNo' => $traderInvoiceNo,
                ]);

            // Check if the response contains the required data
            $data = $response->json();
            if (empty($data)) {
                return redirect()->back()->with('error', __('There is no search result.'));
            }

            \Log::info('Remote Sales Data:', $data);

            $invoiceData = [
                'srNo' => $data['id'],
                'invoice_id' => $data['id'],
                'customer_id' => null,
                'issue_date' => $data['salesDate'],
                'due_date' => $data['salesDate'],
                'send_date' => null,
                'category_id' => null,
                'ref_number' => $data['invoiceNo'],
                'status' => $data['salesSttsCode'],
                'shipping_display' => null,
                'discount_apply' => null,
                'created_by' => \Auth::user()->creatorId(),
                'trderInvoiceNo' => $data['trderInvoiceNo'],
                'invoiceNo' => $data['invoiceNo'],
                'orgInvoiceNo' => $data['orgInvoiceNo'],
                'customerTin' => $data['customerTin'],
                'customerName' => $data['customerName'],
                'receptTypeCode' => $data['receptTypeCode'],
                'paymentTypeCode' => $data['paymentTypeCode'],
                'salesSttsCode' => $data['salesSttsCode'],
                'confirmDate' => $data['confirmDate'],
                'salesDate' => $data['salesDate'],
                'stockReleaseDate' => $data['stockReleaseDate'],
                'cancelReqDate' => $data['cancelReqDate'],
                'cancelDate' => $data['cancelDate'],
                'refundDate' => $data['refundDate'],
                'refundReasonCd' => $data['refundReasonCd'],
                'totalItemCnt' => $data['totalItemCnt'],
                'taxableAmtA' => $data['taxableAmtA'],
                'taxableAmtB' => $data['taxableAmtB'],
                'taxableAmtC' => $data['taxableAmtC'],
                'taxableAmtD' => $data['taxableAmtD'],
                'taxRateA' => $data['taxRateA'],
                'taxRateB' => $data['taxRateB'],
                'taxRateC' => $data['taxRateC'],
                'taxRateD' => $data['taxRateD'],
                'taxAmtA' => $data['taxAmtA'],
                'taxAmtB' => $data['taxAmtB'],
                'taxAmtC' => $data['taxAmtC'],
                'taxAmtD' => $data['taxAmtD'],
                'totalTaxableAmt' => $data['totalTaxableAmt'],
                'totalTaxAmt' => $data['totalTaxAmt'],
                'totalAmt' => $data['totalAmt'],
                'prchrAcptcYn' => $data['prchrAcptcYn'],
                'remark' => $data['remark'],
                'regrNm' => $data['regrNm'],
                'regrId' => $data['regrId'],
                'modrNm' => $data['modrNm'],
                'modrId' => $data['modrId'],
                'receipt_CustomerTin' => $data['receipt_CustomerTin'],
                'receipt_CustomerMblNo' => $data['receipt_CustomerMblNo'],
                'receipt_RptNo' => $data['receipt_RptNo'],
                'receipt_RcptPbctDt' => $data['receipt_RcptPbctDt'],
                'receipt_TrdeNm' => $data['receipt_TrdeNm'],
                'receipt_Adrs' => $data['receipt_Adrs'],
                'receipt_TopMsg' => $data['receipt_TopMsg'],
                'receipt_BtmMsg' => $data['receipt_BtmMsg'],
                'receipt_PrchrAcptcYn' => $data['receipt_PrchrAcptcYn'],
                'createdDate' => $data['createdDate'],
                'isKRASynchronized' => $data['isKRASynchronized'],
                'kraSynchronizedDate' => $data['kraSynchronizedDate'],
                'isStockIOUpdate' => $data['isStockIOUpdate'],
                'resultCd' => $data['resultCd'],
                'resultMsg' => $data['resultMsg'],
                'resultDt' => $data['resultDt'],
                'response_CurRcptNo' => $data['response_CurRcptNo'],
                'response_TotRcptNo' => $data['response_TotRcptNo'],
                'response_IntrlData' => $data['response_IntrlData'],
                'response_RcptSign' => $data['response_RcptSign'],
                'response_SdcDateTime' => $data['response_SdcDateTime'],
                'response_SdcId' => $data['response_SdcId'],
                'response_MrcNo' => $data['response_MrcNo'],
                'qrCodeURL' => $data['qrCodeURL'],
            ];

            \Log::info('Invoice Data to Sync:', $invoiceData);

            // Check if the invoice already exists and sync if not
            $exists = Invoice::where('trderInvoiceNo', $invoiceData['trderInvoiceNo'])->exists();
            if (!$exists) {
                Invoice::create($invoiceData);
                return redirect()->back()->with('success', __('Synced sales record successfully.'));
            } else {
                return redirect()->back()->with('success', __('Sales record is up to date.'));
            }
        } catch (\Exception $e) {
            \Log::error('Error syncing sales Trader Invoice No:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Sales Trader Invoice No, Not Found !'));
        }
    }
}
