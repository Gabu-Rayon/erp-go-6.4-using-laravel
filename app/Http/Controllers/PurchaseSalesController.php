<?php

namespace App\Http\Controllers;

use App\Models\Purchase_Sales;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PurchaseSalesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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
    public function show(Purchase_Sales $purchase_Sales)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Purchase_Sales $purchase_Sales)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Purchase_Sales $purchase_Sales)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Purchase_Sales $purchase_Sales)
    {
        //
    }

    public function getPurchaseSales() {
        $url = 'https://etims.your-apps.biz/api/GetPurchaseList?date=20210101120000';

        try {
            $response = Http::withHeaders([
                'key' => '123456'
            ])->get($url);
            $data = $response->json();
            return $data['data']['saleList'];
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
