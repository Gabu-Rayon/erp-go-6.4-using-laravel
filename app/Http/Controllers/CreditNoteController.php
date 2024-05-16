<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Utility;
use App\Models\CreditNote;
use App\Models\CreditNoteItem;
use Illuminate\Http\Request;
use App\Models\SalesTypeCode;
use App\Models\ItemInformation;
use App\Models\CreditNoteReason;
use App\Models\PaymentTypeCodes;
use App\Models\InvoiceStatusCode;
use App\Models\Customer;

class CreditNoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {

        if (\Auth::user()->can('manage credit note')) {
            $invoices = Invoice::where('created_by', \Auth::user()->creatorId())->get();

            return view('creditNote.index', compact('invoices'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create($invoice_id)
    {

        if (\Auth::user()->can('create credit note')) {


            $invoiceDue = Invoice::where('id', $invoice_id)->first();
            // Retrieve customer details
            $customer = Customer::find($invoiceDue->customer_id);
            $customers = Customer::find($invoiceDue->customer_id);
            $items = ItemInformation::all();
            $creditNoteReasons = CreditNoteReason::all()->pluck('reason', 'reason');
            $salesTypeCodes = SalesTypeCode::all()->pluck('saleTypeValue', 'saleTypeCode');
            $paymentTypeCodes = PaymentTypeCodes::all()->pluck('payment_type_code', 'id');
            $invoiceStatusCodes = InvoiceStatusCode::all()->pluck('invoiceStatusValue', 'invoiceStatusCode');

            return view('creditNote.create', compact(
                'invoiceDue',
                'invoice_id',
                'customers',
                'creditNoteReasons',
                'salesTypeCodes',
                'paymentTypeCodes',
                'invoiceStatusCodes'
            ,'customer'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function store(Request $request, $invoice_id)
    {

        if(\Auth::user()->can('create credit note'))
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'amount' => 'required|numeric',
                                   'date' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            $invoiceDue = Invoice::where('id', $invoice_id)->first();
            if($request->amount > $invoiceDue->getDue())
            {
                return redirect()->back()->with('error', 'Maximum ' . \Auth::user()->priceFormat($invoiceDue->getDue()) . ' credit limit of this invoice.');
            }
            $invoice = Invoice::where('id', $invoice_id)->first();

            $credit              = new CreditNote();
            $credit->invoice     = $invoice_id;
            $credit->customer    = $invoice->customer_id;
            $credit->date        = $request->date;
            $credit->amount      = $request->amount;
            $credit->description = $request->description;
            $credit->save();

            Utility::updateUserBalance('customer', $invoice->customer_id, $request->amount, 'debit');

            return redirect()->back()->with('success', __('Credit Note successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function edit($invoice_id, $creditNote_id)
    {
        if (\Auth::user()->can('edit credit note')) {

            $creditNote = CreditNote::find($creditNote_id);

            return view('creditNote.edit', compact('creditNote'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, $invoice_id, $creditNote_id)
    {

        if (\Auth::user()->can('edit credit note')) {

            $validator = \Validator::make(
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
                return redirect()->back()->with('error', 'Maximum ' . \Auth::user()->priceFormat($invoiceDue->getDue()) . ' credit limit of this invoice.');
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
        if (\Auth::user()->can('delete credit note')) {

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
        if (\Auth::user()->can('create credit note')) {

            $invoices = Invoice::where('created_by', \Auth::user()->creatorId())->get()->pluck('invoice_id', 'id');

            // Retrieve customer details
            $customer = Customer::all();
            $creditNoteReasons = CreditNoteReason::all()->pluck('reason', 'reason');
            $salesTypeCodes = SalesTypeCode::all()->pluck('saleTypeCode', 'saleTypeCode');
            $paymentTypeCodes = PaymentTypeCodes::all()->pluck('payment_type_code', 'payment_type_code');
            $invoiceStatusCodes = InvoiceStatusCode::all()->pluck('invoiceStatusCode', 'invoiceStatusCode');
            $product_services_Codes = ItemInformation::get()->pluck('itemNm', 'itemCd');
            $product_services_Codes->prepend('--', '');

            return view('creditNote.custom_create', compact(
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
    //     if(\Auth::user()->can('create credit note'))
    //     {
    //         $validator = \Validator::make(
    //             $request->all(), [
    //                                'invoice' => 'required|numeric',
    //                                'amount' => 'required|numeric',
    //                                'date' => 'required',
    //                            ]
    //         );
    //         if($validator->fails())
    //         {
    //             $messages = $validator->getMessageBag();

    //             return redirect()->back()->with('error', $messages->first());
    //         }
    //         $invoice_id = $request->invoice;
    //         $invoiceDue = Invoice::where('id', $invoice_id)->first();

    //         if($request->amount > $invoiceDue->getDue())
    //         {
    //             return redirect()->back()->with('error', 'Maximum ' . \Auth::user()->priceFormat($invoiceDue->getDue()) . ' credit limit of this invoice.');
    //         }
    //         $invoice             = Invoice::where('id', $invoice_id)->first();
    //         $credit              = new CreditNote();
    //         $credit->invoice     = $invoice_id;
    //         $credit->customer    = $invoice->customer_id;
    //         $credit->date        = $request->date;
    //         $credit->amount      = $request->amount;
    //         $credit->description = $request->description;
    //         $credit->save();

    //         Utility::updateUserBalance('customer', $invoice->customer_id, $request->amount, 'debit');



    //         return redirect()->back()->with('success', __('Credit Note successfully created.'));
    //     }
    //     else
    //     {
    //         return redirect()->back()->with('error', __('Permission denied.'));
    //     }
    // }



    public function customStore(Request $request)
    {


        try {
            // Log the entire request data
            \Log::info('Form data received:', $request->all());

            // function calculateDiscountAmount($packageQuantity, $quantity, $unitPrice, $discountRate)
            // {
            //     $totalItems = $packageQuantity * $quantity;
            //     $totalPriceBeforeDiscount = $totalItems * $unitPrice;
            //     $discountAmount = ($totalPriceBeforeDiscount * $discountRate) / 100;
            //     return $discountAmount;
            // }

            // function calculateTotalAmount($packageQuantity, $quantity, $unitPrice)
            // {
            //     $totalItems = $packageQuantity * $quantity;
            //     $totalPriceBeforeDiscount = $totalItems * $unitPrice;
            //     return $totalPriceBeforeDiscount;
            // }

            // function getTaxRate($taxTyCd)
            // {
            //     switch ($taxTyCd) {
            //         case 'B':
            //             return 16; // 16% tax rate for code B
            //         case 'E':
            //             return 8; // 8% tax rate for code E
            //         default:
            //             return 0; // Default tax rate if code not found
            //     }
            // }

            // // Function to get tax code based on tax type code
            // function getTaxCode($taxTyCd)
            // {
            //     switch ($taxTyCd) {
            //         case 'A':
            //             return 1;
            //         case 'B':
            //             return 2;
            //         case 'C':
            //             return 3;
            //         case 'D':
            //             return 4;
            //         case 'E':
            //             return 5;
            //         case 'F':
            //             return 6;
            //         default:
            //             return null; // Return null if tax type code not found
            //     }
            // }

            $validator = \Validator::make(
                $request->all(),
                [
                    'orgInvoiceNo' => 'required',
                    'customerName' => 'required',
                    'customerTin' => 'required',
                    'creditNoteReason' => 'required',
                    'creditNoteDate' => 'required',
                    'salesType' => 'required',
                    'paymentType' => 'required',
                    'traderInvoiceNo' => 'required',
                    'confirmDate' => 'required',
                    'salesDate' => 'required',
                    'stockReleseDate' => 'required',
                    'receiptPublishDate' => 'required',
                    'occurredDate' => 'required',
                    'invoiceStatusCode' => 'required',
                    'isPurchaseAccept' => 'required',
                    'isStockIOUpdate' => 'required',
                    'mapping' => 'required',
                    'remark' => 'required',
                    'amount' => 'reuqired',
                    'items' => 'required'
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $data = $request->all();

            $directCreditItemsList = [];
            $totTaxblAmt = 0;
            $totTaxAmt = 0;
            $totAmt = 0;

            foreach ($data['items'] as $item) {
                $itemDetails = ItemInformation::where('itemCd', $item['itemCode'])->first();
                $itemExprDt = str_replace('-', '', $item['itemExprDt']);
                $itemExprDate = date('Ymd', strtotime($itemExprDt));

                $discountAmt = calculateDiscountAmount(
                    $item['pkgQuantity'],
                    $item['quantity'],
                    $item['unitPrice'],
                    $item['discount']
                );

                // Calculate total amount before tax
                $totalAmountBeforeTax = calculateTotalAmount(
                    $item['pkgQuantity'],
                    $item['quantity'],
                    $item['unitPrice']
                ) - $discountAmt;

                // Get tax rate based on tax type code
                $taxRate = getTaxRate($itemDetails->taxTyCd);

                // Calculate item tax amount
                $itemTaxAmount = ($taxRate / 100) * $totalAmountBeforeTax;
                $totTaxAmt += $itemTaxAmount;

                // Calculate taxable amount
                $taxableAmount = $totalAmountBeforeTax - $itemTaxAmount;
                $totTaxblAmt += $taxableAmount;

                $totalAmountForEachProduct = $taxableAmount - $itemTaxAmount;
                $totAmt += $totalAmountForEachProduct;


                $itemRequestData = [
                    "itemCode" => $item['itemCode'],
                    "supplrItemClsCode" => $item['supplrItemClsCode'],
                    "supplrItemCode" => $item['supplrItemCode'],
                    "supplrItemName" => $item['supplrItemName'],
                    "quantity" => $item['quantity'],
                    "unitPrice" => $item['unitPrice'],
                    "pkgQuantity" => $item['pkgQuantity'],
                    "discountRate" => $item['discount'],
                    "discountAmt" => $item['discountAmt'],
                    "itemExprDate" => $itemExprDate,
                ];

                $taxCode = getTaxCode($itemDetails->taxTyCd);

                $itemData = [
                    'product_id' => $itemDetails->id,
                    'quantity' => $item['quantity'],
                    'tax' => $taxCode,
                    'discount' => $item['discountAmt'],
                    'price' => $item['unitPrice'],
                    'description' => null,
                    'saleItemCode' => $data['supplierInvcNo'],
                    'itemSeq' => $itemDetails->itemSeq,
                    'itemCd' => $itemDetails->itemCd,
                    'itemClsCd' => $itemDetails->itemClsCd,
                    'itemNm' => $itemDetails->itemNm,
                    'bcd' => $itemDetails->bcd,
                    'supplrItemClsCd' => $itemDetails->supplrItemClsCd,
                    'supplrItemCd' => $itemDetails->supplrItemCls,
                    'supplrIteNm' => $itemDetails->supplrItemNm,
                    'pkgUnitCd' => $itemDetails->pkgUnitCd,
                    'pkg' => $itemDetails->pkg,
                    'qtyUnitCd' => $itemDetails->qtyUnitCd,
                    'qty' => $itemDetails->qty,
                    'prc' => $itemDetails->prc,
                    'splyAmt' => $itemDetails->splyAmt,
                    'dcAmt' => $item['discountAmt'],
                    'taxTyCd' => $itemDetails->taxTyCd,
                    'taxblAmt' => $itemTaxAmount,
                    'taxAmt' => $itemTaxAmount,
                    'totAmt' => $totalAmountForEachProduct,
                    'itemExprDt' => $itemExprDate,
                ];

                array_push($directCreditItemsList, $itemRequestData);
            }
            $url = 'https://etims.your-apps.biz/api/AddDirectCreditNote';

            $response = Http::withHeaders([
                'key' => '123456'
            ])->post($url, $data);

            \Log::info('SALES API RESPONSE');
            \Log::info($response);

            // CreditNote::create([
            //     'orgInvoiceNo' => $data['orgInvoiceNo'],
            //     'customerName' => $data['customerName'],
            //     'customerTin' => $data['customerTin'],
            //     'creditNoteReason' => $data['creditNoteReason'],
            //     'creditNoteDate' => $data['creditNoteDate'],
            //     'salesType' => $data['salesType'],
            //     'paymentType' => $data['paymentType'],
            //     'traderInvoiceNo' => $data['traderInvoiceNo'],
            //     'confirmDate' => $data['confirmDate'],
            //     'salesDate' => $data['salesDate'],
            //     'stockReleseDate' => $data['stockReleseDate'],
            //     'receiptPublishDate' => $data['receiptPublishDate'],
            //     'occurredDate' => $data['occurredDate'],
            //     'invoiceStatusCode' => $data['invoiceStatusCode'],
            //     'isPurchaseAccept' => $data['isPurchaseAccept'],
            //     'isStockIOUpdate' => $data['isStockIOUpdate'],
            //     'mapping' => $data['mapping'],
            //     'remark' => $data['remark']
            // ]);

            // $saleCreditNoteItems = $data['creditNoteItemsList'];

            // foreach ($saleCreditNoteItems as $saleCreditNoteItem) {
            //     CreditNoteItem::create([
            //         'sales_credit_note_id' => 'id',
            //         'itemCode' => $saleCreditNoteItem['itemCode'],
            //         'itemClassCode' => $saleCreditNoteItem['itemClassCode'],
            //         'itemTypeCode' => $saleCreditNoteItem['itemTypeCode'],
            //         'itemName' => $saleCreditNoteItem['itemName'],
            //         'orgnNatCd' => $saleCreditNoteItem['orgnNatCd'],
            //         'taxTypeCode' => $saleCreditNoteItem['taxTypeCode'],
            //         'unitPrice' => $saleCreditNoteItem['unitPrice'],
            //         'isrcAplcbYn' => $saleCreditNoteItem['isrcAplcbYn'],
            //         'pkgUnitCode' => $saleCreditNoteItem['pkgUnitCode'],
            //         'pkgQuantity' => $saleCreditNoteItem['pkgQuantity'],
            //         'qtyUnitCd' => $saleCreditNoteItem['qtyUnitCd'],
            //         'quantity' => $saleCreditNoteItem['quantity'],
            //         'discountRate' => $saleCreditNoteItem['discountRate'],
            //         'discountAmt' => $saleCreditNoteItem['discountAmt'],
            //         'itemExprDate' => $saleCreditNoteItem['itemExprDate'],
            //     ]);

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

    public function getinvoice(Request $request)
    {
        $invoice = Invoice::where('id', $request->id)->first();

        echo json_encode($invoice->getDue());
    }

    public function getItemsToAddDirectCreditNote(Request $request)
    {
        // Fetch item information based on the item code
        $itemCd = $request->input('itemCode');
        $itemInfo['data'] = ItemInformation::where('itemCd', $itemCd)->first();

        if ($itemInfo['data']) {
            // Return item information as JSON response
            return response()->json($itemInfo);
        } else {
            // If item information not found, return empty response
            return response()->json([]);
        }
    }

}