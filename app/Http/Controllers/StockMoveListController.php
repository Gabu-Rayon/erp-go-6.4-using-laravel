<?php

namespace App\Http\Controllers;

use App\Models\StockMoveList;
use Illuminate\Http\Request;

class StockMoveListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            if (\Auth::user()->type == 'company') {
                $stockMoveList = StockMoveList::all();
                return view('stockinfo.index', compact('stockMoveList'));
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('stockinfo.create');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function stockAdjustment () {
        try {
            return view('stockinfo.stockadjustment');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(StockMoveList $stockMoveList)
    {
        return view('stockinfo.show', compact('stockMoveList'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(StockMoveList $stockMoveList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, StockMoveList $stockMoveList)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(StockMoveList $stockMoveList)
    {
        //
    }

    public function getStockMoveListFromApi() {
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
}
