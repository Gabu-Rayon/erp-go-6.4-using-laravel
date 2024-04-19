<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemInformation;
use Illuminate\Support\Facades\Http;
use App\Models\CustomField;
use App\Models\ItemClassification;
use App\Models\ItemType;
use App\Models\Details;

class GetItemInformationController extends Controller
{

    public function index()
    {
        return view('productservice.index');
    }

    public function show (ItemInformation $iteminformation) {
        return view('iteminformation.show', compact('iteminformation'));
    }

    public function create()
    {
        return view('iteminformation.create');
    }


    public function edit()
    {
        return view('iteminformation.edit');
        
    }
    // public function getItemInformation()
    // {

    //     // Increase maximum execution time to 300 seconds (5 minutes)
    //     ini_set('max_execution_time', 300);

    //     $url = 'https://etims.your-apps.biz/api/GetItemInformation?date=20220409120000';

    //     $response = Http::withHeaders([
    //         'key' => '123456'
    //     ])->get($url);

    //     $data = $response->json();
    //     $itemLists = $data['data']['data']['itemList'];

    //     \Log::info('API Request Data: ' . json_encode($data));
    //     \Log::info('API Response: ' . $response->body());
    //     \Log::info('API Response Status Code: ' . $response->status());

    //     if (isset($itemLists)) {
    //         try {
    //             foreach ($itemLists as $item) {
    //                 ItemInformation::create([
    //                     'tin' => $item['tin'],
    //                     'itemCd' => $item['itemCd'],
    //                     'itemClsCd' => $item['itemClsCd'],
    //                     'itemTyCd' => $item['itemTyCd'],
    //                     'itemNm' => $item['itemNm'],
    //                     'itemStdNm' => $item['itemStdNm'],
    //                     'orgnNatCd' => $item['orgnNatCd'],
    //                     'pkgUnitCd' => $item['pkgUnitCd'],
    //                     'qtyUnitCd' => $item['qtyUnitCd'],
    //                     'taxTyCd' => $item['taxTyCd'],
    //                     'btchNo' => $item['btchNo'],
    //                     'regBhfId' => $item['regBhfId'],
    //                     'bcd' => $item['bcd'],
    //                     'dftPrc' => $item['dftPrc'],
    //                     'grpPrcL1' => $item['grpPrcL1'],
    //                     'grpPrcL2' => $item['grpPrcL2'],
    //                     'grpPrcL3' => $item['grpPrcL3'],
    //                     'grpPrcL4' => $item['grpPrcL4'],
    //                     'grpPrcL5' => $item['grpPrcL5'],
    //                     'addInfo' => $item['addInfo'],
    //                     'sftyQty' => $item['sftyQty'],
    //                     'isrcAplcbYn' => $item['isrcAplcbYn'],
    //                     'rraModYn' => $item['rraModYn'],
    //                     'useYn' => $item['useYn']
    //                 ]);
    //             }
    //             return redirect()->back()->with('success', 'Item Information added successfully.');
    //         } catch (\Exception $e) {
    //             \Log::error('Error adding Item Information from the API: ' . $e->getMessage());
    //             return redirect()->back()->with('error', 'Error adding Item Information from the API.');
    //         }
    //     } else {
    //         return redirect()->back()->with('error', 'No data found in the API response.');
    //     }
    // }

    public function getItemInformation()
    {
        //execution time to 300 seconds (5 minutes)
        ini_set('max_execution_time', 300);

        $url = 'https://etims.your-apps.biz/api/GetItemInformation?date=20220409120000';

        $response = Http::withHeaders([
            'key' => '123456'
        ])->withOptions([
                    'timeout' => 180,
                ])->get($url);


        $data = $response->json();
        $itemLists = $data['data']['data']['itemList'];

        \Log::info('API Request Data: ' . json_encode($data));
        \Log::info('API Response Status Code: ' . $response->status());

        if (isset($itemLists)) {
            try {
                //batch size
                $batchSize = 100;

                // Calculatebatches
                $totalItems = count($itemLists);
                $totalBatches = ceil($totalItems / $batchSize);

                // Process items in batches
                for ($i = 0; $i < $totalBatches; $i++) {
                    $batchItems = array_slice($itemLists, $i * $batchSize, $batchSize);
                    foreach ($batchItems as $item) {
                        ItemInformation::create([
                            'tin' => $item['tin'],
                            'itemCd' => $item['itemCd'],
                            'itemClsCd' => $item['itemClsCd'],
                            'itemTyCd' => $item['itemTyCd'],
                            'itemNm' => $item['itemNm'],
                            'itemStdNm' => $item['itemStdNm'],
                            'orgnNatCd' => $item['orgnNatCd'],
                            'pkgUnitCd' => $item['pkgUnitCd'],
                            'qtyUnitCd' => $item['qtyUnitCd'],
                            'taxTyCd' => $item['taxTyCd'],
                            'btchNo' => $item['btchNo'],
                            'regBhfId' => $item['regBhfId'],
                            'bcd' => $item['bcd'],
                            'dftPrc' => $item['dftPrc'],
                            'grpPrcL1' => $item['grpPrcL1'],
                            'grpPrcL2' => $item['grpPrcL2'],
                            'grpPrcL3' => $item['grpPrcL3'],
                            'grpPrcL4' => $item['grpPrcL4'],
                            'grpPrcL5' => $item['grpPrcL5'],
                            'addInfo' => $item['addInfo'],
                            'sftyQty' => $item['sftyQty'],
                            'isrcAplcbYn' => $item['isrcAplcbYn'],
                            'rraModYn' => $item['rraModYn'],
                            'useYn' => $item['useYn']
                        ]);
                    }
                }
                return redirect()->back()->with('success', 'Item Information added successfully.');
            } catch (\Exception $e) {
                \Log::error('Error adding Item Information from the API: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Error adding Item Information from the API.');
            }
        } else {
            return redirect()->back()->with('error', 'No data found in the API response.');
        }
    }


    // public function items()
    // {
    //     $ItemInformations = ItemInformation::all();
    //     return response()->json($ItemInformations);
    // }


    public function store(Request $request)
    {

    }
    /**
     * Using Api Endpoint
     *  
     */

     

}