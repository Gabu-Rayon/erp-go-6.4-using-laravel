<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemInformation;
use Illuminate\Support\Facades\Http;

class ItemClassificationController extends Controller
{
    public function getItemClassifications()
    {
        $url = 'https://etims.your-apps.biz/api/GetItemClassificationList?date=20220409120000';

        $response = Http::withHeaders([
            'key' => '123456'
        ])->get($url);

        $data = $response->json()['data'];

        \Log::info('API Request Data: ' . json_encode($data));
        \Log::info('API Response: ' . $response->body());
        \Log::info('API Response Status Code: ' . $response->status());

        if (isset($data['data'])) {
            try {
                foreach ($data['data']['itemList'] as $item) {
                    ItemInformation::create([
                        'itemClsCd' => $item['itemClsCd'],
                        'itemClsNm' => $item['itemClsNm'],
                        'itemClsLvl' => $item['itemClsLvl'],
                        'taxTyCd' => $item['taxTyCd'],
                        'mjrTgYn' => $item['mjrTgYn'],                        
                        'useYn' => $item['useYn']
                    ]);
                }
                // return redirect()->back()->with('success', 'Item Information added successfully.');
                return redirect()->route('productservice.index')->with('success', __('Item Information added successfully created.'));
            } catch (\Exception $e) {
                \Log::error('Error adding Item Information from the API: ' . $e->getMessage());
                // return redirect()->back()->with('error', 'Error adding Item Information from the API.');
                return redirect()->route('productservice.index')->with('error', __('Error adding Item Information from the API.'));
            }
        } else {
            // return redirect()->back()->with('error', 'No data found in the API response.');
            return redirect()->route('productservice.index')->with('error', __('No data found in the API response.'));
        }
    }

}