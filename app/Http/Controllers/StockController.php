<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\ReleaseType;
use App\Models\BranchesList;
use Illuminate\Http\Request;
use App\Models\StockMoveList;
use App\Models\ProductService;
use App\Models\StockAdjustment;
use App\Models\StockReleaseType;
use App\Models\WarehouseProduct;
use App\Models\StockMoveListItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function stockIdjustmentIndex()
    {

        if (\Auth::user()->type == 'company') {


            try {
                return view('stockadjustment.index');
            } catch (\Exception $e) {
                \Log::info($e);
                return redirect()->to('stockinfo.index')->with('error', $e);
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function stockIdjustmentCreate()
    {

        if (\Auth::user()->type == 'company') {

            try {
                $items = ProductService::all()->pluck('itemNm', 'itemCd');
                $releaseTypes = ReleaseType::all()->pluck('type', 'id');
                return view('stockadjustment.create', compact('items', 'releaseTypes'));
            } catch (\Exception $e) {
                \Log::info($e);
                return redirect()->to('stockinfo.index')->with('error', $e . getMessage());
            }

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * 
     */

    public function stockIdjustmentStore(Request $request)
    {
        if (\Auth::user()->type == 'company') {
            try {
                $data = $request->all();
                \Log::info('STOCK ADJUSTMENT data from the Form to adjust the Stock:');
                \Log::info(json_encode($data));

                $url = 'https://etims.your-apps.biz/api/StockAdjustment';

                $response = Http::withOptions(['verify' => false])->withHeaders([
                    'key' => '123456',
                    'accept' => '*/*',
                    'Content-Type' => 'application/json'
                ])->post($url, [
                            'storeReleaseTypeCode' => $request['storeReleaseTypeCode'],
                            'remark' => $request['remark'],
                            'stockItemList' => $request['items']
                        ]);

                \Log::info('STOCK ADJ API RESPONSE');
                \Log::info($response['data']);

                // Parse API response and store relevant data locally
                $responseData = $response->json();
                $stockAdjustment = new StockAdjustment();
                $stockAdjustment->storeReleaseTypeCode = $request['storeReleaseTypeCode'];
                $stockAdjustment->remark = $request['remark'];
                $stockAdjustment->save();

                foreach ($responseData['stockItemList'] as $item) {
                    // Update ProductService quantity
                    $productService = ProductService::where('itemCd', $item['itemCode'])->first();
                    if ($productService) {
                        $productService->quantity += $item['quantity'];
                        $productService->save();
                    }

                    // Update WarehouseProduct quantity
                    $warehouseProduct = WarehouseProduct::where('product_id', $productService->id)->first();
                    if ($warehouseProduct && $warehouseProduct->quantity !== null) {
                        $warehouseProduct->quantity += $item['quantity'];
                        // $warehouseProduct->pkgQuantity  -= $item['pkgQuantity'];
                        $warehouseProduct->save();
                    }

                    // Update quantity in warehouse_products
                    // $warehouseProduct = WarehouseProduct::where('product_id', $productService->id)->first();
                    // if ($warehouseProduct && $warehouseProduct->quantity !== null) {
                    //     $warehouseProduct->quantity -= $item['quantity'];
                    //     // $warehouseProduct->pkgQuantity  -= $item['pkgQuantity'];
                    //     $warehouseProduct->save();
                    // }
                }

                return redirect()->route('stockadjustment.index')->with('success', 'Stock Adjustment Added.');
            } catch (\Exception $e) {
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('errors', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function stockIdjustmentShow(StockAdjustment $stockAdjustmentList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function stockIdjustmentEdit(StockAdjustment $stockAdjustmentList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function stockIdjustmentUpdate(Request $request, StockAdjustment $stockAdjustmentList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function stockIdjustmentDestroy(StockAdjustment $stockAdjustmentList)
    {
        //
    }



    /**
     * Display a listing of the resource.
     */
    public function stockMoveIndex()
    {
        try {
            if (\Auth::user()->type == 'company') {
                $stockMoveList = StockMoveList::all();
                return view('stockinfo.index', compact('stockMoveList'));
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::info('errorrrrr');
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    /**
     * Show the form for creating a new resource.
     * 
     */
    public function stockMoveCreate()
    {
        $branches = BranchesList::all()->pluck('bhfNm', 'bhfId');
        $items = ProductService::all()->pluck('itemNm', 'itemCd');
        $releaseTypes = StockReleaseType::all()->pluck('type', 'id');
        return view('stockmove.create', compact('branches', 'items', 'releaseTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function stockMoveStore(Request $request)
    {
        try {
            \Log::info('STOCK MOVE DEYTA');
            \Log::info($request->all());

            return redirect()->to('stockinfo')->with('success', 'Stock Move Successful');
        } catch (\Exception $e) {
            \Log::info('STOCK MOVE ERROR');
            \Log::info($e);

            return redirect()->to('stockinfo')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function stockMoveShow(string $id)
    {
        try {
            // Find the stock move list by ID
            $stockMove = StockMoveList::findOrFail($id);

            // Retrieve associated stock move list items
            $stockMoveItems = StockMoveListItem::where('stockMoveListID', $id)->get();

            // Log the retrieved stock move details
            \Log::info('Stock Move details retrieved:', [
                'stockMove' => $stockMove,
                'stockMoveItems' => $stockMoveItems,
            ]);

            // Return the stock move details to the view
            return view('stockinfo.show', [
                'stockMove' => $stockMove,
                'stockMoveItems' => $stockMoveItems,
            ]);
        } catch (\Exception $e) {
            \Log::error('Error retrieving stock move details:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Error retrieving stock move details.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function stockMoveEdit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function stockMoveUpdate(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function stockMoveDestroy(string $id)
    {
        //
    }




    /**
     * Display a listing of the resource.
     */
    public function stockUpdateByInvoiceNoIndex()
    {
      //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function stockUpdateByInvoiceNoCreate()
    {
        try {
            return view('stockinfo.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function stockUpdateByInvoiceNoStore(Request $request)
    {
        try {
            $data = $request->all();
            \Log::info('Inv No');
            \Log::info($request->all());

            $url = 'https://etims.your-apps.biz/api/StockUpdate/ByInvoiceNo?InvoiceNo=' . $data['invoiceNo'];

            $response = Http::withOptions(['verify' => false])->withHeaders([
                'key' => '123456',
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


    /**
     * Display the specified resource.
     */
    public function stockUpdateByInvoiceNoShow($id)
    {
        $stockMoveList = StockMoveList::find($id)->first();
        \Log::info('STOCK MOVE LIST controller');
        \Log::info($stockMoveList);
        $items = StockMoveListItem::where('stockMoveListID', $stockMoveList->id)->get();
        return view('stockinfo.show', compact('stockMoveList', 'items'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function stockUpdateByInvoiceNoEdit(StockMoveList $stockMoveList)
    {
        //
    }

    public function stockUpdateByInvoiceNoCancel(StockMoveList $stockMoveList)
    {
        //
    }


    /**
     * Update the specified resource in storage.
     */
    public function stockUpdateByInvoiceNoUpdate(Request $request, StockMoveList $stockMoveList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function stockUpdateByInvoiceNoDestroy(StockMoveList $stockMoveList)
    {
        //
    }

    public function getStockMoveListFromApi()
    {
        $url = 'https://etims.your-apps.biz/api/GetMoveList?date=20210101120000';

        try {
            $response = \Http::withHeaders([
                'key' => '123456'
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

    //Search Stock Move bY Date
    public function stockMoveSearchByDate(Request $request)
    {
        // Log the request from the form
        \Log::info('Synchronization request received from Searching the Stock Move SearchByDate Form:', $request->all());

        // Validate the date input
        $request->validate([
            'searchByDate' => 'required|date_format:Y-m-d',
        ], [
            'searchByDate.required' => __('Date is required for synchronization Search for Stock Move SearchByDate.'),
            'searchByDate.date_format' => __('Invalid date format.'),
        ]);

        // Get and format the date
        $date = $request->input('searchByDate');
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd').'000000';
        \Log::info('Date formatted from synchronization request:', ['formattedDate' => $formattedDate]);

        try {
            // Make the API call
            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['key' => '123456'])
                ->get("https://etims.your-apps.biz/api/GetMoveList?date={$formattedDate}");

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

                \Log::info("Synced $syncedStockMoveItemCount stock Move list items for stock move list ID {$stockMove->id}");
            }
        }

        return $syncedCount;
    }
}