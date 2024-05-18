<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportedItems;
use Illuminate\Support\Carbon;
use App\Models\ItemInformation;
use App\Models\ImportItemStatusCode;
use Illuminate\Support\Facades\Http;

class ImportedItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $importedItems = ImportedItems::all();
            return view('importeditems.index', compact('importedItems'));
        } catch (\Exception $e) {
            \Log::error($e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $importedItems = ImportedItems::all()->pluck('itemName', 'taskCode');
        $items = ItemInformation::all()->pluck('itemNm', 'id');
        $importItemStatusCode = ImportItemStatusCode::all()->pluck('code', 'KRA_Code');
        return view('importeditems.mapImportedItem', compact('importedItems', 'items', 'importItemStatusCode'));
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            \Log::info('IMPORTED ITEMS DATA  From the Form :');
            \Log::info($request->all());

            // Retrieve the imported item by its task code
            $importItem = ImportedItems::where('taskCode', $request['importedItemName'])->first();

            // Ensure the imported item exists
            if (!$importItem) {
                return redirect()->back()->with('error', 'Imported item  Selected not found in Database');
            }

            // Retrieve the given item by its item code
            $givenItem = ItemInformation::where('itemCd', $request['item'])->first();

            // Ensure the given item exists
            if (!$givenItem) {
                return redirect()->back()->with('error', 'Select item  not found in the Database ');
            }

            // Extract necessary details from the imported item
            $srNo = $importItem->srNo;
            $taskCode = $request['importedItemName'];
            $declarationDate = $importItem->declarationDate;
            $itemSeq = $importItem->itemSeq;
            $hsCode = $importItem->hsCode;
            $itemCd = $givenItem->itemCd;
            $itemClsCd = $givenItem->itemClsCd;
            $importItemStatusCode = $request['importItemStatusCode'];
            $occurredDate = $importItem->occurredDate;
            $remark = $request['remark'];

            $url = 'https://etims.your-apps.biz/api/MapImportedItem';

            $response = Http::withHeaders([
                'key' => '123456',
                'accept' => '*/*',
                'Content-Type' => 'application/json'
            ])->post($url, [
                        'importItemStatusCode' => $request['importItemStatusCode'],
                        'declarationDate' => $declarationDate,
                        'occurredDate' => $occurredDate,
                        'remark' => $remark,
                        'importedItemLists' => [
                            [
                                'taskCode' => $request['importedItemName'],
                                'itemCode' => $request['item'],
                            ]
                        ]
                    ]);

            \Log::info('IMPORTED ITEMS API RESPONSE : ');
            \Log::info($response);

            // Code to update the Imported item status, mapped_product_id, mapped_date
            $importItem->update([
                'status' => $importItemStatusCode,
                'mapped_product_id' => $givenItem->id,
                'mapped_date' => Carbon::now()->format('Ymd'),  // Current date in 'Ymd' format
            ]);
            return redirect()->route('importeditems.index')->with('success', __('Product / Item Mapped Successfully.'));
        } catch (\Exception $e) {
            \Log::info('IMPORTED ITEMS Mapping Error Exception ERROR : ');
            \Log::info($e);
            return redirect()->back()->with('error', 'Something Went Wrong When Mapping Imported Item');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $importedItem = ImportedItems::find($id);
        return view('importeditems.show', compact('importedItem'));
    }

        public function GetImportedItemInformation()
    {
        try {
            ini_set('max_execution_time', 300);
            $url = 'https://etims.your-apps.biz/api/GetImportedItemInformation?date=20220409';

            $response = Http::withHeaders([
                'key' => '123456'
            ])->get($url);

            $data = $response->json()['data'];

            \Log::info('API  Data Request for getting Imported Item Information : ' . json_encode($data));
            \Log::info('API Body Data Request for getting Imported Item Information: ' . $response->body());
            \Log::info('API Response Status Code: ' . $response->status());

            if (isset($data['data'])) {
                try {
                    foreach ($data['data']['itemClsList'] as $importedItem) {
                        ImportedItems::create([
                            'srNo' => $importedItem['srNo'],
                            'taskCode' => $importedItem['taskCode'],
                            'itemName' => $importedItem['itemName'],
                            'hsCode' => $importedItem['hsCode'],
                            'pkgUnitCode' => $importedItem['pkgUnitCode'],
                            'netWeight' => $importedItem['netWeight'],
                            'invForCode' => $importedItem['invForCode'],
                            'declarationDate' => $importedItem['declarationDate'],
                            'orginNationCode' => $importedItem['orginNationCode'],
                            'qty' => $importedItem['qty'],
                            'supplierName' => $importedItem['supplierName'],
                            'nvcfcurExcrt' => $importedItem['nvcfcurExcrt'],
                            'itemSeq' => $importedItem['itemSeq'],
                            'exprtNatCode' => $importedItem['exprtNatCode'],
                            'qtyUnitCode' => $importedItem['qtyUnitCode'],
                            'agentName' => $importedItem['agentName'],
                            'declarationNo' => $importedItem['declaratioNo'],
                            'package' => $importedItem['package'],
                            'grossWeight' => $importedItem['grossWeight'],
                            'invForCurrencyAmount' => $importedItem['invForCurrencyAmount'],
                            'status' => $importedItem['status']
                        ]);
                    }
                    // return redirect()->back()->with('success', 'Item Information added successfully.');
                    return redirect()->route('importeditems.index')->with('success', __('Imported Items  Created successfully .'));
                } catch (\Exception $e) {
                    \Log::error('Error adding Imported Items from the API: ' );
                    \Log::error($e);
                    // return redirect()->back()->with('error', 'Error adding Item Information from the API.');
                    return redirect()->route('importeditems.index')->with('error', __('Error adding Imported Items from the API.'));
                }
            } else {
                // return redirect()->back()->with('error', 'No data found in the API response.');
                return redirect()->route('importeditems.index')->with('error', __('No data found in the API response.'));
            }
        } catch (\Exception $e) {
            \Log::error($e);
            // return redirect()->back()->with('error', 'Error adding Item Information from the API.');
            return redirect()->route('importeditems.index')->with('error', __('Error adding Imported Items from the API.'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ImportedItems $importedItems)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ImportedItems $importedItems)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ImportedItems $importedItems)
    {
        //
    }

}