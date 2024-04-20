<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ItemClassification;
use Illuminate\Support\Facades\Http;

class ItemClassificationController extends Controller
{
    //
    public function index()
    {
        if (\Auth::user()->type == 'company') {
            $itemclassifications = ItemClassification::all();
            \Log::info($itemclassifications);
            return view('itemclassification.index', compact('itemclassifications'));
        }
    }

    public function addCategories()
    {

        $url = 'https://etims.your-apps.biz/api/GetItemClassificationList?date=20210101120000';

        $response = Http::withHeaders([
            'key' => '123456'
        ])->get($url);
        $data = $response->json()['data'];


        \Log::info('API Request Data: ' . json_encode($response));
        \Log::info('API Response: ' . $response->body());
        \Log::info('API Response Status Code: ' . $response->status());

        if (isset($data['data'])) {
            try {
                foreach ($data['data']['itemClsList'] as $item) {
                    ItemClassification::create([
                        'itemClsCd' => $item['itemClsCd'],
                        'itemClsNm' => $item['itemClsNm'],
                        'itemClsLvl' => $item['itemClsLvl'],
                        'taxTyCd' => $item['taxTyCd'],
                        'mjrTgYn' => $item['mjrTgYn'],
                        'useYn' => $item['useYn']
                    ]);
                }
            } catch (\Exception $e) {
                return response()->json([
                    'message' => 'Error adding categories',
                    'error' => $e->getMessage()
                ], 500);
            }
        }
    }

    public function getCategories()
    {
        $categories = ItemClassification::all();
        return response()->json($categories);
    }
}