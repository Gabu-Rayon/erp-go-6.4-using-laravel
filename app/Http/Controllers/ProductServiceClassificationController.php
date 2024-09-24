<?php

namespace App\Http\Controllers;

use App\Models\ConfigSettings;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\ProductsServicesClassification;
use Illuminate\Support\Facades\Log;

class ProductServiceClassificationController extends Controller
{
    public function getItemClassifications()
    {
        $config = ConfigSettings::first();

        $url = $config->api_url . 'GetItemClassificationListV2?date=20210101120000';

        $response = Http::withHeaders([
            'key' => $config->api_key
        ])->get($url);

        Log::info('ITEM CLASSIFICATIONS RESPONSE');
        Log::info($response);

        $data = $response->json()['data'];

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
                return redirect()->route('productservice.index')->with('success', __('Item Classifications Information added successfully created.'));
            } catch (\Exception $e) {
                Log::error('Error adding Item Information from the API: ' . $e->getMessage());
                return redirect()->route('productservice.index')->with('error', __('Error adding Item Classifications from the API.'));
            }
        } else {
            return redirect()->route('productservice.index')->with('error', __('No data found in the API response.'));
        }
    }


    public function synchronizeItemClassifications()
    {
        try {
            $config = ConfigSettings::first();

            $url = $config->api_url . 'GetItemClassificationListV2?date=20210101120000';

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'key' => $config->api_key
            ])->timeout(60)->get($url);

            Log::info('ITEM CLASSIFICATIONS RESPONSE');
            Log::info($response);

            $data = $response->json()['responseData'];

            $remoteIteminfo = $data['itemClsList'];

            Log::info('REMOTE ITEM INFO');
            Log::info($remoteIteminfo);

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

            Log::info('REMOTE ITEM INFO TO SYNC :', $remoteItemInfoToSync);

            $syncedItemInfo = 0;

            foreach ($remoteItemInfoToSync as $remoteItemInfo) {
                $exists = (bool) ProductsServicesClassification::where('itemClsCd', $remoteItemInfo['itemClsCd'])->exists();
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
            Log::info('ERROR SYNCING ITEM CLASSIFICATIONS');
            Log::info($e);
            return redirect()->back()->with('error', __('Error Syncing Item Classifications'));
        }
    }

    public function searchItemClassificationsByDate(Request $request)
    {
        // Log the request from the form
        Log::info('Synchronization request received From Searching the Item Classification Search Form:', $request->all());

        // Get the date passed from the search form
        $date = $request->input('searchItemClassificationByDate');
        if (!$date) {
            return redirect()->back()->with('error', __('Date is required for synchronization Search for Item Classification.'));
        }

        // Format the date using Carbon
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd') . '000000';

        Log::info('Date Formatted for Synchronization request:', ['formattedDate' => $formattedDate]);

        try {
            $config = ConfigSettings::first();

            $url = $config->api_key . 'GetItemClassificationListV2?date=' . $formattedDate;

            $response = Http::withOptions(['verify' => false])
                ->withHeaders(['key' => '123456'])
                ->get($url);

            $data = $response->json()['data'];
            Log::info('REMOTE Item Classification INFO From Data Response', ['remote Item Classifications' => $data]);

            if (!isset($data['data']['itemClsList'])) {
                return redirect()->back()->with('error', __('There is no search result.'));
            }

            $remoteItemClassificationsinfo = $data['data']['itemClsList'];
            Log::info('REMOTE Item Classification INFO', ['remoteItemClassificationsinfo' => $remoteItemClassificationsinfo]);

            $remoteItemClassificationsinfoToSync = [];
            foreach ($remoteItemClassificationsinfo as $remoteItemClassification) {
                $itemClassification = [
                    'itemClsCd' => $remoteItemClassification['itemClsCd'],
                    'itemClsNm' => $remoteItemClassification['itemClsNm'],
                    'itemClsLvl' => $remoteItemClassification['itemClsLvl'],
                    'taxTyCd' => $remoteItemClassification['taxTyCd'],
                    'mjrTgYn' => $remoteItemClassification['mjrTgYn'],
                    'useYn' => $remoteItemClassification['useYn'],
                ];
                array_push($remoteItemClassificationsinfoToSync, $itemClassification);
            }

            Log::info('REMOTE ITEM CLASSIFICATIONS INFO TO SYNC:', ['remoteItemClassificationsinfoToSync' => $remoteItemClassificationsinfoToSync]);

            $syncedLocalItemClassificationsinfo = 0;
            foreach ($remoteItemClassificationsinfoToSync as $remoteItemClassificationInfo) {
                $exists = ProductsServicesClassification::where('itemClsCd', $remoteItemClassificationInfo['itemClsCd'])->exists();
                if (!$exists) {
                    ProductsServicesClassification::create($remoteItemClassificationInfo);
                    $syncedLocalItemClassificationsinfo++;
                }
            }

            if ($syncedLocalItemClassificationsinfo > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedLocalItemClassificationsinfo . ' Item Classification Successfully'));
            } else {
                return redirect()->back()->with('success', __('Item Classification/s Up To Date'));
            }
        } catch (\Exception $e) {
            Log::error('Error syncing Item Classification:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Error Syncing Item Classification'));
        }
    }
}
