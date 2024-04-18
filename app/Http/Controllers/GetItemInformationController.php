<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemInformation;
use Illuminate\Support\Facades\Http;

class GetItemInformationController extends Controller
{

    public function index()
    {
        return view('iteminformation.index');

    }

    public function create()
    {
        return view('iteminformation.create');
    }


    public function edit()
    {
        return view('iteminformation.edit');
        
    }
    public function getItemInformation()
    {
        $url = 'https://etims.your-apps.biz/api/GetItemInformation?date=20220409120000';

        // $response = Http::withHeaders([
        //     'key' => '123456'
        // ])->get($url);

        $response = Http::withHeaders([
            'key' => '123456'
        ])->timeout(3000)->get($url);;

        $data = $response->json()['data'];

        \Log::info('API Request Data: ' . json_encode($data));
        \Log::info('API Response: ' . $response->body());
        \Log::info('API Response Status Code: ' . $response->status());

        if (isset($data['data'])) {
            try {
                foreach ($data['data']['itemList'] as $item) {
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