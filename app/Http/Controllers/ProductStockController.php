<?php

namespace App\Http\Controllers;

use App\Models\ProductService;
use App\Models\ProductStock;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductStockController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        if(
            Auth::user()->type == 'company'
            || Auth::user()->type == 'accountant'
        )
        {
            $productServices = ProductService::where('created_by', '=', Auth::user()->creatorId())->get();
            return view('productstock.index', compact('productServices'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {


    }


    /**
     * Display the specified resource.
     *
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function show(ProductStock $productStock)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $productService = ProductService::find($id);
        if(
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        )
        {
            if($productService->created_by == \Auth::user()->creatorId())
            {
                return view('productstock.edit', compact('productService'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\ProductStock $productStock
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductStock $productStock)
    {
        //
    }
}
