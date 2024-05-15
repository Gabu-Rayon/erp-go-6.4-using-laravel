<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\CompositionList;
use App\Models\CompositionItem;
use App\Models\ItemInformation;
use App\Models\ItemType;

class CompositionListController extends Controller
{
    //
    public function index()
    {
        try {
            if (\Auth::user()->type == 'company') {
                $compositionslistitems = CompositionItem::all();
                return view('compositionlist.index', compact('compositionslistitems'));
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::info('RENDER COMPOSITION ITEMS INDEX ERROR');
            \Log::info($e);

            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        try {
            if (\Auth::user()->type == 'company') {
                $mainItemCode = ItemInformation::all()->pluck('itemNm','itemCd');
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
    }


    public function store(Request $request)
    {
        try {
            if (\Auth::user()->type == 'company') {


                \Log::info('COMPO ITEMS LIST DATA');
                \Log::info($request->all());
                $data = $request->all();
                $mainItemCode = $data['mainItemCode'];
                $compositionItems = $data['items'];

                $url = 'https://etims.your-apps.biz/api/AddCompositionItemList';

                $response = Http::withOptions(['verify' => false])->withHeaders([
                    'key' => '123456',
                ])->post($url, [
                    'mainItemCode' => $mainItemCode,
                    'compositionItems' => $compositionItems
                ]);

                \Log::info($response);

                if ($response["statusCode"] != 200) {
                    return redirect()->back()->with('error', 'Something Went Wrong');
                }

                CompositionList::create([
                    'mainItemCode' => $mainItemCode
                ]);

                foreach ($data['items'] as $item) {
                    \Log::info($item);
                    CompositionItem::create([
                        'mainItemCode'=> $mainItemCode,
                        'compoItemCode' => $item['compoItemCode'],
                        'compoItemQty' => $item['quantity']
                    ]);
                }


                return redirect()->to('compositionlist')->with('success', 'Composition List Item Added');
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}