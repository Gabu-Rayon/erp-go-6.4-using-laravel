<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\UpdateImportItems;
use App\Models\ImportedItems;
use App\Models\ItemInformation;
use App\Models\ImportItemStatusCode;
use Illuminate\Support\Facades\Http;

class UpdateImportedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $updateImportedItems = UpdateImportItems::all();
        return view('updateimportitem.index', compact('updateImportedItems'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $importedItems = ImportedItems::all()->pluck('itemName', 'taskCode');
        $items = ItemInformation::all()->pluck('itemNm', 'itemCd');
        $importItemStatusCode = ImportItemStatusCode::all()->pluck('code', 'id');
        return view('updateimportitem.create', compact('importedItems', 'items', 'importItemStatusCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('IMPORTED ITEMS DATA');
            \Log::info($request->all());

            // $url = 'https://etims.your-apps.biz/api/MapImportedItem';

            // $response = Http::withHeaders([
            //     'key' => '123456'
            // ])->post($url, [
            //     'taskCode' => $request['importedItemName'],
            //     'itemCode' => $request['item'],
            // ]);

            // \Log::info('IMPORTED ITEMS API RESPONSE');
            // \Log::info($response);

            $importItem = ImportedItems::where('taskCode', $request['importedItemName'])->first();
            $givenItem = ItemInformation::where('itemCd', $request['item'])->first();
            $srNo = $importItem->srNo;
            $taskCode = $request['importedItemName'];
            $declarationDate = $importItem->declarationDate;
            $itemSeq = $importItem->itemSeq;
            $hsCode = $importItem->hsCode;
            $itemCd = $givenItem->itemCd;
            $itemClsCd = $givenItem->itemClsCd;

            UpdateImportItems::create([
                'srNo' => $srNo,
                'taskCode' => $taskCode,
                'declarationDate' => $declarationDate,
                'itemSeq' => $itemSeq,
                'hsCode' => $hsCode,
                'itemClassificationCode' => $itemClsCd,
                'itemCode' => $itemCd
            ]);

            return redirect()->back()->with('success', 'Item Added Successfully');
        } catch (\Exception $e) {
            \Log::info('IMPORTED ITEMS ERROR');
            \Log::info($e);
            return redirect()->back()->with('error', 'Something Went Wrong');
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
