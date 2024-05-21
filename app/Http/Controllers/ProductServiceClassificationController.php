<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ProductsServicesClassification;

class ProductServiceClassificationController extends Controller
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
                foreach ($data['data']['itemClsList'] as $item) {
                    ProductsServicesClassification::create([
                        'itemClsCd' => $item['itemClsCd'],
                        'itemClsNm' => $item['itemClsNm'],
                        'itemClsLvl' => $item['itemClsLvl'],
                        'taxTyCd' => $item['taxTyCd'],
                        'mjrTgYn' => $item['mjrTgYn'],                        
                        'useYn' => $item['useYn']
                    ]);
                }
                // return redirect()->back()->with('success', 'Item Information added successfully.');
                return redirect()->route('productservice.index')->with('success', __('Item Classifications Information added successfully created.'));
            } catch (\Exception $e) {
                \Log::error('Error adding Item Information from the API: ' . $e->getMessage());
                return redirect()->route('productservice.index')->with('error', __('Error adding Item Classifications from the API.'));
            }
        } else {
            // return redirect()->back()->with('error', 'No data found in the API response.');
            return redirect()->route('productservice.index')->with('error', __('No data found in the API response.'));
        }
    }


    public function synchronizeItemClassifications()
    {
        try {

            $url = 'https://etims.your-apps.biz/api/GetItemClassificationList?date=20210101120000';

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                        'key' => '123456'
                    ])->timeout(60)->get($url);

            $data = $response->json()['data'];

            $remoteIteminfo = $data['data']['itemClsList'];

            \Log::info('REMOTE ITEM INFO');
            \Log::info($remoteIteminfo);

            $remoteItemInfoToSync = [];

            foreach ($remoteIteminfo as $remoteItem) {
                $item = [
                    'itemClsCd' => $remoteItem['itemClsCd'],
                    'itemClsNm' => $remoteItem['itemClsNm'],
                    'itemClsLvl' => $remoteItem['itemClsLvl'],
                    'taxTyCd' => $remoteItem['taxTyCd'],
                    'mjrTgYn' => $remoteItem['mjrTgYn'],
                    'useYn' => $remoteItem['useYn'],
                ];
                array_push($remoteItemInfoToSync, $item);
            }

            \Log::info('REMOTE ITEM INFO TO SYNC');
            \Log::info($remoteItemInfoToSync);

            $syncedItemInfo = 0;

            foreach ($remoteItemInfoToSync as $remoteItemInfo) {
                $exists = (boolean) ProductsServicesClassification::where('itemClsCd', $remoteItemInfo['itemClsCd'])->exists();
                if (!$exists) {
                    ProductsServicesClassification::create($remoteItemInfo);
                    $syncedItemInfo++;
                }
            }

            if ($syncedItemInfo > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedItemInfo . ' Item Classifications' . 'Successfully'));
            } else {
                return redirect()->back()->with('success', __('Item Classicications Up To Date'));
            }
        } catch (\Exception $e) {
            \Log::info('ERROR SYNCING ITEM CLASSIFICATIONS');
            \Log::info($e);
            return redirect()->back()->with('error', __('Error Syncing Item Classifications'));
        }

    }


}