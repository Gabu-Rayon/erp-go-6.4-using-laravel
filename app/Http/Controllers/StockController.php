<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ReleaseType;
use App\Models\BranchesList;
use Illuminate\Http\Request;
use App\Models\StockMoveList;
use App\Models\BranchTransfer;
use App\Models\ConfigSettings;
use App\Models\ProductService;
use App\Models\StockAdjustment;
use App\Models\StockReleaseType;
use App\Models\StockMoveListItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\FacadesLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Models\BranchTransferProduct;
use Illuminate\Support\FacadesValidator;
use App\Models\StockAdjustmentProductList;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class StockController extends Controller
{
    // Stock Adjustment Methods
    public function stockAdjustmentIndex()
    {
        try {
            $stockadjustments = StockAdjustmentProductList::all();
            return view('stockadjustment.index', compact('stockadjustments'));
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function stockAdjustmentCreate()
    {
        if (\Auth::user()->type == 'company') {
            try {
                $items = ProductService::where('created_by', Auth::user()->id)->get()->pluck('itemNm', 'itemCd');
                $releaseTypes = ReleaseType::all()->pluck('type', 'code');
                return view('stockadjustment.create', compact('items', 'releaseTypes'));
            } catch (\Exception $e) {
                Log::info('STOCK ADJUSTMENT CREATE ERROR');
                Log::info($e);
                return redirect()->to('stockinfo.index')->with('error', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function stockAdjustmentStore(Request $request)
    {
        $config = ConfigSettings::first();

        try {

            $data = $request->all();
            Log::info("Data  from the form  Adjust Stock :");
            Log::info($data);

            $validator = Validator::make($data, [
                'storeReleaseTypeCode' => 'required',
                'items' => 'required|array',
                'items.*.itemCode' => 'required',
                'items.*.packageQuantity' => 'required|numeric',
                'items.*.quantity' => 'required|numeric',
            ]);


            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $url = $config->api_url . 'StockAdjustmentV2';

            $response = Http::withOptions(['verify' => false])->withHeaders([
                'key' => $config->api_key,
            ])->post($url, [
                        'storeReleaseTypeCode' => $data['storeReleaseTypeCode'],
                        'remark' => $data['remark'],
                        'stockItemList' => $data['items']
                    ]);

            if ($response['statusCode'] !== 200) {
                return redirect()->back()->with('error', 'Check your credentials and try again');
            }
            // Log response data
            Log::info('API Response Status Code For Posting Stock Adjustment : ' . $response->status());
            Log::info('API Request  Stock Adjustment Data Posted: ' . json_encode($response));
            Log::info('API Response Body For Posting  Stock Adjustment Data: ' . $response->body());

            $updatedItems = [];

            DB::beginTransaction();

            foreach ($data['items'] as $item) {
                $productService = ProductService::where('itemCd', $item['itemCode'])->first();

                if ($productService) {
                    $productService->quantity += $item['quantity'];
                    $productService->packageQuantity += $item['packageQuantity'];
                    $productService->save();

                    array_push($updatedItems, $productService);
                } else {
                    return redirect()->back()->with('error', 'Product(s) not found');
                }
            }

            $rsdQty = array_sum(array_column($updatedItems, 'quantity'));

            $stockAdjustment = StockAdjustment::create([
                'storeReleaseTypeCode' => $data['storeReleaseTypeCode'],
                'remark' => $data['remark'],
                'rsdQty' => $rsdQty,
            ]);

            foreach ($updatedItems as $item) {
                StockAdjustmentProductList::create([
                    'stock_adjustments_id' => $stockAdjustment->id,
                    'itemCode' => $item->itemCd,
                    'packageQuantity' => $item->packageQuantity,
                    'quantity' => $item->quantity,
                ]);
            }

            DB::commit();

            return redirect()->route('stockadjustment.index')->with('success', 'Stock Adjustment Added.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::info('STOCK ADJUSTMENT STORE ERROR');
            Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function stockAdjustmentShow($id)
    {
        // Code to show a specific stock adjustment
    }

    public function stockAdjustmentEdit($id)
    {
        // Code to show edit form
    }

    public function stockAdjustmentUpdate(Request $request, $id)
    {
        // Code to update a specific stock adjustment
    }

    public function stockAdjustmentDestroy($id)
    {
        // Code to delete a specific stock adjustment
    }

    // Stock Move List Methods
    public function stockMoveListIndex()
    {
        try {
            if (Auth::user()->type == 'company') {
                $stockMoveList = StockMoveList::all();
                return view('stockgetmovelist.index', compact('stockMoveList'));
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            Log::info('errorrrrr');
            Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function stockMoveListShow($id)
    {
        try {
            // Find list by ID
            $stockMoveList = StockMoveList::findOrFail($id);

            // Retrieve associated list items
            $stockMoveListItems = StockMoveListItem::where('stockMoveListID', $id)->get();

            // Log the retrieved stock move details
            \Log::info('Stock Branch Transfer details retrieved:', [
                'StockMoveList' => $stockMoveList,
                'Stock Move List Items' => $stockMoveListItems,
            ]);

            // Return the stock move details to the view
            return view('stockgetmovelist.show', [
                'stockMoveList' => $stockMoveList,
                'stockMoveListItems' => $stockMoveListItems,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error retrieving StockMoveList details:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Error StockMoveList details.'));
        }
    }

    public function stockMoveListCreate()
    {
        // Code to show create form
    }

    public function stockMoveListStore(Request $request)
    {
        // Code to store new stock move
    }

    public function stockMoveListUpdate(Request $request, $id)
    {
        // Code to update a specific stock move
    }

    public function stockMoveListDelete($id)
    {
        // Code to delete a specific stock move
    }

    public function stockMoveListDestroy($id)
    {
        // Code to destroy a specific stock move
    }


    public function stockMoveSearchByDate(Request $request)
    {
        $config = ConfigSettings::first();
        // Log the request from the form
        Log::info('Synchronization request received from Searching the Stock Move SearchByDate Form:', $request->all());

        // Validate the date input
        $request->validate([
            'searchByDate' => 'required|date_format:Y-m-d',
        ], [
            'searchByDate.required' => __('Date is required for synchronization Search for Stock Move SearchByDate.'),
            'searchByDate.date_format' => __('Invalid date format.'),
        ]);

        // Get and format the date
        $date = $request->input('searchByDate');
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd') . '000000';
        Log::info('Date formatted from synchronization request:', ['formattedDate' => $formattedDate]);

        try {
            // Make the API call
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['key' => $config->api_key])
                ->get($config->api_url . "GetMoveList?date={$formattedDate}");

            $data = $response->json()['data'];
            if (!isset($data['data']['stockList'])) {
                return redirect()->back()->with('error', __('There is no search result.'));
            }

            $remoteStockMoveSearchByDateinfo = $data['data']['stockList'];
            Log::info('Remote item info:', $remoteStockMoveSearchByDateinfo);

            // Prepare data for synchronization
            $remoteStockMoveSearchByDateinfoToSync = [];
            $remoteStockMoveSearchByDateItemListinfoToSync = [];
            foreach ($remoteStockMoveSearchByDateinfo as $remoteItem) {
                $item = $this->prepareStockMoveData($remoteItem);
                $remoteStockMoveSearchByDateinfoToSync[] = $item;

                if (isset($remoteItem['itemList']) && is_array($remoteItem['itemList'])) {
                    foreach ($remoteItem['itemList'] as $itemList) {
                        $itemListData = $this->prepareStockMoveItemListData($itemList);
                        $itemListData['stockMoveListID'] = null;  // Placeholder, will be set during sync
                        $remoteStockMoveSearchByDateItemListinfoToSync[] = $itemListData;
                    }
                }
            }

            Log::info('Remote Stock Move search by date info to sync:', $remoteStockMoveSearchByDateinfoToSync);
            Log::info('Remote Stock Move item lists to sync:', $remoteStockMoveSearchByDateItemListinfoToSync);

            // Synchronize the Stock move list
            $syncedCount = $this->synchronizeStockMove($remoteStockMoveSearchByDateinfoToSync, $remoteStockMoveSearchByDateItemListinfoToSync);

            if ($syncedCount > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedCount . ' Stock Move successfully.'));
            } else {
                return redirect()->back()->with('success', __('Stock Move List up to date.'));
            }
        } catch (\Exception $e) {
            Log::error('Error syncing stock Move list:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Error syncing stock move list.'));
        }
    }

    public function getStockMoveListFromApi()
    {
        $config = ConfigSettings::first();
        $url = $config->api_url . 'GetMoveList?date=20210101120000';

        try {
            $response = \Http::withHeaders([
                'key' => $config->api_url
            ])->get($url);

            $data = $response->json();
            \Log::info('DATA GOTTEN FROM API:');
            \Log::info($data['data']['data']['stockList']);

            return redirect()->to('/stockinfo')->with('success', 'Successfully Retrieved Stock Move List from API');
        } catch (\Exception $e) {
            \Log::error('GET STOCK MOVE LIST FROM API ERROR: ');
            \Log::error($e);
            return redirect()->to('/stockinfo')->with('error', $e->getMessage());
        }
    }


    public function synchronizegetStockMoveListFromApi()
    {
        $config = ConfigSettings::first();

        // Get and format the date
        $date = "2022-01-01";
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd') . '000000';
        \Log::info('Date formatted from synchronization request:', ['formattedDate' => $formattedDate]);

        try {
            // Make the API call
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['key' => $config->api_key])
                ->get($config->api_url . "GetMoveList?date={$formattedDate}");

            $data = $response->json()['data'];
            if (!isset($data['data']['stockList'])) {
                return redirect()->back()->with('error', __('There is no search result.'));
            }

            $remoteStockMoveSearchByDateinfo = $data['data']['stockList'];
            \Log::info('Remote item info:', $remoteStockMoveSearchByDateinfo);

            // Prepare data for synchronization
            $remoteStockMoveSearchByDateinfoToSync = [];
            $remoteStockMoveSearchByDateItemListinfoToSync = [];
            foreach ($remoteStockMoveSearchByDateinfo as $remoteItem) {
                $item = $this->prepareStockMoveData($remoteItem);
                $remoteStockMoveSearchByDateinfoToSync[] = $item;

                if (isset($remoteItem['itemList']) && is_array($remoteItem['itemList'])) {
                    foreach ($remoteItem['itemList'] as $itemList) {
                        $itemListData = $this->prepareStockMoveItemListData($itemList);
                        $itemListData['stockMoveListID'] = null;  // Placeholder, will be set during sync
                        $remoteStockMoveSearchByDateItemListinfoToSync[] = $itemListData;
                    }
                }
            }

            \Log::info('Remote Stock Move search by date info to sync:', $remoteStockMoveSearchByDateinfoToSync);
            \Log::info('Remote Stock Move item lists to sync:', $remoteStockMoveSearchByDateItemListinfoToSync);

            // Synchronize the Stock move list
            $syncedCount = $this->synchronizeStockMove($remoteStockMoveSearchByDateinfoToSync, $remoteStockMoveSearchByDateItemListinfoToSync);

            if ($syncedCount > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedCount . ' Stock Move successfully.'));
            } else {
                return redirect()->back()->with('success', __('Stock Move List up to date.'));
            }
        } catch (\Exception $e) {
            \Log::error('Error syncing stock Move list:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Error syncing stock move list.'));
        }
    }

    // Branch Transfer Methods
    // Branch Transfer Methods
    public function branchTransferIndex()
    {
        try {
            if (\Auth::user()->type == 'company') {
                // Get all the branches that have transfer
                $branchTransfers = BranchTransfer::all();
                // // Get products for each branch that have transfer
                $branchTransferProducts = BranchTransferProduct::all();
                return view('stockbranchtransfer.index', compact('branchTransfers', 'branchTransferProducts'));
                // return view('stockbranchtransfer.index');
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            Log::info('Error:');
            Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function branchTransferShow($id)
    {
        try {
            // Find list by ID
            $branchTransfer = BranchTransfer::findOrFail($id);

            // Retrieve associated list items
            $branchTransferProducts = BranchTransferProduct::where('branch_transfer_id', $id)->get();

            // Log the retrieved stock move details
            \Log::info('Stock Branch Transfer details retrieved:', [
                'Branch' => $branchTransfer,
                'stock Items' => $branchTransferProducts,
            ]);

            // Return the stock move details to the view
            return view('stockbranchtransfer.show', [
                'branch' => $branchTransfer,
                'branchTransferProducts' => $branchTransferProducts,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error retrieving branch Transfer Products details:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Error retrieving branch Transfer Products details.'));
        }
    }


    public function branchTransferCreate()
    {
        $branches = BranchesList::all()->pluck('bhfNm', 'bhfId');
        $items = ProductService::all()->pluck('itemNm', 'kraItemCode');
        $releaseTypes = StockReleaseType::all()->pluck('type', 'id');
        return view('stockbranchtransfer.create', compact('branches', 'items', 'releaseTypes'));
    }

    public function branchTransferStore(Request $request)
    {
        try {
            // Retrieve all the request data
            $data = $request->all();

            // Log the initial data received from the request
            Log::info("Branch Transfer Stock BEFORE POSTING:", $data);

            // Define the validation rules
            $validator = \Validator::make($data, [
                'branchFrom' => 'required|string',
                'branchTo' => 'required|string',
                'occurredDate' => 'required|date',
                'items' => 'required|array',
                'items.*.itemCode' => 'required|string',
                'items.*.quantity' => 'required|integer',
                'items.*.pkgQuantity' => 'required|integer',
            ]);

            // If validation fails, redirect back with error message
            if ($validator->fails()) {
                $messages = $validator->getMessageBag()->toArray();
                return redirect()->back()->withErrors($messages)->withInput();
            }

            // Log the validated data
            Log::info('Branch Transfer Stock DATA VALIDATED:', $data);

            // Prepare the occurredDate in the required format
            $occurredDate = date('Ymdhis', strtotime($data['occurredDate']));
            Log::info('Date to be posted to the Api in JSON: ' . $occurredDate);

            // Prepare the data for the API request
            $apiData = [
                'branchId' => $request->branchFrom,
                'occurredDate' => $occurredDate,
                'transferItems' => $request->items,
            ];

            Log::info('Data to be posted to the Api in JSON: ' . json_encode($apiData));

            // Retrieve the API key and URL from the config
            $config = ConfigSettings::first();
            $url = $config->api_url . 'BranchTransferV2';
            $apiKey = $config->api_key;

            Log::info('The Api Url is: ' . $url);

            // Post to Api
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['key' => $apiKey])
                ->post($url, $apiData);

            // Log the API response
            Log::info('API Request Data For Branch Transfer Stock: ' . json_encode($apiData));
            Log::info('API Response Branch Transfer Stock: ' . $response->body());
            Log::info('API Response Status Code For Branch Transfer Stock: ' . $response->status());
            $responseBody = $response->json();

            if (!$responseBody['status'] == false) {
                // Use a transaction to ensure atomicity
                DB::transaction(function () use ($request) {
                    // Save the data to the local database only if the API call is successful
                    $branchTransfer = BranchTransfer::create([
                        'from_branch' => $request->branchFrom,
                        'to_branch' => $request->branchTo,
                        'product_id' => null, // You may want to change this later
                        'totItemCnt' => count($request->items),
                        'status' => 1, 
                    ]);

                    foreach ($request->items as $item) {
                        // Retrieve product_id based on itemCode
                        $product = ProductService::where('kraItemCode', $item['itemCode'])->first();
                        $productId = $product ? $product->id : null;

                        BranchTransferProduct::create([
                            'itemCode' => $item['itemCode'],
                            'quantity' => $item['quantity'],
                            'pkgQuantity' => $item['pkgQuantity'],
                            'branch_transfer_id' => $branchTransfer->id,
                            'product_id' => $productId,
                        ]);
                    }
                });

                return redirect()->route('branch.transfer.index')->with('success', 'Stock Move Successful');
            } else {
                // Check for API error response
                if ($responseBody['status'] == false) {
                    return redirect()->route('branch.transfer.index')->with('error', $response->json()['message']);
                } else {
                    return redirect()->route('branch.transfer.index')->with('error', __('Failed to post data to API.'));
                }
            }
        } catch (\Exception $e) {
            // Log detailed error information
            Log::error('Branch Transfer Stock ERROR:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return redirect()->route('branch.transfer.index')->with('error', $e->getMessage());
        }
    }

    public function branchTransferUpdate(Request $request, $id)
    {
        // Code to update a specific branch transfer
    }

    public function branchTransferDelete($id)
    {
        // Code to delete a specific branch transfer
    }

    public function branchTransferDestroy($id)
    {
        // Code to destroy a specific branch transfer
    }

    // Stock Master Save Request Methods
    public function stockMasterSaveRequestIndex()
    {
        // Code to list stock master save requests
    }

    public function stockMasterSaveRequestShow($id)
    {
        // Code to show a specific stock master save request
    }

    public function stockMasterSaveRequestCreate()
    {
        // Code to show create form
    }

    public function stockMasterSaveRequestStore(Request $request)
    {
        // Code to store new stock master save request
    }

    public function stockMasterSaveRequestUpdate(Request $request, $id)
    {
        // Code to update a specific stock master save request
    }

    public function stockMasterSaveRequestDelete($id)
    {
        // Code to delete a specific stock master save request
    }

    public function stockMasterSaveRequestDestroy($id)
    {
        // Code to destroy a specific stock master save request
    }

    // Stock Update by Invoice Methods
    public function stockUpdateByInvoiceIndex()
    {
        try {
            $branchTransfer = BranchTransfer::all();
            return view('stockinfo.index', compact('branchTransfer'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function stockUpdateByInvoiceShow($id)
    {
        $stockMoveList = StockMoveList::find($id)->first();
        \Log::info('STOCK MOVE LIST controller');
        \Log::info($stockMoveList);
        $items = StockMoveListItem::where('stockMoveListID', $stockMoveList->id)->get();
        return view('stockinfo.show', compact('stockMoveList', 'items'));
    }

    public function stockUpdateByInvoiceCreate()
    {
        try {
            return view('stockinfo.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function stockUpdateByInvoiceStore(Request $request)
    {
        $config = ConfigSettings::first();
        try {
            $data = $request->all();
            \Log::info('Inv No');
            \Log::info($request->all());

            $url = $config->api_url . 'StockUpdate/ByInvoiceNo?InvoiceNo=' . $data['invoiceNo'];

            $response = Http::withOptions(['verify' => false])->withHeaders([
                'key' => $config->api_key,
                'accept' => '*/*',
                'Content-Type' => 'application/json'
            ])->post($url);

            \Log::info('STOCK INV NO API RESPONSE');
            \Log::info($response->json()); // Log the JSON response

            if ($response->json()['statusCode'] == 400 && $response->json()['message'] == 'Sale Details Not Found') {
                return redirect()->route('stockmove.index')->with('error', 'Sale Details Not Found');
            }

            return redirect()->route('stockmove.index')->with('success', 'Updated Successfully');
        } catch (\Exception $e) {
            \Log::error('Error in stockUpdateByInvoiceNoStore:', ['message' => $e->getMessage()]);
            return redirect()->route('stockmove.index')->with('error', $e->getMessage());
        }
    }

    public function stockUpdateByInvoiceUpdate(Request $request, $id)
    {
        // Code to update a specific stock update by invoice
    }

    public function stockUpdateByInvoiceDelete($id)
    {
        // Code to delete a specific stock update by invoice
    }

    public function stockUpdateByInvoiceDestroy($id)
    {
        // Code to destroy a specific stock update by invoice
    }




    //Search Stock Move bY Date

    private function prepareStockMoveData($remoteItem)
    {
        return [
            'custTin' => $remoteItem['custTin'],
            'custBhfId' => $remoteItem['custBhfId'],
            'sarNo' => $remoteItem['sarNo'],
            'ocrnDt' => $remoteItem['ocrnDt'],
            'totItemCnt' => $remoteItem['totItemCnt'],
            'totTaxblAmt' => $remoteItem['totTaxblAmt'],
            'totAmt' => $remoteItem['totAmt'],
            'remark' => $remoteItem['remark']
        ];
    }

    private function prepareStockMoveItemListData($itemList)
    {
        return [
            'itemSeq' => $itemList['itemSeq'],
            'itemCd' => $itemList['itemCd'],
            'itemClsCd' => $itemList['itemClsCd'],
            'itemNm' => $itemList['itemNm'],
            'bcd' => $itemList['bcd'],
            'pkgUnitCd' => $itemList['pkgUnitCd'],
            'pkg' => $itemList['pkg'],
            'qtyUnitCd' => $itemList['qtyUnitCd'],
            'qty' => $itemList['qty'],
            'itemExprDt' => $itemList['itemExprDt'],
            'prc' => $itemList['prc'],
            'splyAmt' => $itemList['splyAmt'],
            'totDcAmt' => $itemList['totDcAmt'],
            'taxblAmt' => $itemList['taxblAmt'],
            'taxTyCd' => $itemList['taxTyCd'],
            'taxAmt' => $itemList['taxAmt'],
            'totAmt' => $itemList['totAmt']
        ];
    }

    private function synchronizeStockMove($stockMoves, $itemLists)
    {
        $syncedCount = 0;

        foreach ($stockMoves as $stock) {
            // Check if the stock Move List already exists
            if (!StockMoveList::where('sarNo', $stock['sarNo'])->exists()) {
                // Create the stock move List
                $stockMove = StockMoveList::create($stock);
                $syncedCount++;

                $syncedStockMoveItemCount = 0;

                foreach ($itemLists as $itemList) {
                    // Set the stock move list ID for the current stock move
                    if ($itemList['stockMoveListID'] === null) {
                        $itemList['stockMoveListID'] = $stockMove->id;
                    }

                    // Check if the stock move list item already exists
                    $exists = StockMoveListItem::where('stockMoveListID', $itemList['stockMoveListID'])
                        ->where('itemSeq', $itemList['itemSeq'])
                        ->exists();

                    if (!$exists) {
                        // Create the Stock Move item list
                        StockMoveListItem::create($itemList);
                        $syncedStockMoveItemCount++;
                    }
                }

                Log::info("Synced $syncedStockMoveItemCount stock Move list items for stock move list ID {$stockMove->id}");
            }
        }

        return $syncedCount;
    }
}