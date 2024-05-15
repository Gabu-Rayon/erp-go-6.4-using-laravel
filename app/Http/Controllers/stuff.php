<?php

function store(Request $request) {
    // Log the entire request data
    \Log::info('Form data received:', $request->all());
    try {
        if (\Auth::user()->can('create purchase')) {
            $validator = \Validator::make(
                $request->all(),
                [
                    'supplier_id' => 'required',
                    'supplierTin' => 'required',
                    'supplierBhfId' => 'required',
                    'supplierName' => 'required',
                    'supplierInvcNo' => 'required',
                    'purchTypeCode' => 'required',
                    'purchStatusCode' => 'required',
                    'pmtTypeCode' => 'required',
                    'purchDate' => 'required',
                    'occurredDate' => 'required',
                    'confirmDate' => 'required',
                    'warehouseDate' => 'required',
                    'category_id' => 'required',
                    'warehouse' => 'required',
                    'remark' => 'required',
                    'mapping' => 'required',
                    'items' => 'required'
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $data = $request->all();

            $occurredDt = str_replace('-', '', $data['occurredDate']);
            $occurredDate = date('Ymd', strtotime($occurredDt));
            $purchaseDate = str_replace('-', '', $data['purchDate']);
            $purchDate = date('Ymd', strtotime($purchaseDate));
            $confirmDate = date('YmdHis', strtotime($request->input('confirmDate')));
            $warehouseDate = date('YmdHis', strtotime($request->input('receiptPublishDate')));


            $purchaseItemsList = [];

            $apiRequestData = [
                'supplierTin' => $request->input('supplierTin'),
                'supplierBhfId' => $request->input('supplierBhfId'),
                'supplierName' => $request->input('supplierName'),
                'supplierInvcNo' => $request->input('supplierInvcNo'),
                'purchTypeCode' => $request->input('purchTypeCode'),
                'purchStatusCode' => $request->input('purchStatusCode'),
                'pmtTypeCode' => $request->input('pmtTypeCode'),
                'purchDate' => $purchDate,
                'occurredDate' => $occurredDate,
                'confirmDate' => $confirmDate,
                'warehouseDate' => $warehouseDate,
                'remark' => $request->input('remark'),
                'mapping' => $request->input('mapping'),
                'itemsDataList' => $purchaseItemsList,
            ];
            $totalAmount = 0;

            // Function to calculate discount amount
            function calculateDiscountAmount($packageQuantity, $quantity, $unitPrice, $discountRate)
            {
                $totalItems = $packageQuantity * $quantity;
                $totalPriceBeforeDiscount = $totalItems * $unitPrice;
                $discountAmount = ($totalPriceBeforeDiscount * $discountRate) / 100;
                return $discountAmount;
            }

            // Function to calculate total amount
            function calculateTotalAmount($packageQuantity, $quantity, $unitPrice)
            {
                $totalItems = $packageQuantity * $quantity;
                $totalPriceBeforeDiscount = $totalItems * $unitPrice;
                return $totalPriceBeforeDiscount;
            }

            // Function to get tax rate based on tax type code
            function getTaxRate($taxTyCd)
            {
                switch ($taxTyCd) {
                    case 'B':
                        return 16; // 16% tax rate for code B
                    case 'E':
                        return 8; // 8% tax rate for code E
                    default:
                        return 0; // Default tax rate if code not found
                }
            }

            // Function to get tax code based on tax type code
            function getTaxCode($taxTyCd)
            {
                switch ($taxTyCd) {
                    case 'A':
                        return 1;
                    case 'B':
                        return 2;
                    case 'C':
                        return 3;
                    case 'D':
                        return 4;
                    case 'E':
                        return 5;
                    case 'F':
                        return 6;
                    default:
                        return null; // Return null if tax type code not found
                }
            }

            $thispurchase = Purchase::create([
                'purchase_id' => $this->purchaseNumber(),
                'vender_id' => $data['supplier_id'],
                'warehouse_id' => $data['warehouse'],
                'purchase_date' => $data['purchDate'],
                'purchase_number ' => $this->purchaseNumber(),
                'status' => 0,
                'shipping_display' => null,
                'send_date' => null,
                'discount_apply' => null,
                'category_id' => $data['category_id'],
                'created_by' => \Auth::user()->creatorId(),

                'spplrTin' => $data['supplierTin'],
                'spplrNm' => $data['supplierName'],
                'spplrBhfId' => $data['supplierBhfId'],
                'spplrInvcNo' => $data['supplierInvcNo'],
                'spplrSdcId' => $data['spplrSdcId'] ?? null,
                'spplrMrcNo' => $data['spplrMrcNo'] ?? null,//Can also be null
                'rcptTyCd' => $data['supplierName'] ?? null,//Can also be null
                'pmtTyCd' => $data['pmtTypeCode'] ?? null,
                'cfmDt' => $data['confirmDate'] ?? null,
                'salesDt' => $data['purchDate'] ?? null,
                'stockRlsDt' => $data['warehouseDate'] ?? null,
                'warehouseDate' => $data['warehouseDate'] ?? null,
                'warehouse' => $data['warehouse'] ?? null,
                //For totItemCnt  are total item posted in the  PurchaseProduct Model
                'totItemCnt' => null,
                // 'totItemCnt' => count($itemsDataList),
                // 'totItemCnt' => PurchaseProdcut::count(),
                'taxblAmtA' => $data['taxblAmtA'] ?? null,
                'taxblAmtB' => $data['taxblAmtB'] ?? null,
                'taxblAmtC' => $data['taxblAmtB'] ?? null,
                'taxblAmtD' => $data['taxblAmtD'] ?? null,
                'taxblAmtE' => $data['taxblAmtE'] ?? null,
                'taxRtA' => $data['taxRtA'] ?? null,
                'taxRtB' => $data['taxRtB'] ?? null,
                'taxRtC' => $data['taxRtC'] ?? null,
                'taxRtD' => $data['taxRtD'] ?? null,
                'taxRtE' => $data['taxRtE'] ?? null,
                'taxAmtA' => $data['taxAmtA'] ?? null,
                'taxAmtB' => $data['taxAmtB'] ?? null,
                'taxAmtC' => $data['taxAmtC'] ?? null,
                'taxAmtD' => $data['taxAmtD'] ?? null,
                'taxAmtE' => $data['taxAmtE'] ?? null,
                //totTaxblAmt will be the totals for all products totTaxblAmt's e
                'totTaxblAmt' => null,
                //    'totTaxblAmt' => $request->input('items')->sum('itemTaxPrice'),
                //totTaxAmt will be the totals for all products totTaxAmt's
                'totTaxAmt' =>null,
                //    'totTaxAmt' => $request->input('items')->sum('taxAmt'),
                //totAmt will be the totals for all products totAmt's
                'totAmt' =>null,
                'remark' => $data['remark'],
            ]);
            
            foreach ($data['items'] as $item) {
                $itemDetails = ItemInformation::where('itemCd', $item['itemCode'])->first();
                $itemExprDt = str_replace('-', '', $item['itemExprDt']);
                $itemExprDate = date('Ymd', strtotime($itemExprDt));

                // Calculate discount amount
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

                // Calculate taxable amount
                $taxableAmount = $totalAmountBeforeTax - $itemTaxAmount;

                $itemData = [
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
                    "taxableAmount" => $taxableAmount,
                    "taxRate" => $taxRate
                ];

                array_push($purchaseItemsList, $itemData);

                // Get the tax code based on tax type code
                $taxCode = getTaxCode($itemDetails->taxTyCd);
                PurchaseProduct::create([
                   'purchase_id' => $thispurchase->id,
                    'product_id' => $itemDetails->id,
                    'quantity' => $item['quantity'],
                    'tax' => $taxCode,
                    'discount' => $item['discountAmt'],
                    'price' => $item['unitPrice'],
                    'description' => null,
                    'saleItemCode' => $data['supplierInvcNo'],
                    'itemSeq' => $itemDetails->itemSeq,
                    'itemCd' =>  $itemDetails->itemCd,
                    'itemClsCd' => $itemDetails->itemClsCd,
                    'itemNm' =>  $itemDetails->itemNm,
                    'bcd' => $itemDetails->bcd,
                    'supplrItemClsCd' => $itemDetails->supplrItemClsCd,
                    'supplrItemCd' =>  $itemDetails->supplrItemCls,
                    'supplrIteNm' => $itemDetails->supplrItemNm,
                    'pkgUnitCd' =>  $itemDetails->pkgUnitCd,
                    'pkg' => $itemDetails->pkg,
                    'qtyUnitCd' =>  $itemDetails->qtyUnitCd,
                    'qty' => $itemDetails->qty,
                    'prc' => $itemDetails->prc,
                    'splyAmt' =>  $itemDetails->splyAmt,
                    'dcAmt' => $item['discountAmt'],
                    'taxTyCd' =>  $itemDetails->taxTyCd,
                    'taxblAmt' => $itemTaxAmount,
                    'taxAmt' => $itemTaxAmount,
                    'totAmt' => $totalAmount,
                    'itemExprDt' => $itemExprDate,
                ]);
                // Update warehouse stock
                Utility::addWarehouseStock($itemDetails->id, $item['quantity'], $data['warehouse']);
            }


            $apiRequestData['purchaseItemsList'] = $purchaseItemsList;
            // Log request data
            \Log::info('Purchase INV REQ DATA  Before posting to Api :', $apiRequestData);

            // $response = Http::withHeaders([
            //     'accept' => 'application/json',
            //     'key' => '123456',
            //     'Content-Type' => 'application/json',
            // ])->post('https://etims.your-apps.biz/api/AddPurchase', $apiRequestData);

            //    //Log response data
            // \Log::info('API Response Status  Code For Posting Purchase Data: ' . $response->status());
            // \Log::info('API Request   Purchase  Data Posted: ' . json_encode($apiRequestData));
            // \Log::info('API Response  Body For Posting Purchase Data: ' . $response->body());
            // \Log::info('API Response Status Code For Posting Purchase Data: ' . $response->status());


            // \Log::info('SALES API RESPONSE');
            // \Log::info($response);

            // if ($response['statusCode'] == 400) {
            //     return redirect()->back()->with('error', 'Purchase Inv already exists');
            // }

            \Log::info('INV DEYTA');
            \Log::info($data);

            foreach ($purchaseItemsList as $item) {
                $totalAmount += calculateTotalAmount($item['pkgQuantity'], $item['quantity'], $item['unitPrice']);
            }
             
            return redirect()->to('purchase')->with('success', 'Purchase Created Successfully');
        }
    } catch (\Exception $e) {
        \Log::info('ADD Purchase ERROR');
        \Log::info($e);

        return redirect()->back()->with('error', $e->getMessage());
    }
}