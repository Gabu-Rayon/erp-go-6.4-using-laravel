<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\Tax;
use App\Models\Code;
use App\Models\User;
use App\Models\Details;
use App\Models\Utility;
use App\Models\ItemType;
use App\Models\CustomField;
use Illuminate\Http\Request;
use App\Models\ChartOfAccount;
use App\Models\ConfigSettings;
use App\Models\ProductService;
use App\Models\QuantityUnitCode;
use App\Models\WarehouseProduct;
use App\Models\ProductServiceUnit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductServiceExport;
use App\Imports\ProductServiceImport;
use App\Models\ProductServiceCategory;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Models\ProductServicesPackagingUnit;
use App\Models\ProductsServicesClassification;

class ProductServiceController extends Controller
{
    public function index(Request $request)
    {
        try {
            $category = ItemType::whereIn('item_type_name', ['Raw Material', 'Finished Product', 'Service'])->pluck('item_type_name', 'item_type_code');
            $category->prepend('Select Category', '');

            $query = ProductService::where('created_by', Auth::user()->creatorId())->with(['category', 'unit']);

            if (!empty($request->category)) {
                $query->where('category_id', $request->category);
            }

            $productServices = $query->orderBy('created_at', 'desc')->get();

            return view('productservice.index', compact('productServices', 'category'));
        } catch (Exception $e) {
            Log::error('PRODUCT / SERVICE INDEX ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $itemclassifications = ProductsServicesClassification::pluck('itemClsNm', 'itemClsCd');
            $itemtypes = ItemType::pluck('item_type_name', 'item_type_code');
            $countries = Details::where('cdCls', '05')->pluck('cdNm', 'cd');
            $taxationtype = Details::where('cdCls', '04')->pluck('cdNm', 'cd');


            $incomeChartAccounts = ChartOfAccount::select(DB::raw('CONCAT(chart_of_accounts.code, " - ", chart_of_accounts.name) AS code_name, chart_of_accounts.id as id'))
                ->leftjoin('chart_of_account_types', 'chart_of_account_types.id', 'chart_of_accounts.type')
                ->where('chart_of_account_types.name', 'income')
                ->where('parent', '=', 0)
                ->where('chart_of_accounts.created_by', Auth::user()->creatorId())->get()
                ->pluck('code_name', 'id');
            $incomeChartAccounts->prepend('Select Account', 0);

            $incomeSubAccounts = ChartOfAccount::select(DB::raw('CONCAT(chart_of_accounts.code, " - ", chart_of_accounts.name) AS code_name,chart_of_accounts.id, chart_of_accounts.code, chart_of_account_parents.account'));
            $incomeSubAccounts->leftjoin('chart_of_account_parents', 'chart_of_accounts.parent', 'chart_of_account_parents.id');
            $incomeSubAccounts->leftjoin('chart_of_account_types', 'chart_of_account_types.id', 'chart_of_accounts.type');
            $incomeSubAccounts->where('chart_of_account_types.name', 'income');
            $incomeSubAccounts->where('chart_of_accounts.parent', '!=', 0);
            $incomeSubAccounts->where('chart_of_accounts.created_by', Auth::user()->creatorId());
            $incomeSubAccounts = $incomeSubAccounts->get()->toArray();
            $customFields = CustomField::where('created_by', '=', Auth::user()->creatorId())->where('module', '=', 'product')->get();


            $expenseChartAccounts = ChartOfAccount::select(DB::raw('CONCAT(chart_of_accounts.code, " - ", chart_of_accounts.name) AS code_name, chart_of_accounts.id as id'))
                ->leftjoin('chart_of_account_types', 'chart_of_account_types.id', 'chart_of_accounts.type')
                ->whereIn('chart_of_account_types.name', ['Expenses', 'Costs of Goods Sold'])
                ->where('chart_of_accounts.created_by', Auth::user()->creatorId())->get()
                ->pluck('code_name', 'id');
            $expenseChartAccounts->prepend('Select Account', '');

            $expenseSubAccounts = ChartOfAccount::select(DB::raw('CONCAT(chart_of_accounts.code, " - ", chart_of_accounts.name) AS code_name,chart_of_accounts.id, chart_of_accounts.code, chart_of_account_parents.account'));
            $expenseSubAccounts->leftjoin('chart_of_account_parents', 'chart_of_accounts.parent', 'chart_of_account_parents.id');
            $expenseSubAccounts->leftjoin('chart_of_account_types', 'chart_of_account_types.id', 'chart_of_accounts.type');
            $expenseSubAccounts->whereIn('chart_of_account_types.name', ['Expenses', 'Costs of Goods Sold']);
            $expenseSubAccounts->where('chart_of_accounts.parent', '!=', 0);
            $expenseSubAccounts->where('chart_of_accounts.created_by', Auth::user()->creatorId());
            $expenseSubAccounts = $expenseSubAccounts->get()->toArray();
            $quantityUnitCode = QuantityUnitCode::all()->pluck('name', 'code');
            $quantityUnitCodes = QuantityUnitCode::all()->pluck('name', 'code');
            $packagingUnitCodes = ProductServicesPackagingUnit::all()->pluck('name', 'code');
            $category = ProductServiceCategory::all()->pluck('name', 'id');
            $category->prepend('Select Category', '');
            return view(
                'productservice.create',
                compact(
                    'itemclassifications',
                    'itemtypes',
                    'countries',
                    'incomeChartAccounts',
                    'incomeSubAccounts',
                    'expenseChartAccounts',
                    'expenseSubAccounts',
                    'quantityUnitCode',
                    'quantityUnitCodes',
                    'packagingUnitCodes',
                    'taxationtype',
                    'category',
                    'customFields'
                )
            );
        } catch (Exception $e) {
            Log::error('CREATE PRODUCT / SERVICE ERROR');
            Log::error($e);

            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    /**
     * Store a newly created resource in storage.
     * key Note is This We can Post the item First to the Etims Apis 
     * Then Get Items to post in our Local Database for synchronizing with the correct Etims ItemCd
     * 
     *  OR
     * 
     * we can do both Post the eTIMS aPIS and also in our Local Db but for this the itemCd Will not match so,
     * it will be diffcult for edit  the product
     * 
     */


    public function store(Request $request)
    {
        //retrievie the Api endpoint config from the database that is api_url and api_key  
        $config = ConfigSettings::first();
        try {
            $data = $request->all();

            Log::info("Data from the Form creating new Product and Service : ");
            Log::info($data);

            $validator = \Validator::make(
                $data,
                [
                    'items' => 'required|array',
                    'items.*.itemCode' => 'required',
                    'items.*.itemClassifiCode' => 'required',
                    'items.*.itemTypeCode' => 'required',
                    'items.*.itemName' => 'required',
                    'items.*.sale_price' => 'required',
                    'items.*.purchase_price' => 'required',
                    'items.*.itemStrdName' => 'required',
                    'items.*.countryCode' => 'required',
                    'items.*.pkgUnitCode' => 'required',
                    'items.*.qtyUnitCode' => 'required',
                    'items.*.taxTypeCode' => 'required',
                    'items.*.batchNo' => 'nullable',
                    'items.*.barcode' => 'nullable',
                    'items.*.saftyQuantity' => 'required',
                    'items.*.isInrcApplicable' => 'required',
                    'items.*.isUsed' => 'required',
                    'items.*.packageQuantity' => 'required',
                    'items.*.category_id' => 'required',
                    'items.*.sale_chartaccount_id' => 'required',
                    'items.*.expense_chartaccount_id' => 'required',
                    'items.*.pro_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
                    'items.*.additionalInfo' => 'required',
                    'items.*.quantity' => 'nullable',
                    'items.*.unitPrice' => 'required',
                    'items.*.group1UnitPrice' => 'nullable',
                    'items.*.group2UnitPrice' => 'nullable',
                    'items.*.group3UnitPrice' => 'nullable',
                    'items.*.group4UnitPrice' => 'nullable',
                    'items.*.group5UnitPrice' => 'nullable',
                ]
            );

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            if (Auth::user()->type == 'company' || Auth::user()->type == 'accountant') {
                Log::info('CREATE PRODUCT SERVICE REQUEST DATA');
                Log::info(json_encode($request->all(), JSON_PRETTY_PRINT));

                Log::info('ITEMS');
                Log::info(json_encode($data['items'], JSON_PRETTY_PRINT));

                $apiData = [];
                $localProducts = [];

                foreach ($data['items'] as $index => $item) {
                    Log::info('Product & Service Item Index: ' . $index);

                    $taxTypeId = null;
                    if (isset($item['taxTypeCode'])) {
                        $taxType = Tax::where('name', $item['taxTypeCode'])->first();
                        $taxTypeId = $taxType ? $taxType->srtOrd : null;
                    }

                    $productTypeMapping = null;
                    if (isset($item['itemTypeCode'])) {
                        $ItemTypeCode = ItemType::where('item_type_code', $item['itemTypeCode'])->first();
                        $productTypeMapping = $ItemTypeCode ? $ItemTypeCode->item_type_name : null;
                    }

                    $unitId = null;
                    if (isset($item['qtyUnitCode'])) {
                        $unit = ProductServiceUnit::where('code', $item['qtyUnitCode'])->first();
                        $unitId = $unit ? $unit->id : null;
                    }

                    // Handling image upload with storage limit check
                    if (!empty($item['pro_image']) && $item['pro_image']->isValid()) {
                        Log::info('Image File Object for Item ' . ($index + 1));
                        $image_size = $item['pro_image']->getSize();
                        $result = Utility::updateStorageLimit(Auth::user()->creatorId(), $image_size);

                        if ($result == 1) {
                            $fileName = $item['pro_image']->getClientOriginalName();
                            $dir = 'uploads/pro_image';
                            $path = Utility::upload_file($item, 'pro_image', $fileName, $dir, []);

                            Log::info('Product image path:', $path);

                            // Assign the file name to the pro_image field
                            $item['pro_image'] = $fileName;
                        } else {
                            Log::info('Storage limit exceeded for user ' . Auth::user()->creatorId());
                            return redirect()->back()->with('error', 'Storage limit exceeded.');
                        }
                    } else {
                        Log::info('No valid image uploaded for item ' . ($index + 1));
                    }

                    // Prepare data for the API to post product & service
                    $apiData[] = $this->constructProductData($item, $index);

                    // Store the item data locally for later use
                    $localProducts[$item['itemCode']] = [
                        'name' => $item['itemName'] ?? null,
                        'sku' => $item['itemCode'] ?? null,
                        'sale_price' => $item['sale_price'] ?? null,
                        'purchase_price' => $item['purchase_price'] ?? null,
                        'tax_id' => $taxTypeId,
                        'category_id' => $item['category_id'] ?? null,
                        'unit_id' => $unitId ?? null,
                        'type' => $productTypeMapping ?? null,
                        'quantity' => $item['quantity'],
                        'description' => $item['additionalInfo'] ?? null,
                        'pro_image' => isset($fileName) ? ($dir . '/' . $fileName) : null,
                        'sale_chartaccount_id' => $item['sale_chartaccount_id'] ?? null,
                        'expense_chartaccount_id' => $item['expense_chartaccount_id'] ?? null,
                        'created_by' => Auth::user()->creatorId(),
                        'tin' => $item['tin'] ?? null,
                        'itemCd' => $item['itemCode'],
                        'itemClsCd' => $item['itemClassifiCode'],
                        'itemTyCd' => $item['itemTypeCode'],
                        'itemNm' => $item['itemName'],
                        'itemStdNm' => $item['itemStrdName'],
                        'orgnNatCd' => $item['countryCode'] ?? null,
                        'pkgUnitCd' => $item['pkgUnitCode'] ?? null,
                        'qtyUnitCd' => $item['qtyUnitCode'] ?? null,
                        'taxTyCd' => $item['taxTypeCode'] ?? null,
                        'btchNo' => $item['batchNo'] ?? null,
                        'regBhfId' => $item['regBhfId'] ?? null,
                        'bcd' => $item['barcode'] ?? null,
                        'dftPrc' => $item['unitPrice'] ?? null,
                        'grpPrcL1' => $item['group1UnitPrice'] ?? null,
                        'grpPrcL2' => $item['group2UnitPrice'] ?? null,
                        'grpPrcL3' => $item['group3UnitPrice'] ?? null,
                        'grpPrcL4' => $item['group4UnitPrice'] ?? null,
                        'grpPrcL5' => $item['group5UnitPrice'] ?? null,
                        'addInfo' => $item['additionalInfo'] ?? null,
                        'sftyQty' => $item['saftyQuantity'] ?? null,
                        'isrcAplcbYn' => $item['isInrcApplicable'] ?? null,
                        'rraModYn' => $item['rraModYn'] ?? null,
                        'packageQuantity' => $item['packageQuantity'] ?? null,
                        'isUsed' => $item['isUsed'] ?? null,

                        // Initialize KRA product response fields
                        'kraItemCode' => '',
                        'isKRASync' => '',
                        'isStockIO' => '',
                    ];
                }

                $config = ConfigSettings::first();

                $url = $config->api_url . 'AddItemsListV2';

                $response = Http::withOptions([
                    'verify' => false
                ])->withHeaders([
                            'Accept' => 'application/json',
                            'Content-Type' => 'application/json',
                            'key' => $config->api_key
                        ])->post($config->api_url . 'AddItemsListV2', $apiData);

                // Log response data
                \Log::info('API Response Status Code For Posting Product Data: ' . $response->status());
                \Log::info('API Request Product Data Posted: ' . json_encode($apiData));
                \Log::info('API Response Body For Posting Product Data: ' . $response->body());

                if ($response->successful()) {
                    Log::info('Data successfully posted to the API');

                    $responseData = $response->json();
                    if (isset($responseData['responseData']) && is_array($responseData['responseData'])) {
                        foreach ($responseData['responseData'] as $responseItem) {
                            $itemCode = $responseItem['itemCode'];
                            if (isset($localProducts[$itemCode])) {
                                $localProducts[$itemCode]['kraItemCode'] = $responseItem['kraItemCode'];
                                $localProducts[$itemCode]['isKRASync'] = $responseItem['isKRASync'];
                                $localProducts[$itemCode]['isStockIO'] = $responseItem['isStockIO'];
                                // Insert or update the product in the local database
                                DB::table('product_services')->updateOrInsert(
                                    ['itemCd' => $itemCode],
                                    $localProducts[$itemCode]
                                );
                            }
                        }
                    }

                    return redirect()->route('productservice.index')->with('success', 'Product & Service successfully created.');
                } else {

                    // Handle different response status codes
                    if ($response->status() === 200) {
                        $responseBody = $response->json();
                        Log::error('Error posting data to the API: ' . json_encode($responseBody));

                        // Extract message from response and redirect
                        $errorMessage = $responseBody['message'] ?? 'Bad Request';
                        return redirect()->route('productservice.index')->with('error', $errorMessage);
                    } elseif ($response->status() === 400) {
                        return redirect()->route('productservice.index')->with('error', 'Not Found');
                    } elseif ($response->status() === 404) {
                        return redirect()->route('productservice.index')->with('error', 'API Endpoint Not Found');
                    } elseif ($response->status() === 500) {
                        return redirect()->route('productservice.index')->with('error', 'Internal Server Error');
                    } else {
                        return redirect()->route('productservice.index')->with('error', 'Unexpected Error');
                    }
                }
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } catch (\Exception $e) {
            Log::error('CREATE PRODUCT SERVICE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    private function constructProductData($item, $key)
    {
        return [
            "itemCode" => $item["itemCode"],
            "itemClassifiCode" => $item["itemClassifiCode"],
            "itemTypeCode" => $item["itemTypeCode"],
            "itemName" => $item["itemName"],
            "itemStrdName" => $item["itemStrdName"],
            "countryCode" => $item["countryCode"],
            "pkgUnitCode" => $item["pkgUnitCode"],
            "qtyUnitCode" => $item["qtyUnitCode"],
            "taxTypeCode" => $item["taxTypeCode"],
            "batchNo" => $item["batchNo"],
            "barcode" => $item["barcode"],
            "unitPrice" => $item["unitPrice"],
            "group1UnitPrice" => $item["group1UnitPrice"],
            "group2UnitPrice" => $item["group2UnitPrice"],
            "group3UnitPrice" => $item["group3UnitPrice"],
            "group4UnitPrice" => $item["group4UnitPrice"],
            "group5UnitPrice" => $item["group5UnitPrice"],
            "additionalInfo" => $item["additionalInfo"],
            "saftyQuantity" => $item["saftyQuantity"],
            "isInrcApplicable" => $item["isInrcApplicable"],
            "isUsed" => $item["isUsed"],
            "quantity" => $item["quantity"],
            "packageQuantity" => $item["packageQuantity"],
        ];
    }

    public function show($id)
    {
        try {
            $productServiceInfo = ProductService::findOrFail($id);
            $taxName = DB::table('taxes')->where('id', $productServiceInfo->tax_id)->value('name');
            $categoryName = DB::table('product_service_categories')->where('id', $productServiceInfo->category_id)->value('name');
            $unitName = DB::table('product_service_units')->where('id', $productServiceInfo->unit_id)->value('name');
            $saleChartAccountName = DB::table('chart_of_accounts')->where('id', $productServiceInfo->sale_chartaccount_id)->value('name');
            $expenseChartAccounName = DB::table('chart_of_accounts')->where('id', $productServiceInfo->expense_chartaccount_id)->value('name');

            return view(
                'productservice.show',
                compact(
                    'productServiceInfo',
                    'taxName',
                    'categoryName',
                    'unitName',
                    'saleChartAccountName',
                    'expenseChartAccounName'
                )
            );
        } catch (Exception $e) {
            Log::error('SHOW PRODUCT / SERVICE ERROR');
            Log::error($e);

            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }

    public function getItem($code)
    {
        try {
            $iteminformation = ProductService::where('itemCd', $code)->first();
            return response()->json([
                'message' => 'success',
                'data' => $iteminformation
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'error',
                'data' => $e->getMessage()
            ]);
        }
    }

    public function update(Request $request, $id)
    {
        $config = ConfigSettings::first();
        $iteminformation = ProductService::find($id);
        Log::info('Product Service INFO being edited :', ['item' => $iteminformation]);
        try {

            $validator = \Validator::make(
                $request->all(),
                [
                    'itemCd' => 'required',
                    'itemClsCd' => 'required',
                    'itemTyCd' => 'required',
                    'itemNm' => 'required',
                    'itemStdNm' => 'required',
                    'orgnNatCd' => 'required',
                    'pkgUnitCd' => 'required',
                    'qtyUnitCd' => 'required',
                    'taxTyCd' => 'required',
                    'dftPrc' => 'required',
                    'isrcAplcbYn' => 'nullable',
                    'bcd' => 'nullable',
                    'btchNo' => 'nullable',
                    'isUsed' => 'required',
                    'grpPrcL1' => 'nullable',
                    'grpPrcL2' => 'nullable',
                    'grpPrcL3' => 'nullable',
                    'grpPrcL4' => 'nullable',
                    'grpPrcL5' => 'nullable',
                    'packageQuantity' => 'nullable',
                    'sftyQty' => 'nullable'
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }


            $data = $request->all();
            Log::info('Product Service INFO being edited and posted to the API:', $data);

            $reqData = [
                "itemCode" => 'AS2BZBX0005019',
                "itemClassifiCode" => $data['itemClsCd'],
                "itemTypeCode" => $data['itemTyCd'],
                "itemName" => $data['itemNm'],
                "itemStrdName" => $data['itemStdNm'],
                "countryCode" => $data['orgnNatCd'],
                "pkgUnitCode" => $data['pkgUnitCd'],
                "qtyUnitCode" => $data['qtyUnitCd'],
                "taxTypeCode" => $data['taxTyCd'],
                "batchNo" => $data['btchNo'],
                "barcode" => $data['bcd'],
                "unitPrice" => $data['dftPrc'],
                "group1UnitPrice" => $data['grpPrcL1'],
                "group2UnitPrice" => $data['grpPrcL2'],
                "group3UnitPrice" => $data['grpPrcL3'],
                "group4UnitPrice" => $data['grpPrcL4'],
                "group5UnitPrice" => $data['grpPrcL5'],
                "additionalInfo" => $data['addInfo'],
                "saftyQuantity" => $data['sftyQty'],
                "isInrcApplicable" => (bool) $data['isrcAplcbYn'],
                "isUsed" => (bool) $data['isUsed'],
                "packageQuantity" => $data['packageQuantity'],
            ];

            $config = ConfigSettings::first();

            $url = $config->api_url . 'UpdateItemV2';

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                        'Accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'key' => $config->api_key
                    ])->post($config->api_url . 'UpdateItemV2', $reqData);

            $res = $response->json();

            if ($res['statusCode'] != 200) {
                return redirect()->route('productservice.index')->with('error', 'Error updating Item Information.');
            } elseif ($res['statusCode'] == 500) {
                return redirect()->route('productservice.index')->with('error', 'Internal Server Error.An error occurred while sending the request.');
            }

            // Mapping array for taxTypeCode to tax_id
            $taxTypeMapping = [
                'A' => 1,
                'B' => 2,
                'C' => 3,
                'D' => 4,
                'E' => 5,
                'F' => 6,
            ];
            $productTypeMapping = [
                1 => 'Raw Material',
                2 => 'Finished Product',
                3 => 'Service',
            ];

            // Determine the tax_id based on taxTypeCode
            $taxIdCode = isset($data['taxTyCd']) && array_key_exists($data['taxTyCd'], $taxTypeMapping)
                ? $taxTypeMapping[$data['taxTyCd']]
                : null;


            // Determine the product type  based on itemTypeCode
            $productType = isset($item['itemTypeCode']) && array_key_exists($data['itemTypeCode'], $productTypeMapping)
                ? $productTypeMapping[$data['itemTypeCode']]
                : null;

            Log::info('Product Type selected for this Product : ' . $productType);

            // Handling image upload with storage limit check
            if (!empty($data['pro_image']) && $data['pro_image']->isValid()) {
                Log::info('Image File Object for Item being edited');
                $image_size = $data['pro_image']->getSize();
                $result = Utility::updateStorageLimit(Auth::user()->creatorId(), $image_size);

                if ($result == 1) {
                    $fileName = $data['pro_image']->getClientOriginalName();
                    $dir = 'uploads/pro_image';
                    $path = Utility::upload_file($data, 'pro_image', $fileName, $dir, []);

                    Log::info('PATH');
                    Log::info($path);

                    // Update the product Service information including the new image name
                    $iteminformation->update([
                        'name' => $data['itemNm'] ?? null,
                        'sku' => $data['itemCode'] ?? null,
                        'sale_price' => $data['sale_price'] ?? null,
                        'purchase_price' => $data['purchase_price'] ?? null,
                        'tax_id' => $taxIdCode,
                        'category_id' => $data['category_id'] ?? null,
                        'unit_id' => $taxIdCode ?? null,
                        'type' => $productType ?? null,
                        'quantity' => $data['quantity'] ?? null,
                        'description' => $data['additionalInfo'] ?? null,
                        'pro_image' => $dir . '/' . $fileName ?? null,
                        'sale_chartaccount_id' => $data['sale_chartaccount_id'] ?? null,
                        'expense_chartaccount_id' => $data['expense_chartaccount_id'] ?? null,
                        'created_by' => Auth::user()->creatorId(),
                        'tin' => $data['tin'] ?? null,
                        'itemCd' => $data['itemCd'] ?? null,
                        'itemClsCd' => $data['itemClsCd'],
                        'itemTyCd' => $data['itemTyCd'],
                        'itemNm' => $data['itemNm'],
                        'itemStdNm' => $data['itemStdNm'],
                        'orgnNatCd' => $data['orgnNatCd'] ?? null,
                        'pkgUnitCd' => $data['pkgUnitCd'] ?? null,
                        'qtyUnitCd' => $data['qtyUnitCd'] ?? null,
                        'taxTyCd' => $data['taxTypCd'] ?? null,
                        'btchNo' => $data['btchNo'] ?? null,
                        'regBhfId' => $data['regBhfId'] ?? null,
                        'bcd' => $data['bcd'] ?? null,
                        'dftPrc' => $data['dftPrc'] ?? null,
                        'grpPrcL1' => $data['grpPrcL1'] ?? null,
                        'grpPrcL2' => $data['grpPrcL2'] ?? null,
                        'grpPrcL3' => $data['grpPrcL3'] ?? null,
                        'grpPrcL4' => $data['grpPrcL4'] ?? null,
                        'grpPrcL5' => $data['grpPrcL5'] ?? null,
                        'addInfo' => $data['addInfo'] ?? null,
                        'sftyQty' => $data['sftyQty'] ?? null,
                        'isrcAplcbYn' => $data['isrcAplcbYn'] ?? null,
                        'rraModYn' => $data['rraModYn'] ?? null,
                        'packageQuantity' => $data['packageQuantity'] ?? null,
                        'useYn' => $data['useYn'] ?? null,
                        'isUsed' => $data['isUsed'] ?? null,
                    ]);
                } else {
                    Log::info('Storage limit exceeded for user ' . Auth::user()->creatorId());
                    return redirect()->back()->with('error', 'Storage limit exceeded.');
                }
            } else {
                // Update the Product Service information without changing the image
                $iteminformation->update([
                    'name' => $data['itemNm'] ?? null,
                    'sku' => $data['itemCode'] ?? null,
                    'sale_price' => $data['sale_price'] ?? null,
                    'purchase_price' => $data['purchase_price'] ?? null,
                    'tax_id' => $taxIdCode,
                    'category_id' => $data['category_id'] ?? null,
                    'unit_id' => $taxIdCode ?? null,
                    'type' => $productType ?? null,
                    'quantity' => $data['quantity'] ?? null,
                    'description' => $data['additionalInfo'] ?? null,
                    'sale_chartaccount_id' => $data['sale_chartaccount_id'] ?? null,
                    'expense_chartaccount_id' => $data['expense_chartaccount_id'] ?? null,
                    'created_by' => Auth::user()->creatorId(),
                    'tin' => $data['tin'] ?? null,
                    'itemCd' => $data['itemCd'],
                    'itemClsCd' => $data['itemClsCd'],
                    'itemTyCd' => $data['itemTyCd'],
                    'itemNm' => $data['itemNm'],
                    'itemStdNm' => $data['itemStdNm'],
                    'orgnNatCd' => $data['orgnNatCd'] ?? null,
                    'pkgUnitCd' => $data['pkgUnitCd'] ?? null,
                    'qtyUnitCd' => $data['qtyUnitCd'] ?? null,
                    'taxTyCd' => $data['taxTypCd'] ?? null,
                    'btchNo' => $data['btchNo'] ?? null,
                    'regBhfId' => $data['regBhfId'] ?? null,
                    'bcd' => $data['bcd'] ?? null,
                    'dftPrc' => $data['dftPrc'] ?? null,
                    'grpPrcL1' => $data['grpPrcL1'] ?? null,
                    'grpPrcL2' => $data['grpPrcL2'] ?? null,
                    'grpPrcL3' => $data['grpPrcL3'] ?? null,
                    'grpPrcL4' => $data['grpPrcL4'] ?? null,
                    'grpPrcL5' => $data['grpPrcL5'] ?? null,
                    'addInfo' => $data['addInfo'] ?? null,
                    'sftyQty' => $data['sftyQty'] ?? null,
                    'isrcAplcbYn' => $data['isrcAplcbYn'] ?? null,
                    'rraModYn' => $data['rraModYn'] ?? null,
                    'packageQuantity' => $data['packageQuantity'] ?? null,
                    'useYn' => $data['useYn'] ?? null,
                    'isUsed' => $data['isUsed'] ?? null,
                ]);
            }

            return redirect()->route('productservice.index')->with('success', 'Product / Service Updated Successfully');
        } catch (\Exception $e) {
            Log::error('UPDATE PRODUCT SERVICE ERROR', ['exception' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            return redirect()->back()->with('error', 'Something Went Wrong');
        }
    }
    public function edit($id)
    {
        if (
            Auth::user()->type == 'company'
            || Auth::user()->type == 'accountant'
        ) {
            $productServiceinformation = ProductService::find($id);

            $productServiceclassifications = ProductsServicesClassification::pluck('itemClsNm', 'itemClsCd');
            $itemtypes = ItemType::pluck('item_type_name', 'item_type_code');
            Log::info($itemtypes);
            $countrynames = Details::where('cdCls', '05')->pluck('cdNm', 'cd');
            $taxationtype = Details::where('cdCls', '04')->pluck('cdNm', 'cd');


            $category = ProductServiceCategory::where('created_by', '=', Auth::user()->creatorId())->where('type', '=', 'product & service')->get()->pluck('name', 'id');
            $unit = ProductServiceUnit::where('created_by', '=', Auth::user()->creatorId())->get()->pluck('name', 'id');
            $tax = Tax::where('created_by', '=', Auth::user()->creatorId())->get()->pluck('name', 'id');
            $incomeChartAccounts = ChartOfAccount::select(DB::raw('CONCAT(chart_of_accounts.code, " - ", chart_of_accounts.name) AS code_name, chart_of_accounts.id as id'))
                ->leftjoin('chart_of_account_types', 'chart_of_account_types.id', 'chart_of_accounts.type')
                ->where('chart_of_account_types.name', 'income')
                ->where('parent', '=', 0)
                ->where('chart_of_accounts.created_by', Auth::user()->creatorId())->get()
                ->pluck('code_name', 'id');
            $incomeChartAccounts->prepend('Select Account', 0);
            $incomeSubAccounts = ChartOfAccount::select('chart_of_accounts.id', 'chart_of_accounts.code', 'chart_of_accounts.name', 'chart_of_account_parents.account');
            $incomeSubAccounts->leftjoin('chart_of_account_parents', 'chart_of_accounts.parent', 'chart_of_account_parents.id');
            $incomeSubAccounts->leftjoin('chart_of_account_types', 'chart_of_account_types.id', 'chart_of_accounts.type');
            $incomeSubAccounts->where('chart_of_account_types.name', 'income');
            $incomeSubAccounts->where('chart_of_accounts.parent', '!=', 0);
            $incomeSubAccounts->where('chart_of_accounts.created_by', Auth::user()->creatorId());
            $incomeSubAccounts = $incomeSubAccounts->get()->toArray();
            $expenseChartAccounts = ChartOfAccount::select(DB::raw('CONCAT(chart_of_accounts.code, " - ", chart_of_accounts.name) AS code_name, chart_of_accounts.id as id'))
                ->leftjoin('chart_of_account_types', 'chart_of_account_types.id', 'chart_of_accounts.type')
                ->whereIn('chart_of_account_types.name', ['Expenses', 'Costs of Goods Sold'])
                ->where('chart_of_accounts.created_by', Auth::user()->creatorId())->get()
                ->pluck('code_name', 'id');
            $expenseChartAccounts->prepend('Select Account', '');
            $expenseSubAccounts = ChartOfAccount::select('chart_of_accounts.id', 'chart_of_accounts.code', 'chart_of_accounts.name', 'chart_of_account_parents.account');
            $expenseSubAccounts->leftjoin('chart_of_account_parents', 'chart_of_accounts.parent', 'chart_of_account_parents.id');
            $expenseSubAccounts->leftjoin('chart_of_account_types', 'chart_of_account_types.id', 'chart_of_accounts.type');
            $expenseSubAccounts->whereIn('chart_of_account_types.name', ['Expenses', 'Costs of Goods Sold']);
            $expenseSubAccounts->where('chart_of_accounts.parent', '!=', 0);
            $expenseSubAccounts->where('chart_of_accounts.created_by', Auth::user()->creatorId());
            $expenseSubAccounts = $expenseSubAccounts->get()->toArray();
            $customFields = CustomField::where('created_by', '=', Auth::user()->creatorId())->where('module', '=', 'product')->get();





            return view(
                'productservice.edit',
                compact(
                    'productServiceclassifications',
                    'itemtypes',
                    'countrynames',
                    'taxationtype',
                    'category',
                    'unit',
                    'tax',
                    'productServiceinformation',
                    'customFields',

                    'incomeChartAccounts',
                    'expenseChartAccounts',
                    'incomeSubAccounts',
                    'expenseSubAccounts'
                )
            );
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (
            Auth::user()->type == 'company'
            || Auth::user()->type == 'accountant'
        ) {
            $productService = ProductService::find($id);
            if ($productService->created_by == Auth::user()->creatorId()) {
                if (!empty($productService->pro_image)) {
                    //storage limit
                    $file_path = '/uploads/pro_image/' . $productService->pro_image;
                    $result = Utility::changeStorageLimit(Auth::user()->creatorId(), $file_path);
                }

                $productService->delete();

                return redirect()->route('productservice.index')->with('success', __('Product successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function export()
    {
        $name = 'product_service_' . date('Y-m-d i:h:s');
        $data = Excel::download(new ProductServiceExport(), $name . '.xlsx');

        return $data;
    }

    public function importFile()
    {
        return view('productservice.import');
    }
    /****
  public function import(Request $request)
  {
      $rules = [
          'file' => 'required',
      ];

      $validator = \Validator::make($request->all(), $rules);

      if ($validator->fails()) {
          $messages = $validator->getMessageBag();

          return redirect()->back()->with('error', $messages->first());
      }
      $products = (new ProductServiceImport)->toArray(request()->file('file'))[0];
      $totalProduct = count($products) - 1;
      $errorArray = [];
      for ($i = 1; $i <= count($products) - 1; $i++) {
          $items = $products[$i];

          $taxes = explode(';', $items[5]);

          $taxesData = [];
          foreach ($taxes as $tax) {
              $taxes = Tax::where('id', $tax)->first();
              //                $taxesData[] = $taxes->id;
              $taxesData[] = !empty($taxes->id) ? $taxes->id : 0;


          }

          $taxData = implode(',', $taxesData);
          //            dd($taxData);

          if (!empty($productBySku)) {
              $productService = $productBySku;
          } else {
              $productService = new ProductService();
          }

          $productService->name = $items[0];
          $productService->sku = $items[1];
          $productService->sale_price = $items[2];
          $productService->purchase_price = $items[3];
          $productService->quantity = $items[4];
          $productService->tax_id = $items[5];
          $productService->category_id = $items[6];
          $productService->unit_id = $items[7];
          $productService->type = $items[8];
          $productService->description = $items[9];
          $productService->created_by = Auth::user()->creatorId();

          if (empty($productService)) {
              $errorArray[] = $productService;
          } else {
              $productService->save();
          }
      }

      $errorRecord = [];
      if (empty($errorArray)) {

          $data['status'] = 'success';
          $data['msg'] = __('Record successfully imported');
      } else {
          $data['status'] = 'error';
          $data['msg'] = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalProduct . ' ' . 'record');


          foreach ($errorArray as $errorData) {

              $errorRecord[] = implode(',', $errorData);
          }

          \Session::put('errorArray', $errorRecord);
      }

      return redirect()->back()->with($data['status'], $data['msg']);
  }
     ***/

    public function import(Request $request)
    {
        $config = ConfigSettings::first();
        $rules = [
            'file' => 'required',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        // Read and process the CSV file
        $products = (new ProductServiceImport)->toArray(request()->file('file'))[0];

        // Construct the data array in the required JSON format
        $jsonData = [];
        foreach ($products as $product) {
            $jsonData[] = [
                'created_by' => Auth::user()->creatorId(),
                "itemCode" => $product[0],
                "itemClassifiCode" => $product[1],
                "itemTypeCode" => $product[2],
                "itemName" => $product[3],
                "itemStrdName" => $product[4],
                "countryCode" => $product[5],
                "pkgUnitCode" => $product[6],
                "qtyUnitCode" => $product[7],
                "taxTypeCode" => $product[8],
                "batchNo" => $product[9],
                "barcode" => $product[10],
                "unitPrice" => (float) $product[11],
                "group1UnitPrice" => (float) $product[12],
                "group2UnitPrice" => (float) $product[13],
                "group3UnitPrice" => (float) $product[14],
                "group4UnitPrice" => (float) $product[15],
                "group5UnitPrice" => (float) $product[16],
                "additionalInfo" => $product[17],
                "saftyQuantity" => (int) $product[18],
                "isInrcApplicable" => (bool) $product[19],
                "isUsed" => (bool) $product[20],
                "openingBalance" => (float) $product[21],
                "packageQuantity" => (int) $product[22]
            ];
        }

        $url = $config->api_url . 'SaveItemsV2';

        $response = Http::withHeaders([
            'accept' => '*/*',
            'key' => $config->api_key,
            'Content-Type' => 'application/json-patch+json',
        ])->post($url, $jsonData);

        // Log the API response
        \Log::info('API Request Data: ' . json_encode($jsonData));
        \Log::info('API Response: ' . $response->body());
        \Log::info('API Response Status Code: ' . $response->status());

        // Check if API call was successful
        if ($response->successful()) {
            return redirect()->route('productservice.index')->with('success', __('Data imported and posted to API successfully.'));
        } else {
            // If API call failed, log error and handle error message
            \Log::error('API Error: ' . $response->body());

            // Get the error message from the API response
            $errorMessage = $response->json()['message'] ?? __('Failed to import data or post to API.');

            // Check if there are any failed products
            if (!empty($jsonData)) {
                // There are failed products, so return with error message
                return redirect()->back()->with('error', $errorMessage)->with('failedProducts', $jsonData);
            } else {
                // No products were imported, so just return with error message
                return redirect()->back()->with('error', $errorMessage);
            }
        }
    }


    public function warehouseDetail($id)
    {
        $products = WarehouseProduct::with(['warehouse'])->where('product_id', '=', $id)->where('created_by', '=', Auth::user()->creatorId())->get();
        return view('productservice.detail', compact('products'));
    }

    public function searchProducts(Request $request)
    {

        $lastsegment = $request->session_key;

        if (Auth::user()->type == 'company' && $request->ajax() && isset($lastsegment) && !empty($lastsegment)) {

            $output = "";
            if ($request->war_id == '0') {
                $ids = WarehouseProduct::where('warehouse_id', 1)->get()->pluck('product_id')->toArray();

                if ($request->cat_id !== '' && $request->search == '') {
                    if ($request->cat_id == '0') {
                        $products = ProductService::getallproducts()->whereIn('product_services.id', $ids)->get();
                    } else {
                        $products = ProductService::getallproducts()->where('category_id', $request->cat_id)->whereIn('product_services.id', $ids)->get();
                    }
                } else {
                    if ($request->cat_id == '0') {
                        $products = ProductService::getallproducts()->where('product_services.name', 'LIKE', "%{$request->search}%")->get();
                    } else {
                        $products = ProductService::getallproducts()->where('product_services.name', 'LIKE', "%{$request->search}%")->orWhere('category_id', $request->cat_id)->get();
                    }
                }
            } else {
                $ids = WarehouseProduct::where('warehouse_id', $request->war_id)->get()->pluck('product_id')->toArray();

                if ($request->cat_id == '0') {
                    $products = ProductService::getallproducts()->whereIn('product_services.id', $ids)->with(['unit'])->get();
                } else {
                    $products = ProductService::getallproducts()->whereIn('product_services.id', $ids)->where('category_id', $request->cat_id)->with(['unit'])->get();
                }
            }

            if (count($products) > 0) {
                foreach ($products as $key => $product) {
                    $quantity = $product->warehouseProduct($product->id, $request->war_id != 0 ? $request->war_id : 1);

                    $unit = (!empty($product) && !empty($product->unit)) ? $product->unit->name : '';

                    if (!empty($product->pro_image)) {
                        $image_url = ('uploads/pro_image') . '/' . $product->pro_image;
                    } else {
                        $image_url = ('uploads/pro_image') . '/default.png';
                    }
                    if ($request->session_key == 'purchases') {
                        $productprice = $product->purchase_price != 0 ? $product->purchase_price : 0;
                    } else if ($request->session_key == 'pos') {
                        $productprice = $product->dftPrc != 0 ? $product->dftPrc : 0;
                    } else {
                        $productprice = $product->dftPrc != 0 ? $product->dftPrc : $product->purchase_price;
                    }

                    $output .= '

                            <div class="col-lg-2 col-md-2 col-sm-3 col-xs-4 col-12">
                                <div class="tab-pane fade show active toacart w-100" data-url="' . url('add-to-cart/' . $product->id . '/' . $lastsegment) . '">
                                    <div class="position-relative card">
                                        <img alt="Image placeholder" src="' . asset(Storage::url($image_url)) . '" class="shadow card-image avatar hover-shadow-lg" style=" height: 6rem; width: 100%;">
                                        <div class="p-0 custom-card-body card-body d-flex ">
                                            <div class="p-2 my-2 text-left card-body card-bottom-content">
                                                <h6 class="mb-2 text-dark product-title-name">' . $product->name . '</h6>
                                                <small class="mb-0 badge badge-primary">' . Auth::user()->priceFormat($productprice) . '</small>

                                                <small class="mb-0 top-badge badge badge-danger">' . $quantity . ' ' . $unit . '</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                    ';
                }

                return Response($output);
            } else {
                $output = '<div class="text-center card card-body col-12">
                    <h5>' . __("No Product Available") . '</h5>
                    </div>';
                return Response($output);
            }
        }
    }

    public function addToCart(Request $request, $id, $session_key)
    {

        try {
            if (
                Auth::user()->type == 'company'
                || Auth::user()->type == 'accountant'
                && $request->ajax()
            ) {
                $product = WarehouseProduct::where('product_id', $id)->first();
                $productquantity = 0;

                if ($product) {
                    $productquantity = $product->quantity;
                }

                if (!$product || ($session_key == 'pos' && $productquantity == 0)) {
                    return response()->json(
                        [
                            'code' => 404,
                            'status' => 'Error',
                            'error' => __('This product is out of stock!'),
                        ],
                        404
                    );
                }

                $productname = $product->name;

                if ($session_key == 'purchases') {

                    $productprice = $product->purchase_price != 0 ? $product->purchase_price : 0;
                } else if ($session_key == 'pos') {

                    $productprice = $product->sale_price != 0 ? $product->sale_price : 0;
                } else {

                    $productprice = $product->sale_price != 0 ? $product->sale_price : $product->purchase_price;
                }

                $originalquantity = (int) $productquantity;

                $taxes = Utility::tax($product->tax_id);

                $totalTaxRate = Utility::totalTaxRate($product->tax_id);

                $product_tax = '';
                $product_tax_id = [];
                foreach ($taxes as $tax) {
                    $product_tax .= !empty($tax) ? "<span class='badge badge-primary'>" . $tax->name . ' (' . $tax->rate . '%)' . "</span><br>" : '';
                    $product_tax_id[] = !empty($tax) ? $tax->id : 0;
                }

                if (empty($product_tax)) {
                    $product_tax = "-";
                }
                $producttax = $totalTaxRate;


                $tax = ($productprice * $producttax) / 100;

                $subtotal = $productprice + $tax;
                $cart = session()->get($session_key);
                $image_url = (!empty($product->pro_image) && Storage::exists($product->pro_image)) ? $product->pro_image : 'uploads/pro_image/' . $product->pro_image;

                $model_delete_id = 'delete-form-' . $id;

                $carthtml = '';

                $carthtml .= '<tr data-product-id="' . $id . '" id="product-id-' . $id . '">
                                <td class="cart-images">
                                    <img alt="Image placeholder" src="' . asset(Storage::url($image_url)) . '" class="shadow card-image avatar hover-shadow-lg">
                                </td>
    
                                <td class="name">' . $productname . '</td>
    
                                <td class="">
                                       <span class="quantity buttons_added">
                                             <input type="button" value="-" class="minus">
                                             <input type="number" step="1" min="1" max="" name="quantity" title="' . __('Quantity') . '" class="input-number" size="4" data-url="' . url('update-cart/') . '" data-id="' . $id . '">
                                             <input type="button" value="+" class="plus">
                                       </span>
                                </td>
    
    
                                <td class="tax">' . $product_tax . '</td>
    
                                <td class="price">' . Auth::user()->priceFormat($productprice) . '</td>
    
                                <td class="subtotal">' . Auth::user()->priceFormat($subtotal) . '</td>
    
                                <td class="">
                                     <a href="#" class="action-btn bg-danger bs-pass-para-pos" data-confirm="' . __("Are You Sure?") . '" data-text="' . __("This action can not be undone. Do you want to continue?") . '" data-confirm-yes=' . $model_delete_id . ' title="' . __('Delete') . '}" data-id="' . $id . '" title="' . __('Delete') . '"   >
                                       <span class=""><i class="text-white ti ti-trash btn btn-sm"></i></span>
                                     </a>
                                     <form method="post" action="' . url('remove-from-cart') . '"  accept-charset="UTF-8" id="' . $model_delete_id . '">
                                          <input name="_method" type="hidden" value="DELETE">
                                          <input name="_token" type="hidden" value="' . csrf_token() . '">
                                          <input type="hidden" name="session_key" value="' . $session_key . '">
                                          <input type="hidden" name="id" value="' . $id . '">
                                     </form>
    
                                </td>
                            </td>';

                // if cart is empty then this the first product
                if (!$cart) {
                    $cart = [
                        $id => [
                            "name" => $productname,
                            "quantity" => 1,
                            "price" => $productprice,
                            "id" => $id,
                            "tax" => $producttax,
                            "subtotal" => $subtotal,
                            "originalquantity" => $originalquantity,
                            "product_tax" => $product_tax,
                            "product_tax_id" => !empty($product_tax_id) ? implode(',', $product_tax_id) : 0,
                        ],
                    ];


                    if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                        return response()->json(
                            [
                                'code' => 404,
                                'status' => 'Error',
                                'error' => __('This product is out of stock!'),
                            ],
                            404
                        );
                    }

                    session()->put($session_key, $cart);

                    return response()->json(
                        [
                            'code' => 200,
                            'status' => 'Success',
                            'success' => $productname . __(' added to cart successfully!'),
                            'product' => $cart[$id],
                            'carthtml' => $carthtml,
                        ]
                    );
                }

                // if cart not empty then check if this product exist then increment quantity
                if (isset($cart[$id])) {

                    $cart[$id]['quantity']++;
                    $cart[$id]['id'] = $id;

                    $subtotal = $cart[$id]["price"] * $cart[$id]["quantity"];
                    $tax = ($subtotal * $cart[$id]["tax"]) / 100;

                    $cart[$id]["subtotal"] = $subtotal + $tax;
                    $cart[$id]["originalquantity"] = $originalquantity;

                    if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                        return response()->json(
                            [
                                'code' => 404,
                                'status' => 'Error',
                                'error' => __('This product is out of stock!'),
                            ],
                            404
                        );
                    }

                    session()->put($session_key, $cart);

                    return response()->json(
                        [
                            'code' => 200,
                            'status' => 'Success',
                            'success' => $productname . __(' added to cart successfully!'),
                            'product' => $cart[$id],
                            'carttotal' => $cart,
                        ]
                    );
                }

                // if item not exist in cart then add to cart with quantity = 1
                $cart[$id] = [
                    "name" => $productname,
                    "quantity" => 1,
                    "price" => $productprice,
                    "tax" => $producttax,
                    "subtotal" => $subtotal,
                    "id" => $id,
                    "originalquantity" => $originalquantity,
                    "product_tax" => $product_tax,
                ];

                if ($originalquantity < $cart[$id]['quantity'] && $session_key == 'pos') {
                    return response()->json(
                        [
                            'code' => 404,
                            'status' => 'Error',
                            'error' => __('This product is out of stock!'),
                        ],
                        404
                    );
                }

                session()->put($session_key, $cart);

                return response()->json(
                    [
                        'code' => 200,
                        'status' => 'Success',
                        'success' => $productname . __(' added to cart successfully!'),
                        'product' => $cart[$id],
                        'carthtml' => $carthtml,
                        'carttotal' => $cart,
                    ]
                );
            } else {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This Product is not found!'),
                    ],
                    404
                );
            }
        } catch (\Exception $e) {
            Log::info('ADD TO CART ERROR');
            Log::info($e);

            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => $e->getMessage(),
                ],
                404
            );
        }
    }

    public function updateCart(Request $request)
    {

        $id = $request->id;
        $quantity = $request->quantity;
        $discount = $request->discount;
        $session_key = $request->session_key;

        if (Auth::user()->type == 'company' || Auth::user()->type == 'accountant' && $request->ajax() && isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);


            if (isset($cart[$id]) && $quantity == 0) {
                unset($cart[$id]);
            }

            if ($quantity) {

                $cart[$id]["quantity"] = $quantity;

                $producttax = isset($cart[$id]) ? $cart[$id]["tax"] : 0;
                $productprice = $cart[$id]["price"];

                $subtotal = $productprice * $quantity;
                $tax = ($subtotal * $producttax) / 100;

                $cart[$id]["subtotal"] = $subtotal + $tax;
            }

            if (isset($cart[$id]) && ($cart[$id]["originalquantity"]) < $cart[$id]['quantity'] && $session_key == 'pos') {
                return response()->json(
                    [
                        'code' => 404,
                        'status' => 'Error',
                        'error' => __('This product is out of stock!'),
                    ],
                    404
                );
            }

            $subtotal = array_sum(array_column($cart, 'subtotal'));
            $discount = $request->discount;
            $total = $subtotal - $discount;
            $totalDiscount = User::priceFormats($total);
            $discount = $totalDiscount;


            session()->put($session_key, $cart);

            return response()->json(
                [
                    'code' => 200,
                    'success' => __('Cart updated successfully!'),
                    'product' => $cart,
                    'discount' => $discount,
                ]
            );
        } else {
            return response()->json(
                [
                    'code' => 404,
                    'status' => 'Error',
                    'error' => __('This Product is not found!'),
                ],
                404
            );
        }
    }

    public function emptyCart(Request $request)
    {
        $session_key = $request->session_key;

        if (Auth::user()->type == 'company' || Auth::user()->type == 'accountant' && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);
            if (isset($cart) && count($cart) > 0) {
                session()->forget($session_key);
            }

            return redirect()->back()->with('error', __('Cart is empty!'));
        } else {
            return redirect()->back()->with('error', __('Cart cannot be empty!.'));
        }
    }

    public function warehouseemptyCart(Request $request)
    {
        $session_key = $request->session_key;

        $cart = session()->get($session_key);
        if (isset($cart) && count($cart) > 0) {
            session()->forget($session_key);
        }

        return response()->json();
    }

    public function removeFromCart(Request $request)
    {
        $id = $request->id;
        $session_key = $request->session_key;
        if (Auth::user()->type == 'company' || Auth::user()->type == 'accountant' && isset($id) && !empty($id) && isset($session_key) && !empty($session_key)) {
            $cart = session()->get($session_key);
            if (isset($cart[$id])) {
                unset($cart[$id]);
                session()->put($session_key, $cart);
            }

            return redirect()->back()->with('error', __('Product removed from cart!'));
        } else {
            return redirect()->back()->with('error', __('This Product is not found!'));
        }
    }

    // public function syncCodeList()
    // {
    //     try {

    //         $config = ConfigSettings::first();
    //         Log::info('Sync Code List Data Config Data : ');
    //         Log::info($config);

    //         $url = $config->api_url . 'GetCodeListV2?date=20210101120000';

    //         Log::info('the Api URL  IS : ');
    //         Log::info($url);

    //         Log::info('The Config Key : ');
    //         Log::info($config->api_key);

    //         $response = Http::withOptions([
    //             'verify' => false
    //         ])->withHeaders([
    //             $config->api_key,
    //             'accept' => 'application/json',
    //         ])->timeout(60)->get($url);

    //         Log::info('SYNC CODE LIST RESPONSE');
    //         Log::info($response);

    //         $data = $response->json()['data'];

    //         $remoteCodes = $data['data']['clsList'];

    //         Log::info('REMOTE CODES');
    //         Log::info(json_encode($remoteCodes));

    //         $codesToSync = [];

    //         foreach ($remoteCodes as $remoteCode) {
    //             $code = [
    //                 'cdCls' => $remoteCode['cdCls'],
    //                 'cdClsNm' => $remoteCode['cdClsNm'],
    //                 'cdClsDesc' => $remoteCode['cdClsDesc'],
    //                 'useYn' => $remoteCode['useYn'],
    //                 'userDfnNm1' => $remoteCode['userDfnNm1'],
    //                 'userDfnNm2' => $remoteCode['userDfnNm2'],
    //                 'userDfnNm3' => $remoteCode['userDfnNm3'],
    //             ];
    //             array_push($codesToSync, $code);
    //         }

    //         Log::info('CODES TO SYNC');
    //         Log::info($codesToSync);

    //         $syncedCodes = 0;

    //         foreach ($codesToSync as $codeToSync) {
    //             $exists = (bool) Code::where('cdCls', $codeToSync['cdCls'])->exists();
    //             if (!$exists) {
    //                 Code::create($codeToSync);
    //                 $syncedCodes++;
    //             }
    //         }

    //         if ($syncedCodes > 0) {
    //             return redirect()->back()->with('success', __('Synced ' . $syncedCodes . ' Codes' . 'Successfully'));
    //         } else {
    //             return redirect()->back()->with('success', __('Codes Up To Date'));
    //         }
    //     } catch (\Exception $e) {
    //         Log::info('ERROR SYNCING CODE LIST');
    //         Log::info($e);
    //         return redirect()->back()->with('error', __('Error Syncing Code List'));
    //     }
    // }




    public function syncCodeList()
    {
        try {
            $config = ConfigSettings::first();
            Log::info('Sync Code List Data Config Data: ', $config->toArray());

            $url = $config->api_url . 'GetCodeListV2?date=20210101120000';
            Log::info('The API URL is: ' . $url);

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                        'key' => $config->api_key, // Correct header name
                        'accept' => 'application/json'
                    ])->timeout(60)->get($url);

            Log::info('SYNC CODE LIST RESPONSE: ', $response->json());

            // Check if the response status is true
            if ($response->ok() && $response->json()['status'] === true) {
                $responseData = $response->json()['responseData'];

                if (isset($responseData['clsList']) && is_array($responseData['clsList'])) {
                    $remoteCodes = $responseData['clsList'];

                    Log::info('REMOTE CODES: ', $remoteCodes);

                    $codesToSync = [];
                    foreach ($remoteCodes as $remoteCode) {
                        $codesToSync[] = [
                            'cdCls' => $remoteCode['cdCls'],
                            'cdClsNm' => $remoteCode['cdClsNm'],
                            'cdClsDesc' => $remoteCode['cdClsDesc'],
                            'useYn' => $remoteCode['useYn'],
                            'userDfnNm1' => $remoteCode['userDfnNm1'],
                            'userDfnNm2' => $remoteCode['userDfnNm2'],
                            'userDfnNm3' => $remoteCode['userDfnNm3'],
                        ];
                    }

                    Log::info('CODES TO SYNC: ', $codesToSync);

                    $syncedCodes = 0;
                    foreach ($codesToSync as $codeToSync) {
                        $exists = Code::where('cdCls', $codeToSync['cdCls'])->exists();
                        if (!$exists) {
                            Code::create($codeToSync);
                            $syncedCodes++;
                        }
                    }

                    $message = $syncedCodes > 0 ? "Synced $syncedCodes Codes Successfully" : "Codes Up To Date";
                    return redirect()->back()->with('success', __($message));
                } else {
                    throw new \Exception('No clsList found in API response.');
                }
            } else {
                throw new \Exception('API Response Error: ' . $response->json()['message']);
            }
        } catch (\Exception $e) {
            Log::error('ERROR SYNCING CODE LIST', ['exception' => $e]);
            return redirect()->back()->with('error', __('Error Syncing Code List: ' . $e->getMessage()));
        }
    }



    public function synchronize()
    {
        try {
            $syncedItems = 0;

            $startDate = '20210101120000';

            while (true) {

                $config = ConfigSettings::first();

                $url = $config->api_url . 'GetItemInformationV2?date=' . $startDate;

                Log::info('Fetching data from Get Item Information URL: ' . $url);

                $response = Http::withOptions(['verify' => false])
                    ->withHeaders(['key' => $config->api_key])
                    ->timeout(60)
                    ->get($url);

                Log::info('DATAAAAA::::');
                Log::info($response->json());
                $data = $response->json()['responseData'];



                if (empty($data['itemList'])) {
                    break;
                }

                $remoteItems = $data['itemList'];

                Log::info('REMOTE ITEMS Information : ', $remoteItems);

                $itemsToSync = [];

                foreach ($remoteItems as $remoteItem) {
                    $taxTypeId = null;
                    if (isset($remoteItem['taxTyCd'])) {
                        $taxType = Tax::where('name', $remoteItem['taxTyCd'])->first();
                        $taxTypeId = $taxType ? $taxType->srtOrd : null;
                    }

                    $productTypeMapping = null;
                    if (isset($remoteItem['itemTyCd'])) {
                        $ItemTypeCode = ItemType::where('item_type_code', $remoteItem['itemTyCd'])->first();
                        $productTypeMapping = $ItemTypeCode ? $ItemTypeCode->item_type_name : null;
                    }

                    $unitId = null;
                    if (isset($remoteItem['qtyUnitCd'])) {
                        $unit = ProductServiceUnit::where('code', $remoteItem['qtyUnitCd'])->first();
                        $unitId = $unit ? $unit->id : null;
                    }

                    $item = [
                        'name' => $remoteItem['itemNm'],
                        'sku' => $remoteItem['itemCd'],
                        'sale_price' => null,
                        'purchase_price' => null,
                        'tax_id' => $taxTypeId,
                        'category_id' => null,
                        'unit_id' => $unitId,
                        'type' => $productTypeMapping,
                        'description' => $remoteItem['addInfo'],
                        'pro_image' => null,
                        'sale_chartaccount_id' => null,
                        'expense_chartaccount_id' => null,
                        'created_by' => Auth::user()->creatorId(),
                        'tin' => $remoteItem['tin'],
                        'itemCstd' => $remoteItem['itemCd'],
                        'itemClsCd' => $remoteItem['itemClsCd'],
                        'itemTyCd' => $remoteItem['itemTyCd'],
                        'itemNm' => $remoteItem['itemNm'],
                        'itemStdNm' => $remoteItem['itemStdNm'],
                        'orgnNatCd' => $remoteItem['orgnNatCd'],
                        'pkgUnitCd' => $remoteItem['pkgUnitCd'],
                        'qtyUnitCd' => $remoteItem['qtyUnitCd'],
                        'taxTyCd' => $remoteItem['taxTyCd'],
                        'btchNo' => $remoteItem['btchNo'],
                        'regBhfId' => $remoteItem['regBhfId'],
                        'bcd' => $remoteItem['bcd'],
                        'dftPrc' => $remoteItem['dftPrc'],
                        'grpPrcL1' => $remoteItem['grpPrcL1'],
                        'grpPrcL2' => $remoteItem['grpPrcL2'],
                        'grpPrcL3' => $remoteItem['grpPrcL3'],
                        'grpPrcL4' => $remoteItem['grpPrcL4'],
                        'grpPrcL5' => $remoteItem['grpPrcL5'],
                        'addInfo' => $remoteItem['addInfo'],
                        'sftyQty' => $remoteItem['sftyQty'],
                        'isrcAplcbYn' => $remoteItem['isrcAplcbYn'],
                        'rraModYn' => $remoteItem['rraModYn'],
                        'useYn' => $remoteItem['useYn'],
                        'isUsed' => null,
                        'packageQuantity' => null
                    ];
                    array_push($itemsToSync, $item);
                }

                Log::info('ITEMS TO SYNC: ', $itemsToSync);

                foreach ($itemsToSync as $itemToSync) {
                    $exists = ProductService::where('itemCd', $itemToSync['itemCd'])->exists();
                    if (!$exists) {
                        ProductService::create($itemToSync);
                        $syncedItems++;
                    }
                }

                $lastItemDate = end($remoteItems)['dateField']; // Assuming `dateField` holds the date information
                $startDate = $lastItemDate;
            }

            if ($syncedItems > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedItems . ' Items Successfully'));
            } else {
                return redirect()->back()->with('success', __('Items Up To Date'));
            }
        } catch (\Exception $e) {
            Log::error('ERROR SYNCING ITEM INFO: ');
            Log::error($e);
            return redirect()->back()->with('error', __('Error Syncing Item Information'));
        }
    }



    public function synchronizeItemClassifications()
    {
        try {

            $config = ConfigSettings::first();

            $url = $config->api_url . 'GetItemClassificationListV2?date=20210101120000';

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                        $config->api_key
                    ])->timeout(60)->get($url);

            $data = $response->json()['data'];

            $remoteIteminfo = $data['data']['itemClsList'];

            Log::info('REMOTE ITEM INFO');
            Log::info($remoteIteminfo);

            $remoteItemInfoToSync = [];

            foreach ($remoteIteminfo as $remoteItem) {
                $item = [
                    'itemClsCd' => $remoteItem['itemClsCd'],
                    'itemClsNm' => $remoteItem['itemClsNm'],
                    'itemClsLvl' => $remoteItem['itemClsLvl'],
                    'taxTyCd' => $remoteItem['taxTyCd'],
                    'mjrTgYn' => $remoteItem['mjrTgYn'],
                    'useYn' => $remoteItem['useYn'],
                ];
                array_push($remoteItemInfoToSync, $item);
            }

            Log::info('REMOTE ITEM INFO TO SYNC');
            Log::info($remoteItemInfoToSync);

            $syncedItemInfo = 0;

            foreach ($remoteItemInfoToSync as $remoteItemInfo) {
                $exists = (bool) ProductsServicesClassification::where('itemClsCd', $remoteItemInfo['itemClsCd'])->exists();
                if (!$exists) {
                    ProductsServicesClassification::create($remoteItemInfo);
                    $syncedItemInfo++;
                }
            }

            if ($syncedItemInfo > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedItemInfo . ' Item Classifications' . 'Successfully'));
            } else {
                return redirect()->back()->with('success', __('Product Service  Classifications Up To Date'));
            }
        } catch (\Exception $e) {
            Log::info('ERROR SYNCING ITEM CLASSIFICATIONS');
            Log::info($e);
            return redirect()->back()->with('error', __('Error Syncing Product Service  Classifications'));
        }
    }


    public function getCodeList()
    {

        $codelists = Code::all();

        return view('productservice.getcodelist', compact('codelists'));
    }

    public function viewItemInformation()
    {

        $iteminformations = ProductService::all();
        $itemtypes = ItemType::all();

        Log::info($itemtypes);
        return view('productservice.getiteminformation', compact('iteminformations', 'itemtypes'));
    }

    public function showItemClassification()
    {
        $itemclassifications = ProductsServicesClassification::all();

        return view('productservice.itemclassifications', compact('itemclassifications'));
    }
    public function getItemInformation()
    {

        $config = ConfigSettings::first();

        ini_set('max_execution_time', 30000);

        $url = $config->api_url . 'GetItemInformationV2?date=20160101000000';

        $response = Http::withOptions(['verify' => false])
            ->withHeaders([$config->api_key])
            ->timeout(3000)
            ->get($url);

        $responseBody = $response->json();

        Log::info('API Response: ' . json_encode($responseBody));
        Log::info('API Response Status Code: ' . $response->status());

        if (!$response->successful() || !isset($responseBody['data']) || !isset($responseBody['data']['data']) || !isset($responseBody['data']['data']['itemList'])) {
            return redirect()->back()->with('error', 'Invalid API response.');
        }

        $data = $responseBody['data']['data'];

        try {
            foreach ($data['itemList'] as $item) {
                $taxTypeId = null;
                if (isset($item['taxTyCd'])) {
                    $taxType = Tax::where('name', $item['taxTyCd'])->first();
                    $taxTypeId = $taxType ? $taxType->srtOrd : null;
                }

                $productTypeMapping = null;
                if (isset($item['itemTyCd'])) {
                    $ItemTypeCode = ItemType::where('item_type_code', $item['itemTyCd'])->first();
                    $productTypeMapping = $ItemTypeCode ? $ItemTypeCode->item_type_name : null;
                }

                $unitId = null;
                if (isset($item['qtyUnitCd'])) {
                    $unit = ProductServiceUnit::where('code', $item['qtyUnitCd'])->first();
                    $unitId = $unit ? $unit->id : null;
                }

                ProductService::create([
                    'name' => $item['itemNm'],
                    'sku' => $item['itemCd'],
                    'sale_price' => null,
                    'purchase_price' => null,
                    'tax_id' => $taxTypeId,
                    'category_id' => null,
                    'unit_id' => $unitId,
                    'type' => $productTypeMapping,
                    'description' => $item['addInfo'],
                    'pro_image' => null,
                    'sale_chartaccount_id' => null,
                    'expense_chartaccount_id' => null,
                    'created_by' => Auth::user()->creatorId(),
                    'tin' => $item['tin'],
                    'itemCd' => $item['itemCd'],
                    'itemClsCd' => $item['itemClsCd'],
                    'itemTyCd' => $item['itemTyCd'],
                    'itemNm' => $item['itemNm'],
                    'itemStdNm' => $item['itemStdNm'],
                    'orgnNatCd' => $item['orgnNatCd'],
                    'pkgUnitCd' => $item['pkgUnitCd'],
                    'qtyUnitCd' => $item['qtyUnitCd'],
                    'taxTyCd' => $item['taxTyCd'],
                    'btchNo' => $item['btchNo'],
                    'regBhfId' => $item['regBhfId'],
                    'bcd' => $item['bcd'],
                    'dftPrc' => $item['dftPrc'],
                    'grpPrcL1' => $item['grpPrcL1'],
                    'grpPrcL2' => $item['grpPrcL2'],
                    'grpPrcL3' => $item['grpPrcL3'],
                    'grpPrcL4' => $item['grpPrcL4'],
                    'grpPrcL5' => $item['grpPrcL5'],
                    'addInfo' => $item['addInfo'],
                    'sftyQty' => $item['sftyQty'],
                    'isrcAplcbYn' => $item['isrcAplcbYn'],
                    'rraModYn' => $item['rraModYn'],
                    'useYn' => $item['useYn'],
                    'isUsed' => null,
                    'packageQuantity' => null
                ]);
            }

            return redirect()->route('productservice.index')->with('success', 'Product Service information added successfully from the API.');
        } catch (Exception $e) {
            Log::error('Error adding Product Service information from the API: ' . $e->getMessage());
            return redirect()->route('productservice.index')->with('error', 'Error adding Product Service information from the API.');
        }
    }


    /***
     * This is Divide in batches  when the data   is alot 
     * 
     */

    public function productServiceSearchByDate(Request $request)
    {
        // Log the incoming request
        Log::info('Synchronization Product Search by Date request received:', $request->all());

        // Validate the product service search by date
        $request->validate([
            'searchByDate' => 'required|date_format:Y-m-d',
        ], [
            'searchByDate.required' => __('Date is required for synchronization Search for Product & Services SearchByDate.'),
            'searchByDate.date_format' => __('Invalid date format.'),
        ]);

        // Get and format the date
        $date = $request->input('searchByDate');
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd') . '000000';
        Log::info('Date formatted from synchronization product & Services request:', ['formattedDate' => $formattedDate]);

        try {

            $config = ConfigSettings::first();

            $url = $config->api_url . 'GetItemInformationV2?date=' . $formattedDate;

            ini_set('max_execution_time', 30000);
            $response = Http::withOptions(['verify' => false])
                ->withHeaders([$config->api_key])
                ->get($url);

            Log::info('GET ITEM INFORMATION RESPONSE');
            Log::info($response);

            $data = $response->json();

            if (!isset($data['data']['data']['itemList'])) {
                return redirect()->back()->with('error', __('There is no search result.'));
            }

            $remoteItemInformationinfo = $data['data']['data']['itemList'];

            $remoteItemInformationinfoToSync = [];

            foreach ($remoteItemInformationinfo as $item) {
                $taxTypeId = null;
                if (isset($item['taxTyCd'])) {
                    $taxType = Tax::where('name', $item['taxTyCd'])->first();
                    $taxTypeId = $taxType ? $taxType->srtOrd : null;
                }

                $productTypeMapping = null;
                if (isset($item['itemTyCd'])) {
                    $ItemTypeCode = ItemType::where('item_type_code', $item['itemTyCd'])->first();
                    $productTypeMapping = $ItemTypeCode ? $ItemTypeCode->item_type_name : null;
                }

                $unitId = null;
                if (isset($item['qtyUnitCd'])) {
                    $unit = ProductServiceUnit::where('code', $item['qtyUnitCd'])->first();
                    $unitId = $unit ? $unit->id : null;
                }

                $productServiceData = [
                    'name' => $item['itemNm'],
                    'sku' => $item['itemCd'],
                    'sale_price' => null,
                    'purchase_price' => null,
                    'tax_id' => $taxTypeId,
                    'category_id' => null,
                    'unit_id' => $unitId,
                    'type' => $productTypeMapping,
                    'description' => $item['addInfo'],
                    'pro_image' => null,
                    'sale_chartaccount_id' => null,
                    'expense_chartaccount_id' => null,
                    'created_by' => Auth::user()->creatorId(),
                    'tin' => $item['tin'],
                    'itemCd' => $item['itemCd'],
                    'itemClsCd' => $item['itemClsCd'],
                    'itemTyCd' => $item['itemTyCd'],
                    'itemNm' => $item['itemNm'],
                    'itemStdNm' => $item['itemStdNm'],
                    'orgnNatCd' => $item['orgnNatCd'],
                    'pkgUnitCd' => $item['pkgUnitCd'],
                    'qtyUnitCd' => $item['qtyUnitCd'],
                    'taxTyCd' => $item['taxTyCd'],
                    'btchNo' => $item['btchNo'],
                    'regBhfId' => $item['regBhfId'],
                    'bcd' => $item['bcd'],
                    'dftPrc' => $item['dftPrc'],
                    'grpPrcL1' => $item['grpPrcL1'],
                    'grpPrcL2' => $item['grpPrcL2'],
                    'grpPrcL3' => $item['grpPrcL3'],
                    'grpPrcL4' => $item['grpPrcL4'],
                    'grpPrcL5' => $item['grpPrcL5'],
                    'addInfo' => $item['addInfo'],
                    'sftyQty' => $item['sftyQty'],
                    'isrcAplcbYn' => $item['isrcAplcbYn'],
                    'rraModYn' => $item['rraModYn'],
                    'useYn' => $item['useYn'],
                    'isUsed' => null,
                    'packageQuantity' => null
                ];

                array_push($remoteItemInformationinfoToSync, $productServiceData);
            }

            Log::info('Product & Service Data to Sync:', ['remoteItemInformationinfoToSync' => $remoteItemInformationinfoToSync]);

            $syncedLocalItemInformationinfo = 0;
            // Check if the product service already exists and sync if not
            foreach ($remoteItemInformationinfoToSync as $remoteItemInformationInfo) {
                $exists = ProductService::where('tin', $remoteItemInformationInfo['tin'])->exists();
                if (!$exists) {
                    ProductService::create($remoteItemInformationInfo);
                    $syncedLocalItemInformationinfo++;
                }
            }

            if ($syncedLocalItemInformationinfo > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedLocalItemInformationinfo . ' Product & Service(s) Successfully'));
            } else {
                return redirect()->back()->with('success', __('Product & Service(s) Up To Date'));
            }
        } catch (\Exception $e) {
            Log::error('Error syncing Product & Service:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Error Syncing Product & Service'));
        }
    }



    public function searchCodeListByDate(Request $request)
    {
        // Log the request from the form
        Log::info('Synchronization request received From Searching the Code List Search Form:', $request->all());

        // Get the date passed from the search form
        $date = $request->input('searchCodeListByDate');
        if (!$date) {
            return redirect()->back()->with('error', __('Date is required for synchronization Search for Code List.'));
        }

        // Format the date using Carbon
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd') . '000000';

        Log::info('Date Formatted for Synchronization request:', ['formattedDate' => $formattedDate]);

        try {

            $config = ConfigSettings::first();

            $url = $config->api_url . 'GetCodeListV2?date=' . $formattedDate;

            $response = Http::withOptions(['verify' => false])
                ->withHeaders([$config->api_key])
                ->get($url);

            $data = $response->json()['data'];

            Log::info('REMOTE Code List INFO From Data Response', ['remote Item Classifications' => $data]);

            if (!isset($data['data']['clsList'])) {
                return redirect()->back()->with('error', __('There is no search result.'));
            }

            $remoteCodeListinfo = $data['data']['clsList'];
            Log::info('REMOTE CODE LIST INFO', ['remoteCodeListinfo' => $remoteCodeListinfo]);

            $remoteCodeListinfoToSync = [];
            foreach ($remoteCodeListinfo as $remoteCodeList) {
                $codeList = [
                    'cdCls' => $remoteCodeList['cdCls'],
                    'cdClsNm' => $remoteCodeList['cdClsNm'],
                    'cdClsDesc' => $remoteCodeList['cdClsDesc'],
                    'useYn' => $remoteCodeList['useYn'],
                    'userDfnNm1' => $remoteCodeList['userDfnNm1'],
                    'userDfnNm2' => $remoteCodeList['userDfnNm2'],
                    'userDfnNm3' => $remoteCodeList['userDfnNm3'],
                ];
                array_push($remoteCodeListinfoToSync, $codeList);
            }

            Log::info('REMOTE CODE LIST INFO TO SYNC:', ['remoteCodeListinfoToSync' => $remoteCodeListinfoToSync]);

            $syncedLocalCodeListinfo = 0;
            foreach ($remoteCodeListinfoToSync as $remoteCodeListInfo) {
                $exists = Code::where('cdCls', $remoteCodeListInfo['cdCls'])->exists();
                if (!$exists) {
                    Code::create($remoteCodeListInfo);
                    $syncedLocalCodeListinfo++;
                }
            }

            if ($syncedLocalCodeListinfo > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedLocalCodeListinfo . ' Code List Successfully'));
            } else {
                return redirect()->back()->with('success', __('Code List Up To Date'));
            }
        } catch (\Exception $e) {
            Log::error('Error syncing Code List:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Error Syncing Code List'));
        }
    }
}