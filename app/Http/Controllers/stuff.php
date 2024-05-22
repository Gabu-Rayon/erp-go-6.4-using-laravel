<?php

   // public function store(Request $request){
    //     //        dd($request->all());
    //     if (\Auth::user()->can('create invoice')) {
    //         $validator = \Validator::make(
    //             $request->all(),
    //             [
    //                 'customer_id' => 'required',
    //                 'issue_date' => 'required',
    //                 'due_date' => 'required',
    //                 'category_id' => 'required',
    //                 'items' => 'required',
    //             ]
    //         );
    //         if ($validator->fails()) {
    //             $messages = $validator->getMessageBag();
    //             return redirect()->back()->with('error', $messages->first());
    //         }
    //         $status = Invoice::$statues;
    //         $invoice = new Invoice();
    //         $invoice->invoice_id = $this->invoiceNumber();
    //         $invoice->customer_id = $request->customer_id;
    //         $invoice->status = 0;
    //         $invoice->issue_date = $request->issue_date;
    //         $invoice->due_date = $request->due_date;
    //         $invoice->category_id = $request->category_id;
    //         $invoice->ref_number = $request->ref_number;
    //         //            $invoice->discount_apply = isset($request->discount_apply) ? 1 : 0;
    //         $invoice->created_by = \Auth::user()->creatorId();
    //         $invoice->save();
    //         CustomField::saveData($invoice, $request->customField);
    //         $products = $request->items;

    //         for ($i = 0; $i < count($products); $i++) {

    //             $invoiceProduct = new InvoiceProduct();
    //             $invoiceProduct->invoice_id = $invoice->id;
    //             $invoiceProduct->product_id = $products[$i]['item'];
    //             $invoiceProduct->quantity = $products[$i]['quantity'];
    //             $invoiceProduct->tax = $products[$i]['tax'];
    //             //                $invoiceProduct->discount    = isset($products[$i]['discount']) ? $products[$i]['discount'] : 0;
    //             $invoiceProduct->discount = $products[$i]['discount'];
    //             $invoiceProduct->price = $products[$i]['price'];
    //             $invoiceProduct->description = $products[$i]['description'];
    //             $invoiceProduct->save();

    //             //inventory management (Quantity)
    //             Utility::total_quantity('minus', $invoiceProduct->quantity, $invoiceProduct->product_id);

    //             //For Notification
    //             $setting = Utility::settings(\Auth::user()->creatorId());
    //             $customer = Customer::find($request->customer_id);
    //             $invoiceNotificationArr = [
    //                 'invoice_number' => \Auth::user()->invoiceNumberFormat($invoice->invoice_id),
    //                 'user_name' => \Auth::user()->name,
    //                 'invoice_issue_date' => $invoice->issue_date,
    //                 'invoice_due_date' => $invoice->due_date,
    //                 'customer_name' => $customer->name,
    //             ];
    //             //Slack Notification
    //             if (isset($setting['invoice_notification']) && $setting['invoice_notification'] == 1) {
    //                 Utility::send_slack_msg('new_invoice', $invoiceNotificationArr);
    //             }
    //             //Telegram Notification
    //             if (isset($setting['telegram_invoice_notification']) && $setting['telegram_invoice_notification'] == 1) {
    //                 Utility::send_telegram_msg('new_invoice', $invoiceNotificationArr);
    //             }
    //             //Twilio Notification
    //             if (isset($setting['twilio_invoice_notification']) && $setting['twilio_invoice_notification'] == 1) {
    //                 Utility::send_twilio_msg($customer->contact, 'new_invoice', $invoiceNotificationArr);
    //             }

    //         }

    //         //Product Stock Report
    //         $type = 'invoice';
    //         $type_id = $invoice->id;
    //         StockReport::where('type', '=', 'invoice')->where('type_id', '=', $invoice->id)->delete();
    //         $description = $invoiceProduct->quantity . '  ' . __(' quantity sold in invoice') . ' ' . \Auth::user()->invoiceNumberFormat($invoice->invoice_id);
    //         Utility::addProductStock($invoiceProduct->product_id, $invoiceProduct->quantity, $type, $description, $type_id);

    //         //webhook
    //         $module = 'New Invoice';
    //         $webhook = Utility::webhookSetting($module);
    //         if ($webhook) {
    //             $parameter = json_encode($invoice);
    //             $status = Utility::WebhookCall($webhook['url'], $parameter, $webhook['method']);
    //             if ($status == true) {
    //                 return redirect()->route('invoice.index', $invoice->id)->with('success', __('Invoice successfully created.'));
    //             } else {
    //                 return redirect()->back()->with('error', __('Webhook call failed.'));
    //             }
    //         }

    //         return redirect()->route('invoice.index', $invoice->id)->with('success', __('Invoice successfully created.'));
    //     } else {
    //         return redirect()->back()->with('error', __('Permission denied.'));
    //     }
    // }

    function store(Request $request) {

        // Log the entire request data
        \Log::info('Form data received:', $request->all());
        try {
            if (\Auth::user()->can('create invoice')) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'customer_id' => 'required',
                        'issue_date' => 'required',
                        'due_date' => 'required',
                        'category_id' => 'required',
                        'traderInvoiceNo' => 'required|max:50|min:1',
                        'items' => 'required'
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }


                $data = $request->all();
                $customer = Customer::find($data['customer_id']);
                \Log::info('CUSTOMER');
                \Log::info($customer);

                $salesDt = str_replace('-', '', $data['salesDate']);
                $salesDate = date('Ymd', strtotime($salesDt));

                $occurredDt = str_replace('-', '', $data['occurredDate']);
                $occurredDate = date('Ymd', strtotime($occurredDt));
                $confirmDate = date('YmdHis', strtotime($request->input('confirmDate')));
                $stockReleseDate = date('YmdHis', strtotime($request->input('stockReleseDate')));
                $receiptPublishDate = date('YmdHis', strtotime($request->input('receiptPublishDate')));

                $saleItemList = [];
                
                $apiRequestData = [
                    "customerNo" => $customer->customerNo,
                    "customerTin" => $customer->customerTin,
                    "customerName" => $customer->name,
                    "customerMobileNo" => $customer->contact,
                    "salesType" => $data['salesType'],
                    "paymentType" => $data['paymentType'],
                    "traderInvoiceNo" => $data['traderInvoiceNo'],
                    "confirmDate" => $confirmDate,
                    "salesDate" => $salesDate,
                    "stockReleseDate" => $stockReleseDate,
                    "receiptPublishDate" => $receiptPublishDate,
                    "occurredDate" => $occurredDate,
                    "invoiceStatusCode" => $data['invoiceStatusCode'],
                    "remark" => $data['remark'],
                    "isPurchaseAccept" => $data['isPurchaseAccept'],
                    "isStockIOUpdate" => $data['isStockIOUpdate'],
                    "mapping" => $data['mapping'],
                    "saleItemList" => $saleItemList
                ];
                $totalAmount = 0;

                \Log::info('INV REQ DATA');
                \Log::info($apiRequestData);

                function calculateDiscountAmount($packageQuantity, $quantity, $unitPrice, $discountRate)
                {
                    $totalItems = $packageQuantity * $quantity;
                    $totalPriceBeforeDiscount = $totalItems * $unitPrice;
                    $discountAmount = ($totalPriceBeforeDiscount * $discountRate) / 100;
                    return $discountAmount;
                }

                function calculateTotalAmount($packageQuantity, $quantity, $unitPrice)
                {
                    $totalItems = $packageQuantity * $quantity;
                    $totalPriceBeforeDiscount = $totalItems * $unitPrice;
                    return $totalPriceBeforeDiscount;
                }

                foreach ($data['items'] as $item) {
                    $itemDetails = ItemInformation::where('itemCd', $item['itemCode'])->first();
                    $itemExprDt = str_replace('-', '', $item['itemExprDate']);
                    $itemExprDate = date('Ymd', strtotime($itemExprDt));
                    $itemData = [
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
                        "tax" => $item['tax'],
                        "qtyUnitCd" => $itemDetails->qtyUnitCd,
                        "quantity" => $item['quantity'],
                        "discountRate" => $item['discountRate'],
                        "discountAmt" => calculateDiscountAmount(
                            $item['pkgQuantity'],
                            $item['quantity'],
                            $item['unitPrice'],
                            $item['discountRate'],
                        ),
                        "itemExprDate" => $itemExprDate
                    ];

                    array_push($saleItemList, $itemData);


                }

                $apiRequestData['saleItemList'] = $saleItemList;
                \Log::info('INV REQ DATA');
                \Log::info($apiRequestData);

                // $url = 'https://etims.your-apps.biz/api/AddSale';

                // $response = Http::withOptions(['verify' => false])->withHeaders([
                //     'key' => '123456'
                //     ])->post($url, $apiRequestData);

                // \Log::info('SALES API RESPONSE');
                // \Log::info($response);

                // if ($response['statusCode'] == 400) {
                //     return redirect()->back()->with('error', $response['message']);
                // }

                \Log::info('INV DEYTA');
                \Log::info($data);

                foreach ($saleItemList as $item) {
                    $totalAmount += calculateTotalAmount($item['pkgQuantity'], $item['quantity'], $item['unitPrice']);
                }

                $inv = Invoice::create([
                    'invoice_id' => $this->invoiceNumber(),
                    'customer_id' => $data['customer_id'],
                    'issue_date' => $data['issue_date'],
                    'due_date' => $data['due_date'],
                    'send_date' => $data['send_date'],
                    'category_id' => $data['category_id'],
                    'ref_number' => $data['ref_number'],
                    'status' => 0, // Assuming 'status' is nullable or has a default value
                    'shipping_display' => null, // Assuming 'shipping_display' is nullable or has a default value
                    'discount_apply' => null, // Assuming 'discount_apply' is nullable or has a default value
                    'created_by' => \Auth::user()->creatorId(),
                    'trderInvoiceNo' => $data['traderInvoiceNo'],
                    'invoiceNo' => $data['traderInvoiceNo'],
                    'orgInvoiceNo' => $data['traderInvoiceNo'],
                    'customerTin' => $customer->customerTin,
                    'customerName' => $customer->name,
                    'receptTypeCode' => null, // Assuming 'receptTypeCode' is nullable or has a default value
                    'paymentTypeCode' => null, // Assuming 'paymentTypeCode' is nullable or has a default value
                    'salesSttsCode' => null, // Assuming 'salesSttsCode' is nullable or has a default value
                    'confirmDate' => $data['confirmDate'],
                    'salesDate' => $salesDate,
                    'stockReleaseDate' => $data['stockReleseDate'],
                    'cancelReqDate' => null, // Assuming 'cancelReqDate' is nullable or has a default value
                    'cancelDate' => null, // Assuming 'cancelDate' is nullable or has a default value
                    'refundDate' => null, // Assuming 'refundDate' is nullable or has a default value
                    'refundReasonCd' => null, // Assuming 'refundReasonCd' is nullable or has a default value
                    'totalItemCnt' => null, // Assuming 'totalItemCnt' is nullable or has a default value
                    'taxableAmtA' => null, // Assuming 'taxableAmtA' is nullable or has a default value
                    'taxableAmtB' => null, // Assuming 'taxableAmtB' is nullable or has a default value
                    'taxableAmtC' => null, // Assuming 'taxableAmtC' is nullable or has a default value
                    'taxableAmtD' => null, // Assuming 'taxableAmtD' is nullable or has a default value
                    'taxRateA' => null, // Assuming 'taxRateA' is nullable or has a default value
                    'taxRateB' => null, // Assuming 'taxRateB' is nullable or has a default value
                    'taxRateC' => null, // Assuming 'taxRateC' is nullable or has a default value
                    'taxRateD' => null, // Assuming 'taxRateD' is nullable or has a default value
                    'taxAmtA' => null, // Assuming 'taxAmtA' is nullable or has a default value
                    'taxAmtB' => null, // Assuming 'taxAmtB' is nullable or has a default value
                    'taxAmtC' => null, // Assuming 'taxAmtC' is nullable or has a default value
                    'taxAmtD' => null, // Assuming 'taxAmtD' is nullable or has a default value
                    'totalTaxableAmt' => null, // Assuming 'totalTaxableAmt' is nullable or has a default value
                    'totalTaxAmt' => null, // Assuming 'totalTaxAmt' is nullable or has a default value
                    'totalAmt' => $totalAmount,
                    'prchrAcptcYn' => null, // Assuming 'prchrAcptcYn' is nullable or has a default value
                    'remark' => $data['remark'],
                    'regrNm' => null, // Assuming 'regrNm' is nullable or has a default value
                    'regrId' => null, // Assuming 'regrId' is nullable or has a default value
                    'modrNm' => null, // Assuming 'modrNm' is nullable or has a default value
                    'modrId' => null, // Assuming 'modrId' is nullable or has a default value
                    'receipt_CustomerTin' => null, // Assuming 'receipt_CustomerTin' is nullable or has a default value
                    'receipt_CustomerMblNo' => null, // Assuming 'receipt_CustomerMblNo' is nullable or has a default value
                    'receipt_RptNo' => null, // Assuming 'receipt_RptNo' is nullable or has a default value
                    'receipt_RcptPbctDt' => null, // Assuming 'receipt_RcptPbctDt' is nullable or has a default value
                    'receipt_TrdeNm' => null, // Assuming 'receipt_TrdeNm' is nullable or has a default value
                    'receipt_Adrs' => null, // Assuming 'receipt_Adrs' is nullable or has a default value
                    'receipt_TopMsg' => null, // Assuming 'receipt_TopMsg' is nullable or has a default value
                    'receipt_BtmMsg' => null, // Assuming 'receipt_BtmMsg' is nullable or has a default value
                    'receipt_PrchrAcptcYn' => null, // Assuming 'receipt_PrchrAcptcYn' is nullable or has a default value
                    'createdDate' => null, // Assuming 'createdDate' is nullable or has a default value
                    'isKRASynchronized' => null, // Assuming 'isKRASynchronized' is nullable or has a default value
                    'kraSynchronizedDate' => null, // Assuming 'kraSynchronizedDate' is nullable or has a default value
                    'isStockIOUpdate' => $data['isStockIOUpdate'],
                    'resultCd' => null, // Assuming 'resultCd' is nullable or has a default value
                    'resultMsg' => null, // Assuming 'resultMsg' is nullable or has a default value
                    'resultDt' => null, // Assuming 'resultDt' is nullable or has a default value
                    'response_CurRcptNo' => null, // Assuming 'response_CurRcptNo' is nullable or has a default value
                    'response_TotRcptNo' => null, // Assuming 'response_TotRcptNo' is nullable or has a default value
                    'response_IntrlData' => null, // Assuming 'response_IntrlData' is nullable or has a default value
                    'response_RcptSign' => null, // Assuming 'response_RcptSign' is nullable or has a default value
                    'response_SdcDateTime' => null, // Assuming 'response_SdcDateTime' is nullable or has a default value
                    'response_SdcId' => null, // Assuming 'response_SdcId' is nullable or has a default value
                    'response_MrcNo' => null, // Assuming 'response_MrcNo' is nullable or has a default value
                    'qrCodeURL' => null, // Assuming 'qrCodeURL' is nullable or has a default value
                ]);

                foreach ($saleItemList as $item) {
                    InvoiceProduct::create([
                        'product_id' => $item['itemCode'],
                        'invoice_id' => $inv['invoice_id'],
                        'quantity' => $item['quantity'],
                        'tax' => $itemDetails->taxTyCd,
                        'discount' => $item['discountAmt'],
                        'price' => calculateTotalAmount(
                            $item['pkgQuantity'],
                            $item['quantity'],
                            $item['unitPrice'],
                        ),
                        'customer_id' => $data['customer_id'],
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
                        "discountAmt" => calculateDiscountAmount(
                            $item['pkgQuantity'],
                            $item['quantity'],
                            $item['unitPrice'],
                            $item['discountRate'],
                        ),
                        "itemExprDate" => $itemExprDate
                    ]);
                }
                return redirect()->to('invoice')->with('success', 'Sale Created Successfully');
            }
        } catch (\Exception $e) {
            \Log::info('ADD INV ERROR');
            \Log::info($e);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }