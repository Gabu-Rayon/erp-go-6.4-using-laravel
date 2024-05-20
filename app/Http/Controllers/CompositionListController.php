<?php

namespace App\Http\Controllers;

use App\Models\CompositionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\CompositionList;
use App\Models\ItemInformation;
use App\Models\ItemType;

class CompositionListController extends Controller
{
    //
    public function index()
    {
        if (\Auth::user()->can('manage purchase')) {
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
        if (\Auth::user()->can('manage purchase')) {
            try {
                if (\Auth::user()->type == 'company') {
                    $mainItemCode = ItemInformation::all()->pluck('itemNm', 'itemCd');
                    $compoItemCode = ItemType::all()->pluck('item_type_name', 'item_type_code');
                    return view('compositionlist.create', compact('mainItemCode', 'compoItemCode'));
                } else {
                    return redirect()->back()->with('error', 'Permission Denied');
                }
            } catch (\Exception $e) {
                \Log::info('RENDER COMPOSITION ITEMS CREATE ERROR');
                Log::error($e);
                return redirect()->back()->with('error', $e->getMessage());
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if (\Auth::user()->can('manage purchase')) {
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

                \Log::info('COMPOSITION ITEMS LIST DATA  FROM THE FORM: ');
                \Log::info($request->all());

                $data = $request->all();
                $mainItemCode = $data['mainItemCode'];
                $CompositionLists = $data['items'];
                $compositionItemsCount = count($CompositionLists);

                $apiCompositionDataRequest = [
                    'mainItemCode' => $mainItemCode,
                    'CompositionLists' => $CompositionLists
                ];

                \Log::info('apiCompositionDataRequest to be sent to API:', $apiCompositionDataRequest);

                $url = 'https://etims.your-apps.biz/api/AddCompositionListList';

                $response = Http::withOptions(['verify' => false])->withHeaders([
                    'key' => '123456',
                ])->post($url, $apiCompositionDataRequest);


                //Log response data
                \Log::info('API Response  Body For Posting Composition List: ' . $response->body());
                \Log::info('API Response Status Code For Posting Composition List: ' . $response->status());

                \Log::info('Composition List Api  API RESPONSE');
                \Log::info('Response Details : ' . $response);

                // if ($response['statusCode'] == 400) {
                //     return redirect()->back()->with('error', 'Composition List Cannot Be added');
                // }
                // CompositionList has a column named `mainItemCode` and `compositionItems_count`
                $compositionList = CompositionList::create([
                    'mainItemCode' => $mainItemCode,
                    'compositionItems_count' => $compositionItemsCount,
                    'created_by' => \Auth::user()->creatorId(),
                ]);

                //composition items for each composition list referencing the id of the composition list on each item column
                foreach ($CompositionLists as $item) {
                    \Log::info($item);
                    CompositionItem::create([
                        'mainItemCode_id' => $compositionList->id,
                        'compoItemCode' => $item['compoItemCode'],
                        'compoItemQty' => $item['compoItemQty'],
                        'created_by'=> \Auth::user()->creatorId(), 
                    ]);
                }
                return redirect()->route('compositionlist.index')->with('success', 'Composition List Item Added');

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
        if (\Auth::user()->can('manage purchase')) {
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




}