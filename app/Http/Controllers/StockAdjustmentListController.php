<?php

namespace App\Http\Controllers;

use App\Models\ReleaseType;
use Illuminate\Http\Request;
use App\Models\ProductService;
use App\Models\StockAdjustment;
use App\Models\WarehouseProduct;
use Illuminate\Support\Facades\Http;
use App\Models\StockAdjustmentProductList;

class StockAdjustmentListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if(\Auth::user()->type == 'company') {

       
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
    public function create()
    {

        if(\Auth::user()->type == 'company'){

        try {
            $items = ProductService::all()->pluck('itemNm', 'itemCd');
            $releaseTypes = ReleaseType::all()->pluck('type', 'id');
            return view('stockadjustment.create', compact('items', 'releaseTypes'));
        } catch (\Exception $e) {
            \Log::info($e);
            return redirect()->to('stockinfo.index')->with('error', $e.getMessage());
        }

         } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     * 
     */

    public function store(Request $request)
    {
        if(\Auth::user()->type == 'company'){
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
    public function show(StockAdjustment $stockAdjustmentList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockAdjustment $stockAdjustmentList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,StockAdjustment $stockAdjustmentList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockAdjustment $stockAdjustmentList)
    {
        //
    }
}