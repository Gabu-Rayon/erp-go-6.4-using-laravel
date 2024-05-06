<?php

namespace App\Http\Controllers;

use App\Models\StockMoveList;
use Illuminate\Http\Request;
use App\Models\StockMoveListItem;
use Illuminate\Support\Facades\Http;

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
            \Log::info('errorrrrr');
            \Log::info($e);
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
        try {
            $data = $request->all();
            \Log::info('Inv No');
            \Log::info($request->all());

            $url = 'https://etims.your-apps.biz/api/StockUpdate/ByInvoiceNo?InvoiceNo=' . $data['invoiceNo'];

            $response = Http::withHeaders([
                'key' => '123456',
                'accept' => '*/*',
                'Content-Type' => 'application/json'
            ])->post($url);

            \Log::info('STOCK INV NO API RESPONSE');
            \lOG::info($response);

            return redirect()->to('stockinfo')->with('success', 'Updated Successfully');
        } catch (\Exception $e) {
            return redirect()->to('stockinfo')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
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
    public function edit(StockMoveList $stockMoveList)
    {
        //
    }

    public function cancel(StockMoveList $stockMoveList)
    {
        //
    }

    public function stockMove(StockMoveList $stockMoveList)
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
