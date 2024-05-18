<?php

namespace App\Http\Controllers;

use App\Models\ItemInformation;
use App\Models\ReleaseType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class StockAdjustmentListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (\Auth::user()->can('show purchase')) {

       
        try {
            return view('stockadjustment.index');
        } catch (\Exception $e) {
            \Log::info($e);
            return redirect()->to('stockinfo.index')->with('error', e.getMessage());
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

         if (\Auth::user()->can('show purchase')) {

        try {
            $items = ItemInformation::all()->pluck('itemNm', 'itemCd');
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

         if (\Auth::user()->can('show purchase')) {

        try {
            $data = $request->all();
            \Log::info('STOCK ADJ');
            \lOG::info(json_encode($data));

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
            \lOG::info($response['data']);


            return  redirect()->to('stockadjustment')->with('success', 'Stock Adjustment Added.');
        } catch(\Exception $e) {
            return  redirect()->back()->with('error', $e->getMessage());
        }

    }else
        {
            return redirect()->back()->with('errors', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(StockAdjustmentList $stockAdjustmentList)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockAdjustmentList $stockAdjustmentList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockAdjustmentList $stockAdjustmentList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockAdjustmentList $stockAdjustmentList)
    {
        //
    }
}