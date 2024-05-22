<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BranchesList;
use App\Models\ProductService;
use App\Models\StockReleaseType;

class StockMoveController extends Controller
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
     * 
     */
    public function create()
    {
        $branches = BranchesList::all()->pluck('bhfNm', 'bhfId');
        $items = ProductService::all()->pluck('itemNm', 'itemCd');
        $releaseTypes = StockReleaseType::all()->pluck('type', 'id');
        return view('stockmove.create', compact('branches', 'items', 'releaseTypes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
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
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}