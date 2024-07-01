<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Vender;
use App\Models\Details;
use App\Models\Utility;
use App\Models\Purchase;
use App\Models\warehouse;
use App\Models\BankAccount;
use App\Models\CustomField;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductService;
use App\Models\mappedPurchases;
use App\Models\PurchasePayment;
use App\Models\PurchaseProduct;
use App\Models\PaymentTypeCodes;
use App\Models\ReceiptTypeCodes;
use App\Models\WarehouseProduct;
use App\Models\PurchaseTypeCodes;
use App\Models\WarehouseTransfer;
use Illuminate\Support\Facades\DB;
use App\Models\PurchaseStatusCodes;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use App\Models\ProductServiceCategory;
use App\Models\MappedPurchaseItemList;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;



class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if (\Auth::user()->type == 'company') {
                $vender = Vender::all()->pluck('name', 'id');
                $vender->prepend('Select Vendor', '');
                $status = Purchase::$statues;
                $purchases = Purchase::all();

                return view('purchase.index', compact('purchases', 'vender', 'status'));
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::info('RENDER PURCHASE INDEX ERROR');
            \Log::info($e);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getPurchaseSalesItemsFromApi()
    {
        try {
            if (\Auth::user()->type == 'company') {
                ini_set('max_execution_time', 300);

                $url = 'https://etims.your-apps.biz/api/GetPurchaseList?date=20220409120000';

                $response = Http::withHeaders([
                    'key' => '123456'
                ])->timeout(300)->get($url);

                if ($response->failed()) {
                    throw new \Exception('Failed to fetch data from the API. Status: ' . $response->status());
                }

                $data = $response->json();
                $purchaseSalesList = $data['data']['data']['saleList'];

                \Log::info('API Request Data of Sales and Purchases: ' . json_encode($purchaseSalesList));
                \Log::info('API Response: ' . $response->body());
                \Log::info('API Response Status Code: ' . $response->status());

                if (isset($purchaseSalesList)) {
                    foreach ($purchaseSalesList as $class) {
                        // Initialize $saleItemCode as null
                        $saleItemCode = $class['spplrInvcNo'] ?? null;
                        \Log::info('API Request Data of Sales and Purchases All Invoices No: ' . json_encode($saleItemCode));

                        if (!empty($saleItemCode)) {
                            // Fetch the purchase_id using the saleItemCode (spplrInvcNo)
                            $purchase = Purchase::where('spplrInvcNo', $saleItemCode)->first();

                            if ($purchase) {
                                $purchaseId = $purchase->id;

                                $itemlists = $class['itemList'];
                                if (isset($itemlists)) {
                                    $batches = array_chunk($itemlists, 100);
                                    foreach ($batches as $batch) {
                                        foreach ($batch as $item) {
                                            \Log::info('Processing item with spplrInvcNo: ' . $saleItemCode . ' and item: ' . json_encode($item));

                                            // Initialize the tax code variable
                                            $taxCode = null;
                                            // Map the tax type code to the tax code
                                            switch ($item['taxTyCd']) {
                                                case 'A':
                                                    $taxCode = 1;
                                                    break;
                                                case 'B':
                                                    $taxCode = 2;
                                                    break;
                                                case 'C':
                                                    $taxCode = 3;
                                                    break;
                                                case 'D':
                                                    $taxCode = 4;
                                                    break;
                                                case 'E':
                                                    $taxCode = 5;
                                                    break;
                                                case 'F':
                                                    $taxCode = 6;
                                                    break;
                                                default:
                                                    $taxCode = null;
                                                    break;
                                            }

                                            PurchaseProduct::create([
                                                'purchase_id' => $purchaseId,
                                                'quantity' => $item['totAmt'],
                                                'tax' => $taxCode,
                                                'price' => $item['prc'],
                                                'discount' => $item['prc'] * $item['dcRt'] / 100,
                                                'saleItemCode' => $saleItemCode,
                                                'itemSeq' => $item['itemSeq'],
                                                'itemCd' => $item['itemCd'],
                                                'itemClsCd' => $item['itemClsCd'],
                                                'itemNm' => $item['itemNm'],
                                                'bcd' => $item['bcd'],
                                                'spplrItemClsCd' => $item['spplrItemClsCd'],
                                                'spplrItemCd' => $item['spplrItemCd'],
                                                'spplrItemNm' => $item['spplrItemNm'],
                                                'pkgUnitCd' => $item['pkgUnitCd'],
                                                'pkg' => $item['pkg'],
                                                'qtyUnitCd' => $item['qtyUnitCd'],
                                                'qty' => $item['qty'],
                                                'prc' => $item['prc'],
                                                'splyAmt' => $item['splyAmt'],
                                                'dcRt' => $item['dcRt'],
                                                'taxTyCd' => $item['taxTyCd'],
                                                'taxblAmt' => $item['taxblAmt'],
                                                'taxAmt' => $item['taxAmt'],
                                                'totAmt' => $item['totAmt'],
                                                'itemExprDt' => $item['itemExprDt']
                                            ]);
                                        }
                                    }
                                }
                            } else {
                                \Log::warning('No matching Purchase found for spplrInvcNo: ' . $saleItemCode);
                            }
                        }
                    }
                }

                return redirect()->route('purchase.index')->with('success', __('Sales Items Lists Details successfully created from API.'));
            } else {
                return redirect()->route('purchase.index')->with('error', __('Permission Denied'));
            }
        } catch (\Exception $e) {
            \Log::error('Error adding Item Information from the API: ' . $e->getMessage());
            \Log::info($e);
            return redirect()->route('purchase.index')->with('error', __('Error adding Sales Items Lists Details from the API.'));
        }
    }

    public function getSuppliersDetailsForPurchaseSalesFromApi()
    {
        try {
            ini_set('max_execution_time', 300);
            $url = 'https://etims.your-apps.biz/api/GetPurchaseList?date=20220409120000';

            $response = Http::withHeaders([
                'key' => '123456'
            ])->timeout(300)->get($url);

            $data = $response->json()['data'];
            $purchaseSalesSuppliers = $data['data']['saleList'];

            // Log API request and response details
            \Log::info('API Request Data of Suppliers of Sales and Purchases: ' . json_encode($data));
            \Log::info('API Request Data of Suppliers of Sales and Purchases: ' . json_encode($purchaseSalesSuppliers));
            \Log::info('API Response: ' . $response->body());
            \Log::info('API Response Status Code: ' . $response->status());


            // Initialize purchase_id counter
            $purchaseId = 1;
            // Divide the data into batches of 100 items each
            $batches = array_chunk($purchaseSalesSuppliers, 100);

            foreach ($batches as $batch) {
                foreach ($batch as $item) {
                    // Process each batch
                    Purchase::create([
                        'purchase_id' => $purchaseId++,
                        'vender_id' => null,
                        'warehouse_id' => 1,
                        'purchase_date' => $item['salesDt'],
                        'purchase_number' => null,
                        'discount_apply' => null,
                        'category_id' => null,
                        'created_by' => \Auth::user()->creatorId(),
                        'spplrTin' => $item['spplrTin'],
                        'spplrNm' => $item['spplrNm'],
                        'spplrBhfId' => $item['spplrBhfId'],
                        'spplrInvcNo' => $item['spplrInvcNo'],
                        'spplrSdcId' => $item['spplrSdcId'],
                        'spplrMrcNo' => $item['spplrMrcNo'],
                        'rcptTyCd' => $item['rcptTyCd'],
                        'pmtTyCd' => $item['pmtTyCd'],
                        'cfmDt' => $item['cfmDt'],
                        'salesDt' => $item['salesDt'],
                        'stockRlsDt' => $item['stockRlsDt'],
                        'totItemCnt' => $item['totItemCnt'],
                        'taxblAmtA' => $item['taxblAmtA'],
                        'taxblAmtB' => $item['taxblAmtB'],
                        'taxblAmtC' => $item['taxblAmtC'],
                        'taxblAmtD' => $item['taxblAmtD'],
                        'taxblAmtE' => $item['taxblAmtE'],
                        'taxRtA' => $item['taxRtA'],
                        'taxRtB' => $item['taxRtB'],
                        'taxRtC' => $item['taxRtC'],
                        'taxRtD' => $item['taxRtD'],
                        'taxRtE' => $item['taxRtE'],
                        'taxAmtA' => $item['taxAmtA'],
                        'taxAmtB' => $item['taxAmtB'],
                        'taxAmtC' => $item['taxAmtC'],
                        'taxAmtD' => $item['taxAmtD'],
                        'taxAmtE' => $item['taxAmtE'],
                        'totTaxblAmt' => $item['totTaxblAmt'],
                        'totTaxAmt' => $item['totTaxAmt'],
                        'totAmt' => $item['totAmt'],
                        'remark' => $item['remark']
                    ]);
                }
            }

            return redirect()->route('purchase.index')->with('success', __('Sales Lists Suppliers Details successfully created From Api.'));
        } catch (\Exception $e) {
            \Log::error('Error adding Sales Lists Suppliers Details  from the API: ');
            \Log::info($e);
            return redirect()->route('purchase.index')->with('error', __('Error adding Sales Lists Suppliers Details  from the API.'));
        }
    }

    public function synchronize(Request $request){
        try {
            $request->validate([
                'getpurchaseByDate' => 'required|date_format:Y-m-d',
            ], [
                'getpurchaseByDate.required' => __('Date is required for synchronization Search for Purchase SearchByDate.'),
                'getpurchaseByDate.date_format' => __('Invalid date format.'),
            ]);
    
            $date = $request->input('getpurchaseByDate');
            $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd') . '000000';
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['key' => '123456'])
                ->get("https://etims.your-apps.biz/api/GetPurchaseList?date={$formattedDate}");

            Log::info('API RESPONSE');
            Log::info($response);
        } catch (\Exception $e) {
            \Log::error('Error syncing purchases:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Error syncing purchases.'));
        }
    }

    private function synchronizePurchases($Purchases, $itemLists)
    {
        $syncedCount = 0;

        foreach ($Purchases as $purchase) {
            // Check if the purchase already exists
            if (!Purchase::where('spplrInvcNo', $purchase['spplrInvcNo'])->exists()) {
                // Create the purchase
                $newPurchase = Purchase::create($purchase);
                $syncedCount++;

                $syncedPurchaseItemCount = 0;

                foreach ($itemLists as $itemList) {
                    // Set the purchase ID
                    $itemList['purchase_id'] = $newPurchase->id;

                    // Check if the item list already exists
                    $exists = PurchaseProduct::where('saleItemCode', $itemList['saleItemCode'])
                        ->where('purchase_id', $newPurchase->id)
                        ->exists();

                    if (!$exists) {
                        // Create the purchase item list
                        PurchaseProduct::create($itemList);
                        $syncedPurchaseItemCount++;
                    }
                }

                \Log::info("Synced $syncedPurchaseItemCount item lists for purchase ID {$newPurchase->id}");
            }
        }

        return $syncedCount;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(Request $request)
    // {

    //     $vender = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
    //     $vender->prepend('Select Vendor', '');
    //     $status = Purchase::$statues;
    //     $purchases = Purchase::where('created_by', '=', \Auth::user()->creatorId())->with(['vender','category'])->get();


    //     return view('purchase.index', compact('purchases', 'status','vender'));


    // }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($vendorId){
        try {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'purchase')->get();
            $category = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->where('type', 'expense')->get()->pluck('name', 'id');
            $category->prepend('Select Category', '');

            $purchase_number = \Auth::user()->purchaseNumberFormat($this->purchaseNumber());
            $venders = Vender::all()->pluck( 'name','spplrTin');
            $venders->prepend('Select Vender', '');

            \Log::info('Venders:');
            \Log::info($venders);

            $warehouse = warehouse::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $warehouse->prepend('Select Warehouse', '');

            // $product_services = ProductService::where('created_by', \Auth::user()->creatorId())->where('type','!=', 'service')->get()->pluck('name', 'id');
            // $product_services->prepend('--', '');
            $items = ProductService::where('created_by', \Auth::user()->creatorId())->pluck('itemNm', 'itemCd');
            $items->prepend('Select Item', '');
            Log::info('Items');
            Log::info($items);
            $countries = Details::where('cdCls', '05')->get()->pluck('cdNm', 'cd');
            $countries->prepend('Select Country', '');
            $taxes = Details::where('cdCls', '04')->get()->pluck('cdNm', 'cd');
            $taxes->prepend('Select Tax', '');
            $paymentTypeCodes = PaymentTypeCodes::get()->pluck('payment_type_code', 'code');
            $purchaseTypeCodes = PurchaseTypeCodes::get()->pluck('purchase_type_code', 'code');
            $purchaseStatusCodes = PurchaseStatusCodes::get()->pluck('purchase_status_code', 'code');
            $ReceiptTypesCodes = ReceiptTypeCodes::get()->pluck('receipt_type_code', 'receipt_type_code');
            $taxationtype = Details::where('cdCls', '04')->pluck('userDfnCd1', 'cd');

            return view('purchase.create', compact(
                'taxationtype',
                'venders',
                'paymentTypeCodes',
                'purchaseTypeCodes',
                'purchaseStatusCodes',
                'ReceiptTypesCodes',
                'purchase_number',
                'items',
                'category',
                'customFields',
                'vendorId',
                'warehouse',
                'countries',
                'taxes'
                ));
        } catch (\Exception $e) {
            Log::error('CREATE PURCHASE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', __('Error creating purchase.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request) {
        try {

            $data = $request->all();

            $validator = \Validator::make($data, [
                'purchTypeCode' => 'required|string|min:1|max:1',
                'purchStatusCode' => 'required|string|min:2|max:2',
                'pmtTypeCode' => 'required|string|min:2|max:2',
                'purchDate' => 'required|date',
                'occurredDate' => 'required|date',
                'items' => 'required',
                'items.*.itemCode' => 'required|string',
                'items.*.quantity' => 'required|numeric',
                'items.*.pkgQuantity' => 'required|numeric',
                'items.*.unitPrice' => 'required|numeric',
                'items.*.discountRate' => 'required|numeric',
                ]);

            if ($validator->fails()) {
                Log::info('VALIDATION ERRORS');
                Log::info($validator->errors());
                return redirect()->back()->with('error', __('Error creating purchase.'));
            }

            $apiData = [];
            $items = [];
             \Log::info('Purchase FoRM Data being Posted  : ');
             \Log::info($data);

            

            if ($data['supplierTin']) {
                $supplier = Vender::where('spplrTin', $data['supplierTin'])->first();
                \Log::info('Supplier Info  : ');
                \Log::info($supplier);

                $apiData['supplierTin'] = $data['supplierTin'];
                $apiData['supplierBhfId'] = $supplier->spplrBhfId;
                $apiData['supplierName'] = $supplier->spplrNm;
            } else {
                $apiData['supplierTin'] = null;
                $apiData['supplierBhfId'] = null;
                $apiData['supplierName'] = null;
            }

            $apiData['supplierInvcNo'] = $data['supplierInvcNo'] ?? null;
            $apiData['purchTypeCode'] = $data['purchTypeCode'];
            $apiData['purchStatusCode'] = $data['purchStatusCode'];
            $apiData['pmtTypeCode'] = $data['pmtTypeCode'];
            $apiData['purchDate'] = date('Ymd', strtotime($data['purchDate']));
            $apiData['occurredDate'] = date('Ymd', strtotime($data['occurredDate']));
            $apiData['confirmDate'] = $data['confirmDate'] ? date('YmdHis', strtotime($data['confirmDate'])) : null;
            $apiData['warehouseDate'] = $data['warehouseDate'] ? date('YmdHis', strtotime($data['warehouseDate'])) : null;
            $apiData['remark'] = $data['remark'] ?? null;
            $apiData['mapping'] = $data['mapping'] ?? null;

            foreach($data['items'] as $givenItem) {
                $discountRate = $givenItem['discountRate'] ?? 0;
                $discountAmt = $givenItem['unitPrice'] * $givenItem['quantity'] * $discountRate / 100; 
                array_push($items, [
                    'itemCode' => $givenItem['itemCode'],
                    'quantity' => $givenItem['quantity'],
                    'unitPrice' => $givenItem['unitPrice'],
                    'pkgQuantity' => $givenItem['pkgQuantity'],
                    'discountRate' => $discountRate,
                    'discountAmt' => $discountAmt,
                    'itemExprDt' => $givenItem['itemExprDt'] ? date('Ymd', strtotime($givenItem['itemExprDt'])) : null,
                    'supplrItemName' => $givenItem['supplrItemName'] ?? null,
                    'supplrItemCode' => $givenItem['supplrItemCode'] ?? null,
                    'supplrItemClsCd' => $givenItem['supplrItemClsCd'] ?? null,
                ]);
            }

            $apiData['itemsDataList'] = $items;

            \Log::info('Api Data Info Being Posted : ');
            \Log::info($apiData);
            
            
            $url = 'https://etims.your-apps.biz/api/AddPurchase';

            $response = Http::withHeaders([
                'key' => '123456'
            ])->withOptions(['verify' => false])->post($url, $apiData);

            Log::info('API RESPONSE');
            Log::info($response);
            if ($response['statusCode'] == 200) {
                return redirect()->route('purchase.index')->with('success', __('Purchase successfully created.'));
            } else {
                return redirect()->back()->with('error', __('Error creating purchase.'));
            }
            
        } catch (\Exception $e) {
            Log::error('STORE PURCHASE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', __('Something went wrong'));
        }
    }


    public function getProductData(Request $request)
    {
        $data['product'] = $product = ProductService::find($request->product_id);
        $data['unit'] = !empty($product->unit) ? $product->unit->name : '';
        $data['taxRate'] = $taxRate = !empty($product->tax_id) ? $product->taxRate($product->tax_id) : 0;
        $data['taxes'] = !empty($product->tax_id) ? $product->tax($product->tax_id) : 0;
        $salePrice = $product->purchase_price;
        $quantity = 1;
        $taxPrice = ($taxRate / 100) * ($salePrice * $quantity);
        $data['totalAmount'] = ($salePrice * $quantity);

        return json_encode($data);
    }

    public function show($ids)
    {

        if (\Auth::user()->type == 'company') {
            try {
                \Log::info('The Ecrypt when user click  show kids :');

                \Log::info($ids);

                $id = Crypt::decrypt($ids);

            } catch (\Throwable $e) {
                \Log::info('Exception Error if the Purchase is not Found :');

                \Log::info($e);

                return redirect()->back()->with('error', __('Purchase Not Found.'));
            }

            $id = Crypt::decrypt($ids);

            $purchase = Purchase::find($id);

            \Log::info('PURCHASE Fetched  to show in the View Blade: ');

            \Log::info($purchase);

            if ($purchase->created_by == \Auth::user()->creatorId()) {

                $purchasePayment = PurchasePayment::where('purchase_id', $purchase->id)->first();

                $vendor = $purchase->vender;

                \Log::info('Vender For this Purchase  Fetched  to show in the View Blade : ');

                \Log::info($vendor);

                \Log::info('Purchase Id Fetched  to show in the View Blade : ');

                \Log::info($purchase->id);

                $iteams = PurchaseProduct::where('purchase_id', $purchase->id)->get();

                \Log::info('Iteams For the Purchase  Fetched  to show in the View Blade : ');

                \Log::info($iteams);

                return view('purchase.view', compact('purchase', 'vendor', 'iteams', 'purchasePayment'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function details($spplrInvcNo)
    {
        if (\Auth::user()->type == 'company') {
            try {
                $purchase = Purchase::where('spplrInvcNo', $spplrInvcNo)->first();
                if ($purchase) {
                    // Fetch related items
                    $purchaseItems = PurchaseProduct::where('saleItemCode', $spplrInvcNo)->get();
                    // Fetch ProductService model
                    $ProductService = ProductService::get()->pluck('itemNm', 'itemCd');
                    return view('purchase.details', compact('purchase', 'purchaseItems', 'ProductService'));
                } else {
                    return view('errors.not_found'); // Create a custom error view
                }
            } catch (\Exception $e) {
                \Log::error($e);
                return redirect()->back()->with('error', __('Something went wrong.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }



    public function edit($id)
    {
        if (\Auth::user()->type == 'company') {
            \Log::info('EDIT ID');
            \Log::info($id);
            $purchase = PurchaseProduct::find($id);
            $purchase_number = $id;
            \Log::info('EDIT ITEM');
            \Log::info($purchase);
            $category = ProductServiceCategory::all()->pluck('name', 'id');
            $warehouse = warehouse::all()->pluck('name', 'id');
            $purchase_number = $purchase->id;
            $venders = Vender::all()->pluck('name', 'id');
            $product_services = ProductService::all()->pluck('itemNm', 'id');

            return view('purchase.edit', compact('venders', 'product_services', 'purchase', 'warehouse', 'purchase_number', 'category'));
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }
    public function update(Request $request, PurchaseProduct $purchase)
    {
        try {
            if (\Auth::user()->type == 'company') {
                \Log::info('Permitted');
                \Log::info('Request: ');
                \Log::info($request->all());
                \Log::info('Purchase: ');
                \Log::info($purchase);
            }
        } catch (\Exception $e) {
            \Log::error('Update Purchase Error');
            \Log::error($e);
            return redirect()->back()->with('error', __('Something went wrong.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Purchase  $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        if (\Auth::user()->type == 'company') {
            if ($purchase->created_by == \Auth::user()->creatorId()) {
                $purchase_products = PurchaseProduct::where('purchase_id', $purchase->id)->get();

                $purchasepayments = $purchase->payments;
                foreach ($purchasepayments as $key => $value) {
                    $purchasepayment = PurchasePayment::find($value->id)->first();
                    $purchasepayment->delete();
                }

                foreach ($purchase_products as $purchase_product) {
                    $warehouse_qty = WarehouseProduct::where('warehouse_id', $purchase->warehouse_id)->where('product_id', $purchase_product->product_id)->first();

                    $warehouse_transfers = WarehouseTransfer::where('product_id', $purchase_product->product_id)->where('from_warehouse', $purchase->warehouse_id)->get();
                    foreach ($warehouse_transfers as $warehouse_transfer) {
                        $temp = WarehouseProduct::where('warehouse_id', $warehouse_transfer->to_warehouse)->first();
                        if ($temp) {
                            $temp->quantity = $temp->quantity - $warehouse_transfer->quantity;
                            if ($temp->quantity > 0) {
                                $temp->save();
                            } else {
                                $temp->delete();
                            }

                        }
                    }
                    if (!empty($warehouse_qty)) {
                        $warehouse_qty->quantity = $warehouse_qty->quantity - $purchase_product->quantity;
                        if ($warehouse_qty->quantity > 0) {
                            $warehouse_qty->save();
                        } else {
                            $warehouse_qty->delete();
                        }
                    }
                    $product_qty = ProductService::where('id', $purchase_product->product_id)->first();
                    if (!empty($product_qty)) {
                        $product_qty->quantity = $product_qty->quantity - $purchase_product->quantity;
                        $product_qty->save();
                    }
                    $purchase_product->delete();

                }

                $purchase->delete();
                PurchaseProduct::where('purchase_id', '=', $purchase->id)->delete();


                return redirect()->route('purchase.index')->with('success', __('Purchase successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    function purchaseNumber()
    {
        $latest = Purchase::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->purchase_id + 1;
    }
    public function sent($id)
    {
        if (\Auth::user()->type == 'company') {
            $purchase = Purchase::where('id', $id)->first();
            $purchase->send_date = date('Y-m-d');
            $purchase->status = 1;
            $purchase->save();

            $vender = Vender::where('id', $purchase->vender_id)->first();

            $purchase->name = !empty($vender) ? $vender->name : '';
            $purchase->purchase = \Auth::user()->purchaseNumberFormat($purchase->purchase_id);

            $purchaseId = Crypt::encrypt($purchase->id);
            $purchase->url = route('purchase.pdf', $purchaseId);

            Utility::userBalance('vendor', $vender->id, $purchase->getTotal(), 'credit');

            $vendorArr = [
                'vender_bill_name' => $purchase->name,
                'vender_bill_number' => $purchase->purchase,
                'vender_bill_url' => $purchase->url,

            ];
            $resp = \App\Models\Utility::sendEmailTemplate('vender_bill_sent', [$vender->id => $vender->email], $vendorArr);

            return redirect()->back()->with('success', __('Purchase successfully sent.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }
    public function resent($id)
    {

        if (\Auth::user()->type == 'company') {
            $purchase = Purchase::where('id', $id)->first();

            $vender = Vender::where('id', $purchase->vender_id)->first();

            $purchase->name = !empty($vender) ? $vender->name : '';
            $purchase->purchase = \Auth::user()->purchaseNumberFormat($purchase->purchase_id);

            $purchaseId = Crypt::encrypt($purchase->id);
            $purchase->url = route('purchase.pdf', $purchaseId);
            //

            // Send Email
            //        $setings = Utility::settings();
            //
            //        if($setings['bill_resend'] == 1)
            //        {
            //            $bill = Bill::where('id', $id)->first();
            //            $vender = Vender::where('id', $bill->vender_id)->first();
            //            $bill->name = !empty($vender) ? $vender->name : '';
            //            $bill->bill = \Auth::user()->billNumberFormat($bill->bill_id);
            //            $billId    = Crypt::encrypt($bill->id);
            //            $bill->url = route('bill.pdf', $billId);
            //            $billResendArr = [
            //                'vender_name'   => $vender->name,
            //                'vender_email'  => $vender->email,
            //                'bill_name'  => $bill->name,
            //                'bill_number'   => $bill->bill,
            //                'bill_url' =>$bill->url,
            //            ];
            //
            //            $resp = Utility::sendEmailTemplate('bill_resend', [$vender->id => $vender->email], $billResendArr);
            //
            //
            //        }
            //
            //        return redirect()->back()->with('success', __('Bill successfully sent.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));

            /*******

            if (\Auth::user()->can('send purchase')) {
                $purchase = Purchase::where('id', $id)->first();

                if (!$purchase) {
                    // Handle the case where the purchase doesn't exist
                    return redirect()->back()->with('error', 'Purchase not found.');
                }

                // If the purchase exists, update its properties
                $purchase->send_date = date('Y-m-d');
                $purchase->status = 1;
                $purchase->save();

                // Assign the value of spplrNm to $purchase->name
                $purchase->name = $purchase->spplrNm;


                // Retrieve the purchase number from purchase_payments table
                $purchasePayment = PurchasePayment::where('purchase_id', $purchase->id)->first();
                $purchaseId = $purchasePayment ? $purchasePayment->purchase_id : null;

                // Format the purchase number
                $purchase->purchase = \Auth::user()->purchaseNumberFormat($purchaseId);



                $purchaseId = Crypt::encrypt($purchase->id);
                $purchase->url = route('purchase.pdf', $purchaseId);

                // Calculate the sum of totAmt
                $totalAmount = Purchase::where('id', $id)->sum('totAmt');

                // Retrieve the vendor ID and tin from the Purchase model
                $vendorId = $purchase->spplrTin;

                // Update Vendor Balance
                Utility::userBalance('vendor', $vendorId, $totalAmount, 'credit');

                $vendorId = 1;
                $vendorEmail = 'example@example.com';

                // Create the array with hardcoded data
                $vendorArr = [
                    'vender_bill_name' => $purchase->name,
                    'vender_bill_number' => $purchase->purchase,
                    'vender_bill_url' => $purchase->url,
                    $vendorId => $vendorEmail,
                ];
                $resp = Utility::sendEmailTemplate('vender_bill_sent', [$vender->id => $vender->email], $vendorArr);

                return redirect()->back()->with('success', __('Purchase successfully sent.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br>
             <span class="text-danger">' . $resp['error'] . '</span>' : ''));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
         *****/

            return redirect()->back()->with('success', __('Bill successfully sent.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function purchase($purchase_id)
    {

        $settings = Utility::settings();
        $purchaseId = Crypt::decrypt($purchase_id);

        $purchase = Purchase::where('id', $purchaseId)->first();
        $data = DB::table('settings');
        $data = $data->where('created_by', '=', $purchase->created_by);
        $data1 = $data->get();

        foreach ($data1 as $row) {
            $settings[$row->name] = $row->value;
        }

        $vendor = $purchase->vender;

        $totalTaxPrice = 0;
        $totalQuantity = 0;
        $totalRate = 0;
        $totalDiscount = 0;
        $taxesData = [];
        $items = [];

        foreach ($purchase->items as $product) {
            \Log::info('ITEMUUU');
            \Log::info(json_encode($product));
            $item = new \stdClass();
            $item->name = !empty($product) ? $product->itemNm : '';
            $item->quantity = $product->quantity;
            $item->tax = $product->tax;
            $item->discount = $product->discount;
            $item->price = $product->price;
            $item->description = $product->description;
            $item->totAmt = $product->totAmt;

            $totalQuantity += $item->quantity;
            $totalRate += $item->price;
            $totalDiscount += $item->discount;

            $taxes = Utility::tax($product->tax);
            $itemTaxes = [];
            $items[] = $item;
        }

        $purchase->itemData = $items;
        $purchase->totalTaxPrice = $totalTaxPrice;
        $purchase->totalQuantity = $totalQuantity;
        $purchase->totalRate = $totalRate;
        $purchase->totalDiscount = $totalDiscount;
        $purchase->taxesData = $taxesData;


        //        $logo         = asset(Storage::url('uploads/logo/'));
        //        $company_logo = Utility::getValByName('company_logo_dark');
        //        $img          = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));

        $logo = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo_dark');
        $purchase_logo = Utility::getValByName('purchase_logo');
        if (isset($purchase_logo) && !empty($purchase_logo)) {
            $img = Utility::get_file('purchase_logo/') . $purchase_logo;
        } else {
            $img = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));
        }

        if ($purchase) {
            $color = '#' . $settings['purchase_color'];
            $font_color = Utility::getFontColor($color);

            return view('purchase.templates.' . $settings['purchase_template'], compact('purchase', 'color', 'settings', 'vendor', 'img', 'font_color'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }

    }

    public function previewPurchase($template, $color)
    {
        $objUser = \Auth::user();
        $settings = Utility::settings();
        $purchase = new Purchase();

        $vendor = new \stdClass();
        $vendor->email = '<Email>';
        $vendor->shipping_name = '<Vendor Name>';
        $vendor->shipping_country = '<Country>';
        $vendor->shipping_state = '<State>';
        $vendor->shipping_city = '<City>';
        $vendor->shipping_phone = '<Vendor Phone Number>';
        $vendor->shipping_zip = '<Zip>';
        $vendor->shipping_address = '<Address>';
        $vendor->billing_name = '<Vendor Name>';
        $vendor->billing_country = '<Country>';
        $vendor->billing_state = '<State>';
        $vendor->billing_city = '<City>';
        $vendor->billing_phone = '<Vendor Phone Number>';
        $vendor->billing_zip = '<Zip>';
        $vendor->billing_address = '<Address>';

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

        $purchase->purchase_id = 1;
        $purchase->issue_date = date('Y-m-d H:i:s');
        //        $purchase->due_date   = date('Y-m-d H:i:s');
        $purchase->itemData = $items;

        $purchase->totalTaxPrice = 60;
        $purchase->totalQuantity = 3;
        $purchase->totalRate = 300;
        $purchase->totalDiscount = 10;
        $purchase->taxesData = $taxesData;
        $purchase->created_by = $objUser->creatorId();

        $preview = 1;
        $color = '#' . $color;
        $font_color = Utility::getFontColor($color);

        $logo = asset(Storage::url('uploads/logo/'));
        $company_logo = Utility::getValByName('company_logo_dark');
        $settings_data = \App\Models\Utility::settingsById($purchase->created_by);
        $purchase_logo = $settings_data['purchase_logo'];

        if (isset($purchase_logo) && !empty($purchase_logo)) {
            $img = Utility::get_file('purchase_logo/') . $purchase_logo;
        } else {
            $img = asset($logo . '/' . (isset($company_logo) && !empty($company_logo) ? $company_logo : 'logo-dark.png'));
        }


        return view('purchase.templates.' . $template, compact('purchase', 'preview', 'color', 'img', 'settings', 'vendor', 'font_color'));
    }

    public function savePurchaseTemplateSettings(Request $request)
    {

        $post = $request->all();
        unset($post['_token']);

        if (isset($post['purchase_template']) && (!isset($post['purchase_color']) || empty($post['purchase_color']))) {
            $post['purchase_color'] = "ffffff";
        }


        if ($request->purchase_logo) {
            $dir = 'purchase_logo/';
            $purchase_logo = \Auth::user()->id . '_purchase_logo.png';
            $validation = [
                'mimes:' . 'png',
                'max:' . '20480',
            ];
            $path = Utility::upload_file($request, 'purchase_logo', $purchase_logo, $dir, $validation);
            if ($path['flag'] == 0) {
                return redirect()->back()->with('error', __($path['msg']));
            }
            $post['purchase_logo'] = $purchase_logo;
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

        return redirect()->back()->with('success', __('Purchase Setting updated successfully'));
    }

    public function items(Request $request)
    {

        $items = PurchaseProduct::where('purchase_id', $request->purchase_id)->where('product_id', $request->product_id)->first();

        return json_encode($items);
    }

    public function purchaseLink($purchaseId)
    {
        try {
            $id = Crypt::decrypt($purchaseId);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Purchase Not Found.'));
        }

        $id = Crypt::decrypt($purchaseId);
        $purchase = Purchase::find($id);

        if (!empty($purchase)) {
            $user_id = $purchase->created_by;
            $user = User::find($user_id);
            $purchasePayment = PurchasePayment::where('purchase_id', $purchase->id)->first();
            $vendor = $purchase->vender;
            $iteams = $purchase->items;

            return view('purchase.customer_bill', compact('purchase', 'vendor', 'iteams', 'purchasePayment', 'user'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }

    }


    //Show the create Payment Form 
    public function payment($purchase_id)
    {
        if (\Auth::user()->type == 'company') {
            $purchase = Purchase::where('id', $purchase_id)->first();
            $venders = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            $categories = ProductServiceCategory::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $accounts = BankAccount::select('*', \DB::raw("CONCAT(bank_name,' ',holder_name) AS name"))->where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

            return view('purchase.payment', compact('venders', 'categories', 'accounts', 'purchase'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));

        }
    }

    //POST all the data fro mthe form to the database 

    public function createPayment(Request $request, $purchase_id)
    {
        if (\Auth::user()->type == 'company') {
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

            $purchasePayment = new PurchasePayment();
            $purchasePayment->purchase_id = $purchase_id;
            $purchasePayment->date = $request->date;
            $purchasePayment->amount = $request->amount;
            $purchasePayment->account_id = $request->account_id;
            $purchasePayment->payment_method = 0;
            $purchasePayment->reference = $request->reference;
            $purchasePayment->description = $request->description;
            if (!empty($request->add_receipt)) {
                $fileName = time() . "_" . $request->add_receipt->getClientOriginalName();
                $request->add_receipt->storeAs('uploads/payment', $fileName);
                $purchasePayment->add_receipt = $fileName;
            }
            $purchasePayment->save();

            $purchase = Purchase::where('id', $purchase_id)->first();
            $due = $purchase->getDue();
            $total = $purchase->getTotal();

            if ($purchase->status == 0) {
                $purchase->send_date = date('Y-m-d');
                $purchase->save();
            }

            if ($due <= 0) {
                $purchase->status = 4;
                $purchase->save();
            } else {
                $purchase->status = 3;
                $purchase->save();
            }
            $purchasePayment->user_id = $purchase->vender_id;
            $purchasePayment->user_type = 'Vender';
            $purchasePayment->type = 'Partial';
            $purchasePayment->created_by = \Auth::user()->id;
            $purchasePayment->payment_id = $purchasePayment->id;
            $purchasePayment->category = 'Bill';
            $purchasePayment->account = $request->account_id;
            Transaction::addTransaction($purchasePayment);

            $vender = Vender::where('id', $purchase->vender_id)->first();

            $payment = new PurchasePayment();
            $payment->name = $vender['name'];
            $payment->method = '-';
            $payment->date = \Auth::user()->dateFormat($request->date);
            $payment->amount = \Auth::user()->priceFormat($request->amount);
            $payment->bill = 'bill ' . \Auth::user()->purchaseNumberFormat($purchasePayment->purchase_id);

            Utility::userBalance('vendor', $purchase->vender_id, $request->amount, 'debit');

            Utility::bankAccountBalance($request->account_id, $request->amount, 'debit');

            // Send Email
            $setings = Utility::settings();
            if ($setings['new_bill_payment'] == 1) {

                $vender = Vender::where('id', $purchase->vender_id)->first();
                $billPaymentArr = [
                    'vender_name' => $vender->name,
                    'vender_email' => $vender->email,
                    'payment_name' => $payment->name,
                    'payment_amount' => $payment->amount,
                    'payment_bill' => $payment->bill,
                    'payment_date' => $payment->date,
                    'payment_method' => $payment->method,
                    'company_name' => $payment->method,

                ];


                $resp = Utility::sendEmailTemplate('new_bill_payment', [$vender->id => $vender->email], $billPaymentArr);

                return redirect()->back()->with('success', __('Payment successfully added.') . (($resp['is_success'] == false && !empty($resp['error'])) ? '<br> <span class="text-danger">' . $resp['error'] . '</span>' : ''));

            }

            return redirect()->back()->with('success', __('Payment successfully added.'));
        }

    }

    public function paymentDestroy(Request $request, $purchase_id, $payment_id)
    {

        if (\Auth::user()->type == 'company') {
            $payment = PurchasePayment::find($payment_id);
            PurchasePayment::where('id', '=', $payment_id)->delete();

            $purchase = Purchase::where('id', $purchase_id)->first();

            $due = $purchase->getDue();
            $total = $purchase->getTotal();

            if ($due > 0 && $total != $due) {
                $purchase->status = 3;

            } else {
                $purchase->status = 2;
            }

            Utility::userBalance('vendor', $purchase->vender_id, $payment->amount, 'credit');
            Utility::bankAccountBalance($payment->account_id, $payment->amount, 'credit');

            $purchase->save();
            $type = 'Partial';
            $user = 'Vender';
            Transaction::destroyTransaction($payment_id, $type, $user);

            return redirect()->back()->with('success', __('Payment successfully deleted.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function vender(Request $request)
    {
        $vender = Vender::where('id', '=', $request->id)->first();

        return view('purchase.vender_detail', compact('vender'));
    }
    public function product(Request $request)
    {
        $data['product'] = $product = ProductService::find($request->product_id);
        $data['unit'] = !empty($product->unit) ? $product->unit->name : '';
        $data['taxRate'] = $taxRate = !empty($product->tax_id) ? $product->taxRate($product->tax_id) : 0;
        $data['taxes'] = !empty($product->tax_id) ? $product->tax($product->tax_id) : 0;
        $salePrice = $product->purchase_price;
        $quantity = 1;
        $taxPrice = ($taxRate / 100) * ($salePrice * $quantity);
        $data['totalAmount'] = ($salePrice * $quantity);

        return json_encode($data);
    }

    public function productDestroy(Request $request)
    {

        if (\Auth::user()->type == 'company') {

            $res = PurchaseProduct::where('id', '=', $request->id)->first();
            //            $res1 = PurchaseProduct::where('purchase_id', '=', $res->purchase_id)->where('product_id', '=', $res->product_id)->get();

            $purchase = Purchase::where('created_by', '=', \Auth::user()->creatorId())->first();
            $warehouse_id = $purchase->warehouse_id;

            $ware_pro = WarehouseProduct::where('warehouse_id', $warehouse_id)->where('product_id', $res->product_id)->first();

            $qty = $ware_pro->quantity;

            if ($res->quantity == $qty || $res->quantity > $qty) {
                $ware_pro->delete();
            } elseif ($res->quantity < $qty) {
                $ware_pro->quantity = $qty - $res->quantity;
                $ware_pro->save();

            }
            PurchaseProduct::where('id', '=', $request->id)->delete();


            return redirect()->back()->with('success', __('Purchase product successfully deleted.'));

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    // getItemToPurchase listing form
    public function getItemToPurchase(Request $request)
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


    public function mapPurchase(Request $request)
    {
        try {
            // Log received request data
            \Log::info('Received request data From Mapping Purchases:', $request->all());

            if (\Auth::user()->type == 'company') {
                $rules = [
                    'supplierInvcNo' => 'nullable|string',
                    'purchaseTypeCode' => 'nullable|string',
                    'purchaseStatusCode' => 'nullable|string',
                    'itemCode.*' => 'nullable|string|exists:product_services,itemCd',
                    'supplierItemCode.*' => 'nullable|string',
                    'mapQuantity.*' => 'nullable|numeric',
                ];

                // Validate request data
                $validator = \Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->route('purchase.index')->with('error', $messages->first());
                }

                // Construct itemPurchases array
                $itemPurchases = [];
                foreach ($request->input('itemCode') as $key => $itemCode) {
                    $itemPurchases[] = [
                        'supplierItemCode' => $request->input('supplierItemCode')[$key],
                        'itemCode' => $itemCode,
                        'mapQuantity' => $request->input('mapQuantity')[$key],
                    ];
                }

                $requestData = [
                    'supplierInvcNo' => $request->input('supplierInvcNo'),
                    'purchaseTypeCode' => $request->input('purchaseTypeCode'),
                    'purchaseStatusCode' => $request->input('purchaseStatusCode'),
                    'itemPurchases' => $itemPurchases,
                ];

                // Log request data
                \Log::info('API Request Mapping Purchase Data Posted:', $requestData);

                // Send request to API endpoint
                // $response = Http::post('https://etims.your-apps.biz/api/MapPurchase', $requestData);

                $response = Http::withHeaders([
                    'accept' => 'application/json',
                    'key' => '123456',
                    'Content-Type' => 'application/json',
                ])->post('https://etims.your-apps.biz/api/MapPurchase', $requestData);



                // Log response data
                \Log::info('API Response Status Code For Posting Mapping Purchase Data: ' . $response->status());
                \Log::info('API Response Body For Posting Mapping Purchase Data: ' . $response->body());

                // Check if the request was successful
                if ($response->successful()) {
                    // Update Purchase model where supplierInvcNo matches
                    // Purchase::where('supplierInvcNo', $request->input('supplierInvcNo'))
                    //     ->update(['isDBImport' => 1]);


                    Purchase::where('supplierInvcNo', $request->input('supplierInvcNo'))
                        ->update(['isDBImport' => true]);

                    $endpoint = 'https://etims.your-apps.biz/api/MapPurchase/UpdateMapPurchaseStatus';

                    $secondResponse = Http::withHeaders([
                        'accept' => 'application/json',
                        'key' => '123456',
                        'Content-Type' => 'application/json',
                    ])->post($endpoint, [
                                'invoiceNo' => $request->input('supplierInvcNo'),
                                'isUpdate' => true
                            ]);

                    \Log::info('Api Response For Updating the Map Purchase Status: ' . $secondResponse);

                    return redirect()->back()->with('success', 'Purchase Mapped Successfully And Updated purchase Status Also ');
                } else {
                    return redirect()->back()->with('error', 'Failed to Map Purchase. Please try again.');
                }
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } catch (\Exception $e) {
            \Log::info($e);

            return redirect()->back()->with('error', 'Something Went Wrong.');
        }
    }


    public function mappedPurchases()
    {
        try {
            // Initially, set $filteredPurchases to null or an empty array
            $filteredPurchases = [];

            // Retrieve all mapped purchases
            $mappedPurchases = MappedPurchases::all();

            // Pass both $mappedPurchases and $filteredPurchases to the view
            return view('purchase.mapPurchases', compact('mappedPurchases', 'filteredPurchases'));
        } catch (\Exception $e) {
            // Log the error for debugging purposes
            \Log::error('Error retrieving mapped purchases: ' . $e->getMessage());
            // Return an error view or redirect with an error message
            return back()->withError('Failed to retrieve mapped purchases. Please try again later.');
        }
    }


    public function MapPurchasesDetails($id)
    {
        if (\Auth::user()->type == 'company') {
            try {
                $mappedpurchase = mappedPurchases::where('id', $id)->first();
                if ($mappedpurchase) {
                    // Fetch related purchase Lists items
                    $mappedpurchaseItemsList = MappedPurchaseItemList::where('mapped_purchase_id', $id)->get();

                    \Log::info('mapped Purchases: ' . $mappedpurchase);

                    \Log::info(' Mapped Purchase Item List: ' . $mappedpurchaseItemsList);

                    return view('purchase.mappedPurchasesDetails', compact('mappedpurchase', 'mappedpurchaseItemsList'));
                } else {
                    return view('errors.not_found');
                }
            } catch (\Exception $e) {
                \Log::error($e);
                return redirect()->back()->with('error', __('Something went wrong.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }



    public function getMapPurchaseSearchByDate()
    {
        $url = 'https://etims.your-apps.biz/api/MapPurchase/SearchByDate?date=19990101';

        try {
            $response = Http::withHeaders([
                'key' => '123456'
            ])->get($url);
            $data = $response->json();
            $mappedPurchases = $data['data'];

            \Log::info('API Request Data: ' . json_encode($response));
            \Log::info('API Response: ' . $response->body());
            \Log::info('API Response Status Code: ' . $response->status());

            if (isset($mappedPurchases)) {
                foreach ($mappedPurchases as $purchase) {
                    mappedPurchases::create([
                        'mappedPurchaseId' => $purchase['id'],
                        'invcNo' => $purchase['invcNo'],
                        'orgInvcNo' => $purchase['orgInvcNo'],
                        'supplrTin' => $purchase['supplrTin'],
                        'supplrBhfId' => $purchase['supplrBhfId'],
                        'supplrName' => $purchase['supplrName'],
                        'supplrInvcNo' => $purchase['supplrInvcNo'],
                        'purchaseTypeCode' => $purchase['purchaseTypeCode'],
                        'rceiptTyCd' => $purchase['rceiptTyCd'],
                        'paymentTypeCode' => $purchase['paymentTypeCode'],
                        'purchaseSttsCd' => $purchase['purchaseSttsCd'],
                        'confirmDate' => $purchase['purchaseSttsCd'],
                        'purchaseDate' => $purchase['purchaseDate'],
                        'warehouseDt' => $purchase['warehouseDt'],
                        'cnclReqDt' => $purchase['cnclReqDt'],
                        'cnclDt' => $purchase['cnclDt'],
                        'refundDate' => $purchase['refundDate'],
                        'totItemCnt' => $purchase['totItemCnt'],
                        'taxblAmtA' => $purchase['taxblAmtA'],
                        'taxblAmtB' => $purchase['taxblAmtB'],
                        'taxblAmtC' => $purchase['taxblAmtC'],
                        'taxblAmtD' => $purchase['taxblAmtD'],
                        'taxRtA' => $purchase['taxRtA'],
                        'taxRtB' => $purchase['taxRtB'],
                        'taxRtC' => $purchase['taxRtC'],
                        'taxRtD' => $purchase['taxRtD'],
                        'taxAmtA' => $purchase['taxAmtA'],
                        'taxAmtB' => $purchase['taxAmtB'],
                        'taxAmtC' => $purchase['taxAmtC'],
                        'taxAmtD' => $purchase['taxAmtD'],
                        'totTaxblAmt' => $purchase['totTaxblAmt'],
                        'totTaxAmt' => $purchase['totTaxAmt'],
                        'totAmt' => $purchase['totAmt'],
                        'remark' => $purchase['remark'],
                        'resultDt' => $purchase['resultDt'],
                        'createdDate' => $purchase['createdDate'],
                        'isUpload' => $purchase['isUpload'],
                        'isStockIOUpdate' => $purchase['isStockIOUpdate'],
                        'isClientStockUpdate' => $purchase['isClientStockUpdate'],
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error getting  Mapped Purchases',
                'error' => $e->getMessage()
            ], 500);
        }
    }



    public function getMapPurchaseSearchByDateItemLists()
    {
        $url = 'https://etims.your-apps.biz/api/MapPurchase/SearchByDate?date=19990101';

        try {
            $response = Http::withHeaders([
                'key' => '123456'
            ])->get($url);
            $data = $response->json();
            \Log::info('API Request Data: ' . json_encode($data));

            if (isset($data['data'])) {
                foreach ($data['data'] as $purchaseclassList) {
                    if (isset($purchaseclassList['mapPurchaseItemList'])) {
                        foreach ($purchaseclassList['mapPurchaseItemList'] as $item) {
                            MappedPurchaseItemList::create([
                                'purchase_item_list_id' => $item['id'],
                                'mapped_purchase_id' => $purchaseclassList['id'],
                                'itemSeq' => $item['itemSeq'],
                                'itemCd' => $item['itemCd'],
                                'itemClsCd' => $item['itemClsCd'],
                                'itemNmme' => $item['itemNmme'],
                                'bcd' => $item['bcd'],
                                'supplrItemClsCd' => $item['supplrItemClsCd'],
                                'supplrItemCd' => $item['supplrItemCd'],
                                'supplrItemNm' => $item['supplrItemNm'],
                                'pkgUnitCd' => $item['pkgUnitCd'],
                                'pkg' => $item['pkg'],
                                'qtyUnitCd' => $item['qtyUnitCd'],
                                'qty' => $item['qty'],
                                'unitprice' => $item['unitprice'],
                                'supplyAmt' => $item['supplyAmt'],
                                'discountRate' => $item['discountRate'],
                                'discountAmt' => $item['discountAmt'],
                                'taxblAmt' => $item['taxblAmt'],
                                'taxTyCd' => $item['taxTyCd'],
                                'taxAmt' => $item['taxAmt'],
                                'totAmt' => $item['totAmt'],
                                'itemExprDt' => $item['itemExprDt'],
                            ]);

                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error getting Map Purchase Search By Date Item Lists',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     ///search MapPurchase  by Date Code Here 

    public function mapPurchaseSearchByDate(Request $request)
    {
        // Log the request from the form
        \Log::info('Synchronization request received from Searching the MapPurchase SearchByDate Form:', $request->all());

        // Validate the date input
        $request->validate([
            'searchByDate' => 'required|date_format:Y-m-d',
        ], [
            'searchByDate.required' => __('Date is required for synchronization Search for MapPurchase SearchByDate.'),
            'searchByDate.date_format' => __('Invalid date format.'),
        ]);

        // Get and format the date
        $date = $request->input('searchByDate');
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd');
        \Log::info('Date formatted from synchronization request:', ['formattedDate' => $formattedDate]);

        try {
            // Make the API call
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['key' => '123456'])
                ->get("https://etims.your-apps.biz/api/MapPurchase/SearchByDate?date={$formattedDate}");

            $data = $response->json();
            // if (!isset($data['data'])) {
            //     return redirect()->back()->with('error', __('There is no search result.'));
            // }

            $remoteMapPurchaseSearchByDateinfo = $data['data'];
            \Log::info('Remote item info:', $remoteMapPurchaseSearchByDateinfo);

            // Prepare data for synchronization
            $remoteMapPurchaseSearchByDateinfoToSync = [];
            $remoteMapPurchaseItemListsToSync = [];
            foreach ($remoteMapPurchaseSearchByDateinfo as $remoteItem) {
                $item = $this->prepareMapPurchaseData($remoteItem);
                $remoteMapPurchaseSearchByDateinfoToSync[] = $item;

                if (isset($remoteItem['mapPurchaseItemList']) && is_array($remoteItem['mapPurchaseItemList'])) {
                    foreach ($remoteItem['mapPurchaseItemList'] as $itemList) {
                        \Log::info('Remote item list::');
                        \Log::info($itemList);
                        $remoteMapPurchaseItemListsToSync[] = $this->prepareMapPurchaseItemListData($itemList);
                    }
                }
            }

            \Log::info('Remote mapped purchase search by date info to sync:', $remoteMapPurchaseSearchByDateinfoToSync);
            \Log::info('Remote mapped purchase item lists to sync:', $remoteMapPurchaseItemListsToSync);

            // Synchronize the purchases
            $syncedCount = $this->synchronizeMapPurchases($remoteMapPurchaseSearchByDateinfoToSync, $remoteMapPurchaseItemListsToSync);

            if ($syncedCount > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedCount . ' map purchases successfully.'));
            } else {
                return redirect()->back()->with('success', __('Map purchases up to date.'));
            }
        } catch (\Exception $e) {
            \Log::error('Error syncing map purchases:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Error syncing map purchases.'));
        }
    }

    private function prepareMapPurchaseData($remoteItem)
    {
        return [
            'mappedPurchaseId' => $remoteItem['id'],
            'invcNo' => $remoteItem['invcNo'],
            'created_by' => \Auth::user()->creatorId(),
            'orgInvcNo' => $remoteItem['orgInvcNo'],
            'supplrTin' => $remoteItem['supplrTin'],
            'supplrBhfId' => $remoteItem['supplrBhfId'],
            'supplrName' => $remoteItem['supplrName'],
            'supplrInvcNo' => $remoteItem['supplrInvcNo'],
            'purchaseTypeCode' => $remoteItem['purchaseTypeCode'],
            'rceiptTyCd' => $remoteItem['rceiptTyCd'],
            'paymentTypeCode' => $remoteItem['paymentTypeCode'],
            'purchaseSttsCd' => $remoteItem['purchaseSttsCd'],
            'confirmDate' => $remoteItem['purchaseSttsCd'],
            'purchaseDate' => $remoteItem['purchaseDate'],
            'warehouseDt' => $remoteItem['warehouseDt'],
            'cnclReqDt' => $remoteItem['cnclReqDt'],
            'cnclDt' => $remoteItem['cnclDt'],
            'refundDate' => $remoteItem['refundDate'],
            'totItemCnt' => $remoteItem['totItemCnt'],
            'taxblAmtA' => $remoteItem['taxblAmtA'],
            'taxblAmtB' => $remoteItem['taxblAmtB'],
            'taxblAmtC' => $remoteItem['taxblAmtC'],
            'taxblAmtD' => $remoteItem['taxblAmtD'],
            'taxRtA' => $remoteItem['taxRtA'],
            'taxRtB' => $remoteItem['taxRtB'],
            'taxRtC' => $remoteItem['taxRtC'],
            'taxRtD' => $remoteItem['taxRtD'],
            'taxAmtA' => $remoteItem['taxAmtA'],
            'taxAmtB' => $remoteItem['taxAmtB'],
            'taxAmtC' => $remoteItem['taxAmtC'],
            'taxAmtD' => $remoteItem['taxAmtD'],
            'totTaxblAmt' => $remoteItem['totTaxblAmt'],
            'totTaxAmt' => $remoteItem['totTaxAmt'],
            'totAmt' => $remoteItem['totAmt'],
            'remark' => $remoteItem['remark'],
            'resultDt' => $remoteItem['resultDt'],
            'createdDate' => $remoteItem['createdDate'],
            'isUpload' => $remoteItem['isUpload'],
            'isStockIOUpdate' => $remoteItem['isStockIOUpdate'],
            'isClientStockUpdate' => $remoteItem['isClientStockUpdate'],
        ];
    }

    private function prepareMapPurchaseItemListData($itemList)
    {
        return [
            'purchase_item_list_id' => $itemList['id'],
            'itemSeq' => $itemList['itemSeq'],
            'itemCd' => $itemList['itemCd'],
            'itemClsCd' => $itemList['itemClsCd'] ?? null,
            'itemNmme' => $itemList['itemNmme'],
            'bcd' => $itemList['bcd'],
            'supplrItemClsCd' => $itemList['supplrItemClsCd'],
            'supplrItemCd' => $itemList['supplrItemCd'],
            'supplrItemNm' => $itemList['supplrItemNm'],
            'pkgUnitCd' => $itemList['pkgUnitCd'],
            'pkg' => $itemList['pkg'],
            'qtyUnitCd' => $itemList['qtyUnitCd'],
            'qty' => $itemList['qty'],
            'unitprice' => $itemList['unitprice'],
            'supplyAmt' => $itemList['supplyAmt'],
            'discountRate' => $itemList['discountRate'],
            'discountAmt' => $itemList['discountAmt'],
            'taxblAmt' => $itemList['taxblAmt'],
            'taxTyCd' => $itemList['taxTyCd'],
            'taxAmt' => $itemList['taxAmt'],
            'totAmt' => $itemList['totAmt'],
            'itemExprDt' => $itemList['itemExprDt'],
        ];
    }
    private function synchronizeMapPurchases($mapPurchases, $itemLists)
    {
        $syncedCount = 0;

        foreach ($mapPurchases as $purchase) {
            // Check if the purchase already exists
            if (!MappedPurchases::where('invcNo', $purchase['invcNo'])->exists()) {
                // Create the mapped purchase
                $mappedPurchase = MappedPurchases::create($purchase);
                $syncedCount++;

                $syncedPurchaseItemCount = 0;

                foreach ($itemLists as $itemList) {
                    // Check if the item list already exists
                    $exists = MappedPurchaseItemList::where('purchase_item_list_id', $itemList['purchase_item_list_id'])
                        ->where('mapped_purchase_id', $mappedPurchase->id)
                        ->exists();

                    if (!$exists) {
                        // Set the mapped purchase ID
                        $itemList['mapped_purchase_id'] = $mappedPurchase->id;

                        // Create the mapped purchase item list
                        MappedPurchaseItemList::create($itemList);

                        \Log::info('ITEMS LIST');
                        \Log::info($itemList);

                        //Also creating  new product for the warehouse 
                        WarehouseProduct::create([
                            'warehouse_id' => 1,
                            'product_id' => null,
                            'itemCd' => $itemList['mapping'],
                            'quantity' => $itemList['qty'],
                            'packageQuantity' => $itemList['pkg'],
                            'created_by' => \Auth::user()->creatorId()
                        ]);
                        $syncedPurchaseItemCount++;
                    }
                }

                \Log::info("Synced $syncedPurchaseItemCount item lists for purchase ID {$mappedPurchase->id}");
            }
        }

        return $syncedCount;
    }

}