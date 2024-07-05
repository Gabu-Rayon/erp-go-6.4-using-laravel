<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Invoice;
use App\Models\Utility;
use App\Models\Customer;
use App\Models\CreditNote;
use Illuminate\Http\Request;
use App\Models\SalesTypeCode;
use App\Models\CreditNoteItem;
use App\Models\ProductService;
use App\Models\CreditNoteReason;
use App\Models\PaymentTypeCodes;
use App\Models\InvoiceStatusCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

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


            $invoiceDue = Invoice::where('id', $invoice_id)->first();
            Log::info('INVOICE');
            Log::info($invoiceDue);
            $customer = Customer::find($invoiceDue->customer_id);
            $itemsToAdd = ProductService::all()->pluck('itemNm', 'itemCd');
            $creditNoteReasons = CreditNoteReason::all()->pluck('reason', 'code');
            $salesTypeCodes = SalesTypeCode::all()->pluck('saleTypeCode', 'code');
            $paymentTypeCodes = PaymentTypeCodes::all()->pluck('payment_type_code', 'id');
            $invoiceStatusCodes = InvoiceStatusCode::all()->pluck('invoiceStatusCode', 'code');

            return view(
                'creditNote.create',
                compact(
                    'invoiceDue',
                    'invoice_id',
                    'creditNoteReasons',
                    'salesTypeCodes',
                    'paymentTypeCodes',
                    'invoiceStatusCodes',
                    'customer',
                    'itemsToAdd'
                )
            );
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function store(Request $request, $id)
    {
        try {

            $data = $request->all();
            
            Log::info("Data from Credit Note Form : ");
            Log::info($data);

            $validator = Validator::make($data, [
                'invoiceNo' => 'required',
                'customerID' => 'required|numeric',
                'salesType' => 'nullable|string|min:1|max:2|exists:sales_type_codes,code',
                'paymentType' => 'nullable|string|min:1|max:1|exists:payment_types_code,id',
                'invoiceStatusCode' => 'required|string|min:2|max:2|exists:invoice_status_codes,id',
                'isPurchaseAccept' => 'nullable|boolean',
                'traderInvoiceNo' => 'required|string|min:1|max:50',
                'confirmDate' => 'required|date',
                'salesDate' => 'required|date',
                'stockReleseDate' => 'nullable|date',
                'receiptPublishDate' => 'required|date',
                'occurredDate' => 'required|date',
                'creditNoteDate' => 'nullable|date',
                'creditNoteReason' => 'required|string|min:2|max:2|exists:credit_note_reasons,code',
                'remark' => 'nullable|string',
                'items' => 'required|array',
                'items.*.product_id' => 'required|numeric|exists:product_services,id',
                'items.*.unitPrice' => 'required|numeric',
                'items.*.quantity' => 'required|numeric',
                'items.*.pkgQuantity' => 'required|numeric',
                'items.*.discountRate' => 'required|numeric',
                'items.*.discountAmt' => 'required|numeric',
            ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR');
                Log::info($validator->errors());
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $creditNoteDate = $data['creditNoteDate'] ? date('YmdHis', strtotime($data['creditNoteDate'])) : null;
            $confirmDate = date('YmdHis', strtotime($data['confirmDate']));
            $salesDate = date('Ymd', strtotime($data['salesDate']));
            $stockReleseDate = $data['stockReleseDate'] ? date('YmdHis', strtotime($data['stockReleseDate'])) : null;
            $receiptPublishDate = date('YmdHis', strtotime($data['receiptPublishDate']));
            $occurredDate = date('Ymd', strtotime($data['occurredDate']));

            $customer = Customer::find($data['customerID']);
            $invoice = Invoice::where('id', $id)->first();

            $firstUrl = 'https://etims.your-apps.biz/api/GetSalesByTraderInvoiceNo';

            $apiinvoice = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                        'key' => '123456'
                    ])->get($firstUrl, [
                        'traderInvoiceNo' => $invoice['response_trderInvoiceNo']
                    ]);

            Log::info('API INVOICE');
            Log::info($apiinvoice);

            $apiData = [
                'orgInvoiceNo' => $apiinvoice['invoiceNo'],
                'customerTin' => $customer->customerTin,
                'customerName' => $customer->name,
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
                'invoiceStatusCode' => $data['invoiceStatusCode'],
                'remark' => $data['remark'] ?? null,
                'isPurchaseAccept' => $data['isPurchaseAccept'] ? true : false,
                'isStockIOUpdate' => true,
                'mapping' => null,
            ];

            $creditNoteItemsList = [];
            $totAmt = 0;

            foreach ($data['items'] as $item) {
                $itemFromDB = ProductService::where('id', $item['product_id'])->first();
                
                 Log::info("Item Hapa");
                 
                 Log::info($itemFromDB);
                 
                $creditNoteItem = [
                    'itemCode' => $itemFromDB->itemCd,
                    'itemClassCode' => $itemFromDB->itemClsCd,
                    'itemTypeCode' => $itemFromDB->itemTyCd,
                    'itemName' => $itemFromDB->itemNm,
                    'orgnNatCd' => $itemFromDB->orgnNatCd,
                    'taxTypeCode' => $itemFromDB->taxTyCd,
                    'unitPrice' => $item['unitPrice'],
                    'isrcAplcbYn' => $itemFromDB->isrcAplcbYn ? true : false,
                    'pkgUnitCode' => $itemFromDB->pkgUnitCd,
                    'pkgQuantity' => $item['pkgQuantity'],
                    'qtyUnitCd' => $itemFromDB->qtyUnitCd,
                    'quantity' => $item['quantity'],
                    'discountRate' => $item['discountRate'],
                    'discountAmt' => $item['discountAmt'],
                    'itemExprDate' => $itemFromDB->itemExprDate ? date('Ymd', strtotime($itemFromDB->itemExprDate)) : null,
                ];

                $totalForEachProduct = ($item['unitPrice'] * $item['quantity'] * $item['pkgQuantity']) - $item['discountAmt'];
                $totAmt += $totalForEachProduct;

                $creditNoteItemsList[] = $creditNoteItem;
            }

            $apiData['directCreditNoteItemsList'] = $creditNoteItemsList;

            Log::info('DATA');
            Log::info($apiData);

            $url = 'https://etims.your-apps.biz/api/AddSaleCreditNote';

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                        'key' => '123456'
                    ])->post($url, $apiData);

            Log::info('API RESPONSE');
            Log::info($response);

            if ($response['statusCode'] != 200) {
                return redirect()->back()->with('error', $response['message']);
            }

            $creditNote = CreditNote::create([
                'invoice' => $id,
                'orgInvoiceNo' => $data['orgInvoiceNo'],
                'customerTin' => $customer->customerTin,
                'customer' => $customer->id,
                'customerName' => $customer->name,
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
                'isStockIOUpdate' => true,
                'mapping' => $data['mapping'] ?? null,
                'amount' => $totAmt ?? null,
                'response_invoiceNo' => $data['orgInvoiceNo'] ?? null,
                'response_tranderInvoiceNo' => $data['response_tranderInvoiceNo'] ?? null,
                'response_scuInternalData' => $data['response_scuInternalData'] ?? null,
                'response_scuReceiptSignature' => $data['response_scuReceiptSignature'] ?? null,
                'response_sdcid' => $data['response_sdcid'] ?? null,
                'response_sdcmrcNo' => $data['response_sdcmrcNo'] ?? null,
                'response_sdcDateTime' => $data['response_sdcDateTime'] ?? null,
                'response_scuqrCode' => $data['response_scuqrCode'] ?? null,
                'response_isStockIOUpdate' => $data['response_isStockIOUpdate'] ?? null
            ]);

            foreach ($creditNoteItemsList as $item) {
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

            return redirect()->to('credit-note')->with('success', __('Credit Note successfully created.'));
        } catch (Exception $e) {
            Log::error('STORE CREDIT NOTE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Error occurred while adding Credit Note.');
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

            $customers = Customer::all()->pluck('name', 'customerTin');
            $invoices = Invoice::all()->pluck('invoiceNo', 'id');
            $creditNoteReasons = CreditNoteReason::all()->pluck('reason', 'code');
            $salesTypeCodes = SalesTypeCode::all()->pluck('saleTypeCode', 'code');
            $paymentTypeCodes = PaymentTypeCodes::all()->pluck('payment_type_code', 'code');
            $invoiceStatusCodes = InvoiceStatusCode::all()->pluck('invoiceStatusCode', 'code');
            $product_services = ProductService::get()->pluck('itemNm', 'itemCd');
            $product_services->prepend('Select Item', '');

            return view(
                'creditNote.custom_create',
                compact(
                    'invoices',
                    'creditNoteReasons',
                    'salesTypeCodes',
                    'product_services',
                    'paymentTypeCodes',
                    'invoiceStatusCodes',
                    'customers'
                )
            );
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    // public function customStore(Request $request)
    // {
    //     if (\Auth::user()->can('create credit note')) {
    //         $validator = \Validator::make(
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
    //             return redirect()->back()->with('error', 'Maximum ' . \Auth::user()->priceFormat($invoiceDue->getDue()) . ' credit limit of this invoice.');
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

        if (
            Auth::user()->type == 'accountant'
            || Auth::user()->type == 'company'
        ) {

            $data = $request->all();

            $validator = Validator::make(
                $data,
                [
                    "orgInvoiceNo" => "required|numeric",
                    "customer" => "required|string|min:1|max:11",
                    "traderInvoiceNo" => "required|string|min:1|max:50",
                    "salesType" => "nullable|string|min:1|max:2|exists:sales_type_codes,code",
                    "paymentType" => "nullable|string|min:2|max:2|exists:payment_types_code,code",
                    "creditNoteDate" => "nullable|date",
                    "confirmDate" => "required|date",
                    "salesDate" => "required|date",
                    "stockReleseDate" => "nullable|date",
                    "receiptPublishDate" => "required|date",
                    "occurredDate" => "required|date",
                    "creditNoteReason" => "required|string|min:2|max:2|exists:credit_note_reasons,code",
                    "invoiceStatusCode" => "nullable|string|min:2|max:2|exists:invoice_status_codes,code",
                    "isPurchaseAccept" => "nullable|boolean",
                    "remark" => "nullable|string",
                    "items" => "required|array",
                    "items.*.itemCode" => "required|string|min:1|exists:product_services,itemCd",
                    "items.*.unitPrice" => "required|numeric",
                    "items.*.quantity" => "required|numeric",
                ]
            );

            if ($validator->fails()) {
                Log::info('VALIDATION ERROR');
                Log::info($validator->errors());
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $invoice = Invoice::where('orgInvoiceNo', $data['orgInvoiceNo'])->first();

            if (!$invoice) {
                return redirect()->back()->with('error', 'Invoice not found.');
            }

            $apiDirectCreditNoteItemsList = [];
            $localDirectCreditNoteItemsList = [];
            $totalAmount = 0;

            foreach ($data['items'] as $item) {
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

            $salesDate = str_replace('-', '', $data['salesDate']);
            $salesDate = date('Ymd', strtotime($salesDate));

            $occurredDate = str_replace('-', '', $data['occurredDate']);
            $occurredDate = date('Ymd', strtotime($occurredDate));

            $confirmDate = str_replace('-', '', $data['confirmDate']);
            $confirmDate = date('YmdHis', strtotime($confirmDate));

            $receiptPublishDate = str_replace('-', '', $data['receiptPublishDate']);
            $receiptPublishDate = date('YmdHis', strtotime($receiptPublishDate));

            $apiRequestData = [
                'orgInvoiceNo' => $data['orgInvoiceNo'],
                'traderInvoiceNo' => $data['traderInvoiceNo'],
                'salesType' => $data['salesType'] ?? null,
                'paymentType' => $data['paymentType'] ?? null,
                'creditNoteDate' => $data['creditNoteDate'] ?? null,
                'confirmDate' => $confirmDate,
                'salesDate' => $salesDate,
                'stockReleseDate' => $data['stockReleseDate'] ?? null,
                'receiptPublishDate' => $receiptPublishDate,
                'occurredDate' => $occurredDate,
                'creditNoteReason' => $data['creditNoteReason'],
                "invoiceStatusCode" => $data['invoiceStatusCode'] ?? null,
                "isPurchaseAccept" => $data['isPurchaseAccept'] ? true : false,
                "remark" => $data['remark'] ?? null,
                "isStockIOUpdate" => $data['isStockIOUpdate'] ?? null,
                "mapping" => $data['mapping'] ?? null,
                "directCreditNoteItemsList" => $apiDirectCreditNoteItemsList
            ];

            Log::info('FINAL API REQUEST DATA');
            Log::info($apiRequestData);

            $url = 'https://etims.your-apps.biz/api/AddDirectCreditNote';

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                        'key' => '123456'
                    ])->post($url, $apiRequestData);

            Log::info('ADD SALE CREDIT NOTE API RESPONSE');
            Log::info($response);

            if ($response['statusCode'] == 400) {
                return redirect()->back()->with('error', $response['message']);
            }

            $creditNoteCustomer = Customer::where('customerTin', $data['customer'])->first();


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

            Utility::updateUserBalance('customer', $invoice->customer_id, $totAmt, 'debit');

            return redirect()->to('credit-note')->with('success', __('Credit Note successfully created.'));

        } else {
            return redirect()->back()->with('error', 'Permission denied.');
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