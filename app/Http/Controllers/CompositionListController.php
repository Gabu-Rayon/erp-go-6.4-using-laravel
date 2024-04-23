<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\CompositionList;
use App\Models\ItemInformation;

class CompositionListController extends Controller
{
    //
    public function index()
    {
        $compositionslist = CompositionList::all();
        \Log::info($compositionslist);
        return view('compositionlist.index', compact('compositionslist'));
    }

    public function create()
    {
        try {
            $iteminfo = ItemInformation::all()->pluck('itemCd', 'itemNm');
            return view('compositionlist.create', compact('iteminfo'));
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while fetching data');
        }
    }


    public function store(Request $request)
    {
        // Validate the incoming request data
        $validator = Validator::make($request->all(), [
            'main_item_code' => 'required|string',
            'composition_item_code.*' => 'required|string',
            'composition_item_quantity.*' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        try {
            // Prepare the data to be sent to the API
            $data = [
                'mainItemCode' => $request->input('main_item_code'),
                'compositionItems' => [
                    // Array to hold the composition items

                ],
            ];

            // Get the composition item codes and quantities
            $compositionItemCodes = $request->input('composition_item_code');
            $compositionItemQuantities = $request->input('composition_item_quantity');

            // Make sure compositionItemCodes is an array
            if (!is_array($compositionItemCodes)) {
                throw new \Exception('Composition item codes must be an array');
            }

            // Loop through the composition item codes and add them to the data array
            foreach ($compositionItemCodes as $key => $compositionItemCode) {
                $data['compositionItems'][] = [
                    'compoItemCode' => $compositionItemCode,
                    'compoItemQty' => $compositionItemQuantities[$key],
                ];
            }

            // Create a new CompositionList record in the local database
            $compositionList = CompositionList::create([
                'mainItemCode' => $data['mainItemCode'],
                'compositionItems' => json_encode($data['compositionItems']), // Encode the array as JSON before storing
            ]);


            // Send the POST request to the API endpoint
            $response = Http::withHeaders([
                'accept' => 'application/json',
                'key' => '123456',
            ])->post('https://etims.your-apps.biz/api/AddCompositionItemList', $data);

            \Log::info('API Request Data: ' . json_encode($data));
            \Log::info('API Response: ' . $response->body());
            \Log::info('API Response Status Code: ' . $response->status());

            // Check if the request was successful
            if ($response->successful()) {
                // API call was successful
                return redirect()->route('compositionlist.index')->with('success', __('Composition List created successfully'));
            } else {
                // API call failed
                Log::error('Failed to post Composition List data to API. Status code: ' . $response->status());
                return redirect()->back()->with('error', __('Failed to post Composition List data to API'));
            }
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while posting data to the API');
        }
    }
}