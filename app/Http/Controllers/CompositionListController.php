<?php

namespace App\Http\Controllers;

use App\Models\ItemType;
use Illuminate\Http\Request;
use App\Models\ConfigSettings;
use App\Models\ProductService;
use App\Models\CompositionItem;
use App\Models\CompositionList;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;

class CompositionListController extends Controller
{
    //
    public function index()
    {
        if(\Auth::user()->type == 'company')
        {
        try {
            if (\Auth::user()->type == 'company') {
                $compositionslistitems = CompositionList::all();
                return view('compositionlist.index', compact('compositionslistitems'));
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::info('RENDER COMPOSITION ITEMS INDEX ERROR');
            \Log::info($e);

            return redirect()->back()->with('error', $e->getMessage());
        }
          } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->type == 'company') {
            try {
                // Fetch all product services
                $productServices = ProductService::all();

                // Filter main item codes (Finished material type)
                /***
                 * Where 1 == Raw Material 
                 * where 2 == Finished Product
                 * where 3 == Service 
                 */
                $mainItemCode = $productServices->filter(function ($item) {
                    return $item->itemTyCd == 2 || $item->itemTyCd == 3;
                })->pluck('itemNm', 'kraItemCode');

                // Filter component item codes (Raw material type)
                $compoItemCode = $productServices->filter(function ($item) {
                    return $item->itemTyCd == 1;
                })->pluck('itemNm', 'kraItemCode');

                return view('compositionlist.create', compact('mainItemCode', 'compoItemCode'));
            } catch (\Exception $e) {
                \Log::info('RENDER COMPOSITION ITEMS CREATE ERROR');
                \Log::error($e);
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        // Retrieve the API endpoint config from the database
        $config = ConfigSettings::first();

        if (\Auth::user()->type == 'company') {
            try {
                // Validation code 
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'mainItemCode' => 'required',
                        'items' => 'required|array',
                        'items.*.compoItemCode' => 'required|string',
                        'items.*.compoItemQty' => 'required|integer',
                    ]
                );

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }

                \Log::info('COMPOSITION ITEMS LIST DATA FROM THE FORM: ');
                \Log::info($request->all());

                $data = $request->all();
                $mainItemCode = $data['mainItemCode'];
                $CompositionLists = $data['items'];
                $compositionItemsCount = count($CompositionLists);

                $apiCompositionDataRequest = [
                    'mainItemCode' => $mainItemCode,
                    'compositionItems' => $CompositionLists
                ];

                \Log::info('apiCompositionDataRequest to be sent to API:', $apiCompositionDataRequest);

                $url = $config->api_url . 'AddCompositionItemListV2';

                $response = Http::withOptions(['verify' => false])->withHeaders([
                    'key' => $config->api_key,
                ])->post($url, $apiCompositionDataRequest);

                // Log response data
                \Log::info('API Response Body For Posting Composition List: ' . $response->body());
                \Log::info('API Response Status Code For Posting Composition List: ' . $response->status());

                $responseData = $response->json(); // Decode the response to an array

                if ($responseData['status']) {
                    // Create the composition list once
                    $isKRASync = false; // Default value
                    // Loop through responseData to save each item and isKRASync
                    foreach ($responseData['responseData'] as $itemResponse) {
                        // Update isKRASync based on the response
                        $isKRASync = $itemResponse['isKRASync'] ?? false; // Default to false if not set
                    }

                    // Save the CompositionList with the isKRASync value
                    $compositionList = CompositionList::create([
                        'mainItemCode' => $mainItemCode,
                        'compositionItems_count' => $compositionItemsCount,
                        'created_by' => \Auth::user()->creatorId(),
                        'isKRASync' => $isKRASync,
                    ]);

                    // Save each composition item
                    foreach ($CompositionLists as $item) {
                        \Log::info($item);
                        CompositionItem::create([
                            'mainItemCode_id' => $compositionList->id,
                            'compoItemCode' => $item['compoItemCode'],
                            'compoItemQty' => $item['compoItemQty'],
                            'created_by' => \Auth::user()->creatorId(),
                        ]);
                    }

                    return redirect()->route('compositionlist.index')->with('success', 'Composition List Item Added');
                } else {
                    // Handle case where API returns a failure message
                    return redirect()->back()->with('error', $responseData['message'] ?? 'Failed to add composition items.');
                }

            } catch (\Exception $e) {
                \Log::info($e);
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }



    public function show($id)
    {
        if(\Auth::user()->type == 'company')
        {
            try {
                // Retrieve the composition list by ID
                $compositionList = CompositionList::findOrFail($id);

                // Retrieve the composition items associated with this list
                $compositionItems = CompositionItem::where('mainItemCode_id', $compositionList->id)->get();

                return view('compositionlist.view', compact('compositionList', 'compositionItems'));
            } catch (\Exception $e) {
                return redirect()->back()->with('error', __('Error retrieving composition list.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

     public function  updateStockIO(){
    
     }




}