<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Utility;
use App\Models\Customer;
use App\Models\CreditNote;
use App\Models\CustomField;
use Illuminate\Http\Request;
use App\Models\SalesTypeCode;
use App\Models\ConfigSettings;
use App\Models\CreditNoteItem;
use App\Models\ProductService;
use App\Models\CreditNoteReason;
use App\Models\PaymentTypeCodes;
use App\Models\InvoiceStatusCode;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Validator;

class CreditNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if (
            Auth::user()->type == 'accountant'
            || Auth::user()->type == 'company'
        ) {
            $invoices = Invoice::where('created_by', Auth::user()->creatorId())->get();

            return view('creditNote.index', compact('invoices'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create($invoice_id)
    {

        if (
            Auth::user()->type == 'accountant'
            || Auth::user()->type == 'company'
        ) {

            // Fetch the invoice by ID
            $invoice = Invoice::findOrFail($invoice_id);

            //    $invoiceProduct = InvoiceProduct::where('invoice_id', $invoice_id)->get();
            $invoiceProducts = $invoice->items; // $invoice is the Invoice instance

            $invoiceDue = Invoice::where('id', $invoice_id)->first();
            $customer = Customer::find($invoiceDue->customer_id);
            $customers = Customer::all()->pluck('name', 'name');
            $itemsToAdd = ProductService::all()->pluck('itemNm', 'itemCd');
            $creditNoteReasons = CreditNoteReason::all()->pluck('reason', 'reason');
            $salesTypeCodes = SalesTypeCode::all()->pluck('saleTypeCode', 'code');
            $paymentTypeCodes = PaymentTypeCodes::all()->pluck('payment_type_code', 'code');
            $invoiceStatusCodes = InvoiceStatusCode::all()->pluck('invoiceStatusCode', 'code');

            return view(
                'creditNote.create',
                compact(
                    'invoiceDue',
                    'invoice_id',
                    'customers',
                    'creditNoteReasons',
                    'salesTypeCodes',
                    'paymentTypeCodes',
                    'invoiceStatusCodes',
                    'customer',
                    'itemsToAdd',
                    'invoice',
                    'invoiceProducts'
                )
            );
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request, $id)
    {
        try {
            if (Auth::user()->type == 'accountant' || Auth::user()->type == 'company') {

                $data = $request->all();
                $invoice = Invoice::find($id);
                $invoice_id = Auth::user()->invoiceNumberFormat($id);

                Log::info('CREDIT NOTE REQUEST DATA');
                Log::info($data);

                Log::info('INVOICE ID');
                Log::info($invoice_id);

                Log::info('INVOICE');
                Log::info($invoice);

                $validator = Validator::make(
                    $data,
                    [
                        'customerName' => 'required',
                        'customerTin' => 'required',
                        'creditNoteReason' => 'required',
                        'traderInvoiceNo' => 'required|unique:credit_notes,traderInvoiceNo',
                        'confirmDate' => 'required',
                        'salesDate' => 'required',
                        'receiptPublishDate' => 'required',
                        'occurredDate' => 'required'
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                if (empty($data['items']) || !is_array($data['items'])) {
                    return redirect()->back()->with('error', 'No items provided for the credit note.');
                }

                $salesDate = date('Ymd', strtotime(str_replace('-', '', $data['salesDate'])));
                $occurredDate = date('Ymd', strtotime(str_replace('-', '', $data['occurredDate'])));
                $creditNoteDate = date('YmdHis', strtotime(str_replace('-', '', $data['creditNoteDate'])));
                $stockReleseDate = date('YmdHis', strtotime(str_replace('-', '', $data['stockReleseDate'])));
                $receiptPublishDate = date('YmdHis', strtotime(str_replace('-', '', $data['receiptPublishDate'])));
                $confirmDate = date('YmdHis', strtotime(str_replace('-', '', $data['confirmDate'])));

                $apiCreditNoteItemsList = [];
                $totalAmount = 0;

                foreach ($data['items'] as $item) {
                    $givenItem = ProductService::where('kraItemCode', $item['item_'])->first();

                    $itemExprDate = date('Ymd', strtotime(str_replace('-', '', $item['itemExprDate'])));
                    $totalForEachProduct = ($item['price'] * $item['quantity'] * $item['pkgQuantity']) - $item['discountAmt'];
                    $totalAmount += $totalForEachProduct;

                    $apiItemData = [
                        'itemCode' => $item['item_'],
                        'itemClassCode' => $givenItem['itemClsCd'],
                        "itemTypeCode" => $givenItem['itemTyCd'],
                        "itemName" => $givenItem['itemNm'],
                        "orgnNatCd" => $givenItem['orgnNatCd'],
                        "taxTypeCode" => $givenItem['taxTyCd'],
                        "unitPrice" => $item['price'],
                        "isrcAplcbYn" => $givenItem['isrcAplcbYn'],
                        "pkgUnitCode" => $givenItem['pkgUnitCd'],
                        "pkgQuantity" => $item['pkgQuantity'],
                        "qtyUnitCd" => $givenItem['qtyUnitCd'],
                        "quantity" => $item['quantity'],
                        "discountRate" => $item['discountRate'],
                        "discountAmt" => $item['discountAmt'],
                        'itemExprDate' => $itemExprDate
                    ];

                    array_push($apiCreditNoteItemsList, $apiItemData);
                }

                $apiRequestData = [
                    'orgInvoiceNo' => $id,
                    'customerTin' => $data['customerTin'],
                    'customerName' => $data['customerName'],
                    'salesType' => $data['salesType'] ?? null,
                    'paymentType' => $data['paymentType'] ?? null,
                    'creditNoteReason' => $data['creditNoteReason'],
                    'creditNoteDate' => $creditNoteDate,
                    'traderInvoiceNo' => $data['traderInvoiceNo'],
                    'confirmDate' => $confirmDate,
                    'salesDate' => $salesDate,
                    'stockReleseDate' => $stockReleseDate,
                    'receiptPublishDate' => $receiptPublishDate,
                    'occurredDate' => $occurredDate,
                    "invoiceStatusCode" => $data['invoiceStatusCode'] ?? null,
                    "remark" => $data['remark'] ?? null,
                    "isPurchaseAccept" => $data['isPurchaseAccept'] ?? null,
                    "isStockIOUpdate" => $data['isStockIOUpdate'] ?? null,
                    "mapping" => $data['mapping'] ?? null,
                    "creditNoteItemsList" => $apiCreditNoteItemsList
                ];

                Log::info('FINAL API REQUEST DATA');
                Log::info($apiRequestData);

                $config = ConfigSettings::first();

                $url = $config->api_url . 'AddSaleCreditNoteV2';

                $response = Http::withOptions(['verify' => false])
                    ->withHeaders(['key' => $config->api_key])
                    ->post($url, $apiRequestData);

                Log::info('ADD SALE CREDIT NOTE API RESPONSE');
                Log::info($response);

                if ($response->status() != 200) {
                    $apiErrors = $response->json('message');
                    return redirect()->back()->with('error', $apiErrors);
                }

                $creditNoteCustomer = Customer::where('customerTin', $data['customerTin'])->first();
                if (!$creditNoteCustomer) {
                    throw new \Exception('Customer not found.');
                }

                $creditNote = CreditNote::create([
                    'invoice' => $id,
                    'orgInvoiceNo' => $invoice_id,
                    'customerTin' => $data['customerTin'] ?? null,
                    'customer' => $creditNoteCustomer->id,
                    'customerName' => $creditNoteCustomer->name,
                    'salesType' => $data['salesType'] ?? null,
                    'paymentType' => $data['paymentType'] ?? null,
                    'creditNoteReason' => $data['creditNoteReason'] ?? null,
                    'creditNoteDate' => $data['creditNoteDate'] ?? null,
                    'traderInvoiceNo' => $data['traderInvoiceNo'] ?? null,
                    'confirmDate' => $data['confirmDate'] ?? null,
                    'salesDate' => $data['salesDate'] ?? null,
                    'stockReleseDate' => $data['stockReleseDate'] ?? null,
                    'receiptPublishDate' => $data['receiptPublishDate'] ?? null,
                    'occurredDate' => $data['occurredDate'] ?? null,
                    'invoiceStatusCode' => $data['invoiceStatusCode'] ?? null,
                    'remark' => $data['remark'] ?? null,
                    'isPurchaseAccept' => $data['isPurchaseAccept'] ?? null,
                    'isStockIOUpdate' => $data['isStockIOUpdate'] ?? null,
                    'mapping' => $data['mapping'] ?? null,
                    'amount' => $totalAmount ?? null,
                    'response_invoiceNo' => $data['response_invoiceNo'] ?? null,
                    'response_tranderInvoiceNo' => $data['response_tranderInvoiceNo'] ?? null,
                    'response_scuInternalData' => $data['response_scuInternalData'] ?? null,
                    'response_scuReceiptSignature' => $data['response_scuReceiptSignature'] ?? null,
                    'response_sdcid' => $data['response_sdcid'] ?? null,
                    'response_sdcmrcNo' => $data['response_sdcmrcNo'] ?? null,
                    'response_sdcDateTime' => $data['response_sdcDateTime'] ?? null,
                    'response_scuqrCode' => $data['response_scuqrCode'] ?? null,
                    'response_isStockIOUpdate' => $data['response_isStockIOUpdate'] ?? null
                ]);

                $totAmt = 0;

                foreach ($apiCreditNoteItemsList as $item) {
                    $totalForEachProduct = ($item['unitPrice'] * $item['quantity'] * $item['pkgQuantity']) - $item['discountAmt'];
                    $totAmt += $totalForEachProduct;
                    CreditNoteItem::create([
                        'sales_credit_note_id' => $creditNote->id,
                        'itemCode' => $item['itemCode'] ?? null,
                        'itemClassCode' => $item['itemClassCode'] ?? null,
                        'itemTypeCode' => $item['itemTypeCode'] ?? null,
                        'itemName' => $item['itemName'] ?? null,
                        'orgnNatCd' => $item['orgnNatCd'] ?? null,
                        'taxTypeCode' => $item['taxTypeCode'] ?? null,
                        'unitPrice' => $item['unitPrice'] ?? null,
                        'isrcAplcbYn' => $item['isrcAplcbYn'] ?? null,
                        'pkgUnitCode' => $item['pkgUnitCode'] ?? null,
                        'pkgQuantity' => $item['pkgQuantity'] ?? null,
                        'qtyUnitCd' => $item['qtyUnitCd'] ?? null,
                        'quantity' => $item['quantity'] ?? null,
                        'discountRate' => $item['discountRate'] ?? null,
                        'discountAmt' => $item['discountAmt'] ?? null,
                        'itemExprDate' => $item['itemExprDate'] ?? null,
                    ]);
                }

                Utility::updateUserBalance('customer', $invoice->customer_id, $totAmt, 'debit');

                return redirect()->to('credit-note')->with('success', __('Credit Note successfully created.'));
            } else {
                return redirect()->back()->with('error', 'Permission denied.');
            }
        } catch (\Exception $e) {
            Log::info('STORE CREDIT NOTE ERROR');
            Log::info($e);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($invoice_id, $creditNote_id)
    {
        if (
            Auth::user()->type == 'accountant'
            || Auth::user()->type == 'company'
        ) {

            $creditNote = CreditNote::find($creditNote_id);

            return view('creditNote.edit', compact('creditNote'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, $invoice_id, $creditNote_id)
    {

        if (
            Auth::user()->type == 'accountant'
            || Auth::user()->type == 'company'
        ) {

            $validator = Validator::make(
                $request->all(),
                [
                    'amount' => 'required|numeric',
                    'date' => 'required',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $invoiceDue = Invoice::where('id', $invoice_id)->first();
            $credit = CreditNote::find($creditNote_id);
            if ($request->amount > $invoiceDue->getDue() + $credit->amount) {
                return redirect()->back()->with('error', 'Maximum ' . Auth::user()->priceFormat($invoiceDue->getDue()) . ' credit limit of this invoice.');
            }


            Utility::updateUserBalance('customer', $invoiceDue->customer_id, $credit->amount, 'credit');

            $credit->date = $request->date;
            $credit->amount = $request->amount;
            $credit->description = $request->description;
            $credit->save();

            Utility::updateUserBalance('customer', $invoiceDue->customer_id, $request->amount, 'debit');


            return redirect()->back()->with('success', __('Credit Note successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show($ids)
    {
        if (in_array(Auth::user()->type, ['company', 'accountant', 'customer'])) {
            try {
                $id = Crypt::decrypt($ids);
            } catch (\Throwable $th) {
                return redirect()->back()->with('error', __('Credit Note Not Found.'));
            }

            $creditNote = CreditNote::with('customer')->findOrFail($id);

            // Retrieve associated credit note items
            $creditNoteItems = CreditNoteItem::where('sales_credit_note_id', $creditNote->id)->get();

            if ($creditNote->created_by == Auth::user()->creatorId()) {
                $creditNoteInvoice = Invoice::where('response_trderInvoiceNo', $creditNote->traderInvoiceNo)->first();

                // $customer = $creditNote->customer;
                $customer = Customer::find($creditNote->customer);

                \Log::info('Customer Details for this credit note is : ');
                \Log::info($customer);

                $user = Auth::user();

                // Start for storage limit note
                $creditNoteUser = User::find($creditNote->created_by);
                $userPlan = Plan::getPlan($creditNoteUser->plan);
                // End for storage limit note

                $creditNote->customField = CustomField::getData($creditNote, 'invoice');
                $customFields = CustomField::where('created_by', Auth::user()->creatorId())->where('module', 'invoice')->get();

                return view('creditNote.view', compact('creditNote', 'customer', 'creditNoteItems', 'customFields', 'user', 'userPlan', 'creditNoteUser', 'creditNoteInvoice'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }



    public function destroy($invoice_id, $creditNote_id)
    {
        if (
            Auth::user()->type == 'accountant'
            || Auth::user()->type == 'company'
        ) {

            $creditNote = CreditNote::find($creditNote_id);
            $creditNote->delete();

            Utility::updateUserBalance('customer', $creditNote->customer, $creditNote->amount, 'credit');

            return redirect()->back()->with('success', __('Credit Note successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function customCreate()
    {
        if (
            Auth::user()->type == 'accountant'
            || Auth::user()->type == 'company'
        ) {

            $invoices = Invoice::where('created_by', Auth::user()->creatorId())->get()->pluck('invoice_id', 'id');

            $customer = Customer::all()->pluck('customerName', 'id');
            $invoices = Invoice::all()->pluck('response_invoiceNo', 'id');
            $creditNoteReasons = CreditNoteReason::all()->pluck('reason', 'reason');
            $salesTypeCodes = SalesTypeCode::all()->pluck('saleTypeCode', 'saleTypeCode');
            $paymentTypeCodes = PaymentTypeCodes::all()->pluck('payment_type_code', 'payment_type_code');
            $invoiceStatusCodes = InvoiceStatusCode::all()->pluck('invoiceStatusCode', 'invoiceStatusCode');
            $product_services = ProductService::get()->pluck('itemNm', 'id');
            $product_services_Codes = ProductService::get()->pluck('itemNm', 'itemCd');
            $product_services_Codes->prepend('--', '');
            $product_services->prepend('--', '');

            return view(
                'creditNote.custom_create',
                compact(
                    'invoices',
                    'creditNoteReasons',
                    'salesTypeCodes',
                    'product_services_Codes',
                    'paymentTypeCodes',
                    'invoiceStatusCodes',
                    'customer'
                )
            );
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // public function customStore(Request $request)
    // {
    //     if (Auth::user()->can('create credit note')) {
    //         $validator = Validator::make(
    //             $request->all(),
    //             [
    //                 'invoice' => 'required|numeric',
    //                 'amount' => 'required|numeric',
    //                 'date' => 'required',
    //             ]
    //         );
    //         if ($validator->fails()) {
    //             $messages = $validator->getMessageBag();

    //             return redirect()->back()->with('error', $messages->first());
    //         }
    //         $invoice_id = $request->invoice;
    //         $invoiceDue = Invoice::where('id', $invoice_id)->first();

    //         if ($request->amount > $invoiceDue->getDue()) {
    //             return redirect()->back()->with('error', 'Maximum ' . Auth::user()->priceFormat($invoiceDue->getDue()) . ' credit limit of this invoice.');
    //         }
    //         $invoice = Invoice::where('id', $invoice_id)->first();
    //         $credit = new CreditNote();
    //         $credit->invoice = $invoice_id;
    //         $credit->customer = $invoice->customer_id;
    //         $credit->date = $request->date;
    //         $credit->amount = $request->amount;
    //         $credit->description = $request->description;
    //         $credit->save();

    //         Utility::updateUserBalance('customer', $invoice->customer_id, $request->amount, 'debit');



    //         return redirect()->back()->with('success', __('Credit Note successfully created.'));
    //     } else {
    //         return redirect()->back()->with('error', __('Permission denied.'));
    //     }
    // }


    public function customStore(Request $request)
    {
        try {
            Log::info('Raw Data from the Add Direct Credit Note form:', $request->all());

            if (
                Auth::user()->type == 'accountant'
                || Auth::user()->type == 'company'
            ) {

                $data = $request->all();

                $selectedInvoice = Invoice::findOrFail($data['invoice']);

                Log::info('Adding A Direct CREDIT NOTE REQUEST Form  DATA');
                Log::info($data);

                $validator = Validator::make(
                    $data,
                    [
                        "customerName" => 'required',
                        "customerTin" => 'required',
                        "invoice" => 'required',
                        "orgInvoiceNo" => 'required',
                        "traderInvoiceNo" => 'required',
                        "salesType" => 'required',
                        "paymentType" => 'required',

                        "creditNoteDate" => 'required',

                        "confirmDate" => 'required',

                        "salesDate" => 'required',

                        "stockReleseDate" => 'required',

                        "receiptPublishDate" => 'required',

                        "occurredDate" => 'required',

                        "creditNoteReason" => 'required',
                        "invoiceStatusCode" => 'required',
                        "isPurchaseAccept" => 'required',
                        "remark" => 'required',
                        "isStockIOUpdate" => 'required',
                        "mapping" => 'required',
                        "amount" => 'required',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                $creditNoteDate = str_replace('-', '', $data['creditNoteDate']);
                $creditNoteDate = date('Ymd', strtotime($creditNoteDate));

                $confirmDate = str_replace('-', '', $data['confirmDate']);
                $confirmDate = date('Ymd', strtotime($confirmDate));


                $salesDate = str_replace('-', '', $data['salesDate']);
                $salesDate = date('Ymd', strtotime($salesDate));

                $stockReleseDate = str_replace('-', '', $data['stockReleseDate']);
                $stockReleseDate = date('Ymd', strtotime($stockReleseDate));


                $receiptPublishDate = str_replace('-', '', $data['receiptPublishDate']);
                $receiptPublishDate = date('Ymd', strtotime($receiptPublishDate));


                $occurredDate = str_replace('-', '', $data['occurredDate']);
                $occurredDate = date('Ymd', strtotime($occurredDate));

                $apiDirectCreditNoteItemsList = [];
                $localDirectCreditNoteItemsList = [];
                $totalAmount = 0;

                foreach ($data['items'] as $item) {
                    // Use $item['item'] to access the 'item' key within each item
                    $givenItem = ProductService::where('itemCd', $item['itemCode'])->first();

                    $itemExprDate = str_replace('-', '', $item['itemExprDate']);
                    $itemExprDate = date('Ymd', strtotime($itemExprDate));

                    $totalForEachProduct = ($item['unitPrice'] * $item['quantity'] * $item['pkgQuantity']) - $item['discountAmt'];
                    $totalAmount += $totalForEachProduct;

                    $apiItemData = [
                        'itemCode' => $item['itemCode'],
                        "unitPrice" => $item['unitPrice'],
                        "quantity" => $item['quantity'],
                    ];

                    $localDbItemData = [
                        'itemCode' => $item['itemCode'],
                        'itemClassCode' => $givenItem['itemClsCd'],
                        "itemTypeCode" => $givenItem['itemTyCd'],
                        "itemName" => $givenItem['itemNm'],
                        "orgnNatCd" => $givenItem['orgnNatCd'],
                        "taxTypeCode" => $givenItem['taxTyCd'],
                        "unitPrice" => $item['unitPrice'],
                        "isrcAplcbYn" => $givenItem['isrcAplcbYn'],
                        "pkgUnitCode" => $givenItem['pkgUnitCd'],
                        "pkgQuantity" => $item['pkgQuantity'],
                        "qtyUnitCd" => $givenItem['qtyUnitCd'],
                        "quantity" => $item['quantity'],
                        "discountRate" => $item['discountRate'],
                        "discountAmt" => $item['discountAmt'],
                        'itemExprDate' => $itemExprDate
                    ];

                    array_push($apiDirectCreditNoteItemsList, $apiItemData);
                    array_push($localDirectCreditNoteItemsList, $localDbItemData);
                }

                $apiRequestData = [
                    'orgInvoiceNo' => $data['orgInvoiceNo'],
                    'traderInvoiceNo' => $data['traderInvoiceNo'],
                    'salesType' => $data['salesType'] ?? null,
                    'paymentType' => $data['paymentType'] ?? null,
                    'creditNoteDate' => $data['creditNoteDate'] ?? null,
                    'confirmDate' => $data['confirmDate'],
                    'salesDate' => $salesDate,
                    'stockReleseDate' => $data['stockReleseDate'] ?? null,
                    'receiptPublishDate' => $data['receiptPublishDate'],
                    'occurredDate' => $occurredDate,
                    'creditNoteReason' => $data['creditNoteReason'],
                    "invoiceStatusCode" => $data['invoiceStatusCode'] ?? null,
                    "isPurchaseAccept" => $data['isPurchaseAccept'] ?? null,
                    "remark" => $data['remark'] ?? null,
                    "isStockIOUpdate" => $data['isStockIOUpdate'] ?? null,
                    "mapping" => $data['mapping'] ?? null,
                    "directCreditNoteItemsList" => $apiDirectCreditNoteItemsList
                ];

                Log::info('FINAL API REQUEST DATA');
                Log::info($apiRequestData);

                $config = ConfigSettings::first();

                $url = $config->api_url . 'AddSaleCreditNoteV2';

                $response = Http::withOptions([
                    'verify' => false
                ])->withHeaders([
                    'key' => $config->api_key
                ])->post($url, $apiRequestData);

                Log::info('ADD SALE CREDIT NOTE API RESPONSE');
                Log::info($response);

                if ($response['statusCode'] == 400) {
                    return redirect()->back()->with('error', $response['message']);
                }

                $creditNoteCustomer = Customer::where('customerTin', $data['customerTin'])->first();
                $creditNote = CreditNote::create([
                    'invoice' => $data['invoice'],
                    'orgInvoiceNo' => $data['orgInvoiceNo'],
                    'customerTin' => $data['customerTin'] ?? null,
                    'customer' => $creditNoteCustomer->id,
                    'customerName' => $creditNoteCustomer->name,
                    'salesType' => $data['salesType'] ?? null,
                    'paymentType' => $data['paymentType'] ?? null,
                    'creditNoteReason' => $data['creditNoteReason'] ?? null,
                    'creditNoteDate' => $data['creditNoteDate'] ?? null,
                    'traderInvoiceNo' => $data['traderInvoiceNo'] ?? null,
                    'confirmDate' => $data['confirmDate'] ?? null,
                    'salesDate' => $data['salesDate'] ?? null,
                    'stockReleseDate' => $data['stockReleseDate'] ?? null,
                    'receiptPublishDate' => $data['receiptPublishDate'] ?? null,
                    'occurredDate' => $data['occurredDate'] ?? null,
                    'invoiceStatusCode' => $data['invoiceStatusCode'] ?? null,
                    'remark' => $data['remark'] ?? null,
                    'isPurchaseAccept' => $data['isPurchaseAccept'] ?? null,
                    'isStockIOUpdate' => $data['isStockIOUpdate'] ?? null,
                    'mapping' => $data['mapping'] ?? null,
                    'amount' => $totalAmount ?? null,
                    'response_invoiceNo' => $data['response_invoiceNo'] ?? null,
                    'response_tranderInvoiceNo' => $data['response_tranderInvoiceNo'] ?? null,
                    'response_scuInternalData' => $data['response_scuInternalData'] ?? null,
                    'response_scuReceiptSignature' => $data['response_scuReceiptSignature'] ?? null,
                    'response_sdcid' => $data['response_sdcid'] ?? null,
                    'response_sdcmrcNo' => $data['response_sdcmrcNo'] ?? null,
                    'response_sdcDateTime' => $data['response_sdcDateTime'] ?? null,
                    'response_scuqrCode' => $data['response_scuqrCode'] ?? null,
                    'response_isStockIOUpdate' => $data['response_isStockIOUpdate'] ?? null
                ]);

                $totAmt = 0;

                foreach ($localDirectCreditNoteItemsList as $item) {

                    $totalForEachProduct = ($item['unitPrice'] * $item['quantity'] * $item['pkgQuantity']) - $item['discountAmt'];
                    $totAmt += $totalForEachProduct;
                    CreditNoteItem::create([
                        'sales_credit_note_id' => $creditNote->id,
                        'itemCode' => $item['itemCode'] ?? null,
                        'itemClassCode' => $item['itemClassCode'] ?? null,
                        'itemTypeCode' => $item['itemTypeCode'] ?? null,
                        'itemName' => $item['itemName'] ?? null,
                        'orgnNatCd' => $item['orgnNatCd'] ?? null,
                        'taxTypeCode' => $item['taxTypeCode'] ?? null,
                        'unitPrice' => $item['unitPrice'] ?? null,
                        'isrcAplcbYn' => $item['isrcAplcbYn'] ?? null,
                        'pkgUnitCode' => $item['pkgUnitCode'] ?? null,
                        'pkgQuantity' => $item['pkgQuantity'] ?? null,
                        'qtyUnitCd' => $item['qtyUnitCd'] ?? null,
                        'quantity' => $item['quantity'] ?? null,
                        'discountRate' => $item['discountRate'] ?? null,
                        'discountAmt' => $item['discountAmt'] ?? null,
                        'itemExprDate' => $item['itemExprDate'] ?? null,
                    ]);
                }

                Utility::updateUserBalance('customer', $selectedInvoice->customer_id, $totAmt, 'debit');

                return redirect()->to('credit-note')->with('success', __('Credit Note successfully created.'));
            } else {
                return redirect()->back()->with('error', 'Permission denied.');
            }
        } catch (\Exception $e) {
            Log::info('STORE CREDIT NOTE ERROR');
            Log::info($e);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function getinvoice(Request $request)
    {
        $invoice = Invoice::where('id', $request->id)->first();

        echo json_encode($invoice->getDue());
    }

    public function getItemsToAddDirectCreditNote(Request $request)
    {
        // Fetch item information based on the item code
        $itemCd = $request->input('itemCode');
        $itemInfo['data'] = ProductService::where('itemCd', $itemCd)->first();

        if ($itemInfo['data']) {
            // Return item information as JSON response
            return response()->json($itemInfo);
        } else {
            // If item information not found, return empty response
            return response()->json([]);
        }
    }
    public function getCustomerDetailsToAddDirectCreditNote(Request $request)
    {
        // Fetch Customer information based on the item code
        $customerId = $request->input('customer');

        Log::info('Customer Id: ' . $customerId);

        $customerInfo['data'] = Customer::where('id', $customerId)->first();

        if ($customerInfo['data']) {
            // Return Customer information as JSON response
            return response()->json($customerInfo);
        } else {
            // If customer information not found, return empty response
            return response()->json([]);
        }
    }
}