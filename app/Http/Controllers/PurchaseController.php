<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Bill;
use App\Models\User;
use App\Models\Vender;
use App\Models\Details;
use App\Models\Utility;
use App\Models\Purchase;
use App\Models\warehouse;
use App\Models\BankAccount;
use App\Models\CustomField;
use App\Models\StockReport;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Purchase_Sales;
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
use App\Models\Purchase_Sales_Items;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;
use App\Models\ProductServiceCategory;
use App\Models\MappedPurchaseItemList;
use Illuminate\Support\Facades\Storage;



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
                $vender = Vender::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
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


    /**
     * Using Api Endpoint
     * 
     *  */

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create($vendorId)
    // {
    //     if (\Auth::user()->can('create purchase')) {
    //         $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'purchase')->get();
    //         $category = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->where('type', 'expense')->get()->pluck('name', 'id');
    //         $category->prepend('Select Category', '');

    //         $purchase_number = \Auth::user()->purchaseNumberFormat($this->purchaseNumber());
    //         $suppliers = Vender::all()->pluck('name', 'id');
    //         $suppliers->prepend('Select Supplier', '');

    //         $warehouse = warehouse::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
    //         $warehouse->prepend('Select Warehouse', '');

    //         $product_services = ProductService::get()->pluck('itemNm', 'id');
    //         $product_services_Codes = ProductService::get()->pluck('itemNm', 'itemCd');
    //         $product_services_Codes->prepend('--', '');
    //         $product_services->prepend('--', '');
    //         // Fetch countries code  from the details model
    //         $countries = Details::where('cdCls', '05')->get();
    //         // Fetch countries data from the Details model where cdCls is 05
    //         $countries = Details::where('cdCls', '05')->get()->pluck('cdNm', 'cdVal');
    //         $paymentTypeCodes = PaymentTypeCodes::get()->pluck('payment_type_code');
    //         $purchaseTypeCodes = PurchaseTypeCodes::get()->pluck('purchase_type_code');
    //         $purchaseStatusCodes = PurchaseStatusCodes::get()->pluck('purchase_status_code');
    //         $ReceiptTypesCodes = ReceiptTypeCodes::get()->pluck('receipt_type_code');
    //         return view('purchase.create', compact('product_services_Codes','paymentTypeCodes', 'purchaseTypeCodes', 'purchaseStatusCodes', 'ReceiptTypesCodes', 'suppliers', 'purchase_number', 'product_services', 'category', 'customFields', 'vendorId', 'warehouse', 'countries'));
    //     } else {
    //         return response()->json(['error' => __('Permission denied.')], 401);
    //     }
    // }
    /********************** 
 
  * Add Purchase to API END POINT 
  * 
  ********************************************/
    public function getPurchaseSalesItemsFromApi()
    {

        try {
            if (\Auth::user()->type == 'company') {
                ini_set('max_execution_time', 300);

                $url = 'https://etims.your-apps.biz/api/GetPurchaseList?date=20220409120000';

                // $response = Http::withHeaders([
                //     'key' => '123456'
                // ])->get($url);

                $response = Http::withHeaders([
                    'key' => '123456'
                ])->timeout(300)->get($url);

                //  $response = retry(3, function () use ($url) {
                //  return Http::withHeaders([
                //  'key' => '123456'
                //  ])->timeout(60000)->get($url); 
                // }, 100); 


                $data = $response->json();
                $purchaseSalesList = $data['data']['data']['saleList'];

                \Log::info('API Request Data  of Sales and Purchases: ' . json_encode($purchaseSalesList));
                \Log::info('API Response: ' . $response->body());
                \Log::info('API Response Status Code: ' . $response->status());

                // Initialize purchase_id counter
                $purchaseId = 1;

                // Divide the data into batches of 100 items each
                if (isset($purchaseSalesList)) {
                    foreach ($purchaseSalesList as $class) {
                        // Initialize    $saleItemCode as null
                        $saleItemCode = null;

                        if (isset($class['spplrInvcNo'])) {
                            $saleItemCode = $class['spplrInvcNo'];
                        }
                        \Log::info('API Request Data of Sales and Purchases All Invoices No: ' . json_encode($saleItemCode));
                        $itemlists = $class['itemList'];
                        if (isset($itemlists)) {
                            $batches = array_chunk($itemlists, 100);
                            foreach ($batches as $batch) {
                                foreach ($batch as $item) {
                                    \Log::info('Processing item with spplrInvcNo: ' . $saleItemCode . ' and item: ' . json_encode($item));
                                    if (!empty($saleItemCode)) {

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
                                            'purchase_id' => null,
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
                        }
                    }
                }
                return redirect()->route('purchase.index')->with('success', __('Sales Items Lists Details successfully created from Api.'));
            } else {
                return redirect()->route('purchase.index')->with('error', __('Permission Denied'));
            }
        } catch (\Exception $e) {
            \Log::error('Error adding Item Information from the API: ' . $e->getMessage());
            \Log::info($e);
            return redirect()->route('purchase.index')->with('error', __('Error adding Sales Items Lists Details  from the API.'));
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
                        'purchase_id' => null,
                        'vender_id' => null,
                        'warehouse_id' => null,
                        'purchase_date' => null,
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
    public function create($vendorId)
    {
        // if(\Auth::user()->can('create purchase'))
        // {
        $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'purchase')->get();
        $category = ProductServiceCategory::where('created_by', \Auth::user()->creatorId())->where('type', 'expense')->get()->pluck('name', 'id');
        $category->prepend('Select Category', '');

            $purchase_number = \Auth::user()->purchaseNumberFormat($this->purchaseNumber());
            $venders = Vender::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'spplrNm');
            $venders->prepend('Select Vender', '');
            $suppliers = Vender::all()->pluck('name', 'id');
            $suppliers->prepend('Select Supplier', '');

            $warehouse = warehouse::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $warehouse->prepend('Select Warehouse', '');

            // $product_services = ProductService::where('created_by', \Auth::user()->creatorId())->where('type','!=', 'service')->get()->pluck('name', 'id');
            // $product_services->prepend('--', '');
            $product_services = ProductService::get()->pluck('itemNm', 'itemCd');
            $product_services_Codes = ProductService::get()->pluck('itemNm', 'itemCd');
            $product_services_Codes->prepend('--', '');
            $product_services->prepend('--', '');

            // Fetch countries code  from the details model
            $countries = Details::where('cdCls', '05')->get();
            // Fetch countries data from the Details model where cdCls is 05
            $countries = Details::where('cdCls', '05')->get()->pluck('cdNm', 'cdVal');
            $paymentTypeCodes = PaymentTypeCodes::get()->pluck('payment_type_code', 'code');
            $purchaseTypeCodes = PurchaseTypeCodes::get()->pluck('purchase_type_code', 'code');
            $purchaseStatusCodes = PurchaseStatusCodes::get()->pluck('purchase_status_code', 'code');
            $ReceiptTypesCodes = ReceiptTypeCodes::get()->pluck('receipt_type_code', 'receipt_type_code');
            $taxationtype = Details::where('cdCls', '04')->pluck('userDfnCd1', 'cd');

        return view('purchase.create', compact(
            'taxationtype',
            'venders',
            'product_services_Codes',
            'paymentTypeCodes',
            'purchaseTypeCodes',
            'purchaseStatusCodes',
            'ReceiptTypesCodes',
            'suppliers',
            'purchase_number',
            'product_services',
            'category',
            'customFields',
            'vendorId',
            'warehouse',
            'countries'
        ));
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(Request $request)
    // {

    //     if(\Auth::user()->can('create purchase'))
    //     {
    //         $validator = \Validator::make(
    //             $request->all(), [
    //                 'vender_id' => 'required',
    //                 'warehouse_id' => 'required',
    //                 'purchase_date' => 'required',
    //                 'category_id' => 'required',
    //                 'items' => 'required',
    //             ]
    //         );
    //         if($validator->fails())
    //         {
    //             $messages = $validator->getMessageBag();

    //             return redirect()->back()->with('error', $messages->first());
    //         }
    //         $purchase                 = new Purchase();
    //         $purchase->purchase_id    = $this->purchaseNumber();
    //         $purchase->vender_id      = $request->vender_id;
    //         $purchase->warehouse_id      = $request->warehouse_id;
    //         $purchase->purchase_date  = $request->purchase_date;
    //         $purchase->purchase_number   = !empty($request->purchase_number) ? $request->purchase_number : 0;
    //         $purchase->status         =  0;
    //         //            $purchase->discount_apply = isset($request->discount_apply) ? 1 : 0;
    //         $purchase->category_id    = $request->category_id;
    //         $purchase->created_by     = \Auth::user()->creatorId();
    //         $purchase->save();

    //         $products = $request->items;

    //         for($i = 0; $i < count($products); $i++)
    //         {
    //             $purchaseProduct              = new PurchaseProduct();
    //             $purchaseProduct->purchase_id     = $purchase->id;
    //             $purchaseProduct->product_id  = $products[$i]['item'];
    //             $purchaseProduct->quantity    = $products[$i]['quantity'];
    //             $purchaseProduct->tax         = $products[$i]['tax'];
    //         //                $purchaseProduct->discount    = isset($products[$i]['discount']) ? $products[$i]['discount'] : 0;
    //             $purchaseProduct->discount    = $products[$i]['discount'];
    //             $purchaseProduct->price       = $products[$i]['price'];
    //             $purchaseProduct->description = $products[$i]['description'];
    //             $purchaseProduct->save();

    //             //inventory management (Quantity)
    //             Utility::total_quantity('plus',$purchaseProduct->quantity,$purchaseProduct->product_id);

    //             //Product Stock Report
    //             $type='purchase';
    //             $type_id = $purchase->id;
    //             $description=$products[$i]['quantity'].'  '.__(' quantity add in purchase').' '. \Auth::user()->purchaseNumberFormat($purchase->purchase_id);
    //             Utility::addProductStock( $products[$i]['item'],$products[$i]['quantity'],$type,$description,$type_id);

    //             //Warehouse Stock Report
    //             if(isset($products[$i]['item']))
    //             {
    //                 Utility::addWarehouseStock( $products[$i]['item'],$products[$i]['quantity'],$request->warehouse_id);
    //             }

    //         }

    //         return redirect()->route('purchase.index', $purchase->id)->with('success', __('Purchase successfully created.'));
    //     }
    //     else
    //     {
    //         return redirect()->back()->with('error', __('Permission denied.'));
    //     }
    // }



    public function store (Request $request) {
        try {

            $data = $request->all();
            \Log::info('STORE PURCHASE REQUEST DATA');
            \Log::info($data);

            $validator = \Validator::make($data, [
                'supplierInvcNo' => 'required',
                'purchTypeCode' => 'required',
                'purchStatusCode' => 'required',
                'pmtTypeCode' => 'required',
                'purchDate' => 'required',
                'occurredDate' => 'required',
            ]);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            $occurredDt = str_replace('-', '', $data['occurredDate']);
            $occurredDate = date('Ymd', strtotime($occurredDt));
            $purchaseDate = str_replace('-', '', $data['purchDate']);
            $purchDate = date('Ymd', strtotime($purchaseDate));
            $confirmDate = date('YmdHis', strtotime($request->input('confirmDate')));
            $warehouseDate = date('YmdHis', strtotime($request->input('receiptPublishDate')));

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
            ];

            $purchaseItemsList = [];

            foreach ($data['items'] as $item) {
                $itemDetails = ProductService::where('itemCd', $item['item'])->first();
                $itemExprDt = str_replace('-', '', $item['itemExprDate']);
                $itemExprDate = date('Ymd', strtotime($itemExprDt));

                $itemData = [
                    "itemCode"=> $itemDetails->itemCd,
                    "supplrItemClsCode"=> $item['supplrItemClsCode'],
                    "supplrItemCode"=> $item['supplrItemCode'],
                    "supplrItemName"=> $item['supplrItemName'],
                    "quantity"=> $item['quantity'],
                    "unitPrice"=> $item['price'],
                    "pkgQuantity"=> $item['pkgQuantity'],
                    "discountRate"=> $item['discount'],
                    "discountAmt"=> $item['discountAmount'],
                    "itemExprDt"=> $itemExprDate,
                ];

                array_push($purchaseItemsList, $itemData);
            }

            $apiRequestData['itemsDataList'] = $purchaseItemsList;

            // $response = Http::withOptions([
            //     'verify' => false
            // ])->withHeaders([
            //     'accept' => 'application/json',
            //     'key' => '123456',
            //     'Content-Type' => 'application/json',
            // ])->post('https://etims.your-apps.biz/api/AddPurchase', $apiRequestData);

            // \Log::info('ADD PURCHASE API RESPONSE');
            // \Log::info($response);

            // if ($response['statusCode'] != 200) {
            //     return redirect()->back()->with('error', $response['message']);
            // }

            $discount_apply = false;
            $totTaxblAmt = 0;
            $totTaxAmt = 0;
            $totAmt = 0;

            foreach ($data['items'] as $item) {
                if (isset($item['discountAmount']) && $item['discountAmount'] > 0) {
                    $discount_apply = true;
                    break;
                }
            }

            foreach ($data['items'] as $item) {
                $totTaxblAmt += (($item['price'] * $item['pkgQuantity'] * $item['quantity']) - $item['discountAmount']);
                $totTaxAmt += $item['taxAmount'];
            }
            
            $totAmt += ($totTaxblAmt + $totTaxAmt);

            $purchaseData = [
                'purchase_id' => $this->purchaseNumber(),
                'vender_id' => $data['supplier_id'],
                'warehouse_id' => $data['warehouse'],
                'purchase_date' => $data['purchDate'],
                'purchase_number ' => $this->purchaseNumber(),
                'status' => 0,
                'shipping_display' => null,
                'send_date' => null,
                'discount_apply' => $discount_apply,
                'category_id' => $data['category_id'],
                'created_by' => \Auth::user()->creatorId(),
                'spplrTin' => $data['supplierTin'],
                'spplrNm' => $data['supplierName'],
                'spplrBhfId' => $data['supplierBhfId'],
                'spplrInvcNo' => $data['supplierInvcNo'],
                'spplrSdcId' => $data['spplrSdcId'] ?? null,
                'spplrMrcNo' => $data['spplrMrcNo'] ?? null,
                'rcptTyCd' => $data['rcptTyCd'] ?? null,
                'pmtTyCd' => $data['pmtTypeCode'] ?? null,
                'cfmDt' => $data['confirmDate'] ?? null,
                'salesDt' => $data['purchDate'] ?? null,
                'stockRlsDt' => $data['warehouseDate'] ?? null,
                'warehouseDate' => $data['warehouseDate'] ?? null,
                'warehouse' => $data['warehouse'] ?? null,
                'totItemCnt' => count($purchaseItemsList),
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
                'totTaxblAmt' => $totTaxblAmt,
                'totTaxAmt' => $totTaxAmt,
                'totAmt' => $totAmt,
                'remark' => $data['remark'],
            ];

            $purchase = Purchase::create($purchaseData);

            foreach ($data['items'] as $index => $item) {
                $itemDetails = ProductService::where('itemCd', $item['item'])->first();
                PurchaseProduct::create([
                    'purchase_id' => $purchase->id,
                    'product_id' => $itemDetails->id,
                    'quantity' => $item['quantity'],
                    'tax' => $item['taxAmount'],
                    'discount' => $item['discountAmount'],
                    'price' => $item['price'],
                    'description' => $item['description'],
                    'saleItemCode' => null,
                    'itemSeq' => $index,
                    'itemCd' =>  $itemDetails['itemCd'],
                    'itemClsCd' => $itemDetails['itemClsCd'],
                    'itemNm' =>  $itemDetails['itemNm'],
                    'bcd' => $itemDetails['bcd'],
                    'supplrItemClsCd' => $item['supplrItemClsCode'],
                    'supplrItemCd' =>  $item['supplrItemCode'],
                    'supplrIteNm' => $item['supplrItemName'],
                    'pkgUnitCd' =>  $itemDetails['pkgUnitCd'],
                    'pkg' => $item['pkgQuantity'],
                    'qtyUnitCd' =>  $itemDetails['qtyUnitCd'],
                    'qty' => $item['quantity'],
                    'prc' => $item['price'],
                    'splyAmt' =>  null,
                    'dcAmt' => null,
                    'taxTyCd' =>  $itemDetails['taxTyCd'],
                    'taxblAmt' => ($item['quantity'] * $item['price'] * $item['pkgQuantity']) - $item['discountAmount'],
                    'taxAmt' => $item['taxAmount'],
                    'totAmt' => (($item['quantity'] * $item['price'] * $item['pkgQuantity']) - $item['discountAmount']) + $item['taxAmount'],
                    'itemExprDt' => $item['itemExprDate'],
                ]);
                Utility::addWarehouseStock($itemDetails->id, $item['quantity'], $data['warehouse']);
            }

            return redirect()->to('purchase')->with('success', __('Purchase Added'));

        } catch (\Exception $e) {
            \Log::info('ADD PURCHASE ERROR');
            \Log::info($e);

            return redirect()->to('purchase')->with('error', $e->getMessage());
        }
    }

    public function show($ids)
    {

        if (\Auth::user()->can('show purchase')) {
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
        if (\Auth::user()->can('show purchase')) {
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
        if (\Auth::user()->can('edit purchase')) {
            \Log::info('EDIT ID');
            \Log::info($id);
            $purchase = PurchaseProduct::find($id);
            $purchase_number = $id;
            \Log::info('EDIT ITEM');
            \Log::info($purchase);
            $category = ProductServiceCategory::all()->pluck('name', 'id');
            $warehouse = warehouse::all()->pluck('name', 'id');
            $purchase_number = $purchase->purchase_id;
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
            if (\Auth::user()->can('edit purchase')) {
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
        if (\Auth::user()->can('delete purchase')) {
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
        if (\Auth::user()->can('send purchase')) {
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

        if (\Auth::user()->can('send purchase')) {
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
        if (\Auth::user()->can('create payment purchase')) {
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
        if (\Auth::user()->can('create payment purchase')) {
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

        if (\Auth::user()->can('delete payment purchase')) {
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

        if (\Auth::user()->can('delete purchase')) {

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

            if (\Auth::user()->can('create purchase')) {
                $rules = [
                    'supplierInvcNo' => 'required',
                    'purchaseTypeCode' => 'required',
                    'purchaseStatusCode' => 'required',
                    'itemCode.*' => 'required',
                    'supplierItemCode.*' => 'required',
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

                    \Log::info('Api Response For Updating the Map Purchase Status: '.$secondResponse);

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


    public function MapPurchasesDetails($mappedPurchaseId)
    {
        if (\Auth::user()->can('show purchase')) {
            try {
                $mappedpurchase = mappedPurchases::where('mappedPurchaseId', $mappedPurchaseId)->first();
                if ($mappedpurchase) {
                    // Fetch related purchase Lists items
                    $mappedpurchaseItemsList = MappedPurchaseItemList::where('mapped_purchase_id', $mappedPurchaseId)->get();

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
    public function searchByDate(Request $request)
    {
        try {
            // Log received request data
            \Log::info('Received request date From Searching Purchases By Date:', $request->all());

            // Validate the request
            $request->validate([
                'searchByDate' => 'required|date',
            ]);

            // Get the entered date
            $date = $request->input('searchByDate');

            // Convert the date to YYYYMMDD format using Carbon
            $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd');

            // Send a GET request to the API endpoint
            $response = Http::withHeaders([
                'accept' => '*/*',
                'key' => '123456',
            ])->get('https://etims.your-apps.biz/api/MapPurchase/SearchByDate', [
                        'date' => $formattedDate,
                    ]);

            // Log response data
            \Log::info('API Response Status Code For Searching Purchases By Date: ' . $response->status());
            \Log::info('API Response Body For Searching Purchases By Date: ' . $response->body());

            // Check if the request was successful
            if ($response->successful()) {
                // Get the data from the API response
                $purchasesSearchedByDates = $response->json();

                // Filter the data based on the entered date
                $filteredPurchases = collect($purchasesSearchedByDates['data'])->filter(function ($purchase) use ($formattedDate) {
                    return Carbon::createFromFormat('Ymd', $purchase['purchaseDate'])->format('Y-m-d') == $formattedDate;
                });

                // Check if the data exists in the local database
                $localPurchases = MappedPurchases::where('purchaseDate', $formattedDate)->get();
                if ($localPurchases->isEmpty()) {
                    // Insert the data into the local database
                    foreach ($filteredPurchases as $purchase) {
                        MappedPurchases::create([
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

                        // Insert the item list data into the local database
                        foreach ($purchase['mapPurchaseItemList'] as $itemList) {
                            MappedPurchaseItemList::create([
                                'purchase_item_list_id' => $itemList['id'],
                                'mapped_purchase_id' => $purchase['id'],
                                'itemSeq' => $itemList['itemSeq'],
                                'itemCd' => $itemList['itemCd'],
                                'itemClsCd' => $itemList['itemClsCd'],
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
                                'supplyMmt' => $itemList['supplyAmt'],
                                'discountRate' => $itemList['discountRate'],
                                'discountAmt' => $itemList['discountAmt'],
                                'taxblAmt' => $itemList['taxblAmt'],
                                'taxTyCd' => $itemList['taxTyCd'],
                                'taxAmt' => $itemList['taxAmt'],
                                'totAmt' => $itemList['totAmt'],
                                'itemExprDt' => $itemList['itemExprDt'],
                            ]);
                        }
                    }
                }

                // Redirect back to the page with the filtered purchases
                $filteredPurchases = MappedPurchases::where('purchaseDate', $date)->get();
                return view('purchase.mapPurchases', compact('filteredPurchases'));
            } else {
                // Handle the API request failure
                return redirect()->back()->with(['error', 'Failed to fetch Any Searched Purchases By Date from the API']);
            }
        } catch (\Exception $e) {
            // Log the exception
            \Log::error($e);
            \Log::error('An error occurred while searching Purchases By Date: ' . $e->getMessage());
            // Handle the exception and provide feedback to the user
            return back()->withErrors(['api_error' => $e->getMessage()]);
        }
    }


}