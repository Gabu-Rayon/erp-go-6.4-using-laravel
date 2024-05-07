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
        $compositionslistitems = CompositionItem::all();
        $compositionslist = CompositionList::all();
        return view('compositionlist.index', compact('compositionslistitems'));
    }

    public function create()
    {
        try {
            $mainItemCode = ItemInformation::all()->pluck('itemNm','itemCd');
            $compoItemCode = ItemType::all()->pluck('item_type_name', 'item_type_code');
            return view('compositionlist.create', compact('mainItemCode', 'compoItemCode'));
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        try {
            \Log::info('COMPO ITEMS LIST DATA');
            \Log::info($request->all());
            $data = $request->all();
            $mainItemCode = $data['mainItemCode'];
            $compositionItems = $data['items'];

            $url = 'https://etims.your-apps.biz/api/AddCompositionItemList';

            $response = Http::withHeaders([
                'key' => '123456',
            ])->post($url, [
                'mainItemCode' => $mainItemCode,
                'compositionItems' => $compositionItems
            ]);

            \Log::info($response);

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
        } catch (\Exception $e) {
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}