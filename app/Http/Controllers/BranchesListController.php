<?php

namespace App\Http\Controllers;

use App\Models\BranchesList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BranchesListController extends Controller
{

    public function index()
    {
        $branches = BranchesList::all();

        return view('brancheslist.index', compact('branches'));
    }
    public function getBranchesList()
    {
        $url = 'https://etims.your-apps.biz/api/GetBranchList?date=20220409120000';

        try {
            $response = Http::withHeaders([
                'key' => '123456'
            ])->get($url);
            $data = $response->json();
            $branchesList = $data['data']['data']['bhfList'];

            if (isset($branchesList)) {
                foreach ($branchesList as $list) {
                    BranchesList::create([
                        'tin' => $list['tin'],
                        'bhfId' => $list['bhfId'],
                        'bhfNm' => $list['bhfNm'],
                        'bhfSttsCd' => $list['bhfSttsCd'],
                        'prvncNm' => $list['prvncNm'],
                        'dstrtNm' => $list['dstrtNm'],
                        'sctrNm' => $list['sctrNm'],
                        'locDesc' => $list['locDesc'],
                        'mgrNm' => $list['mgrNm'],
                        'mgrTelNo' => $list['mgrTelNo'],
                        'mgrEmail' => $list['mgrEmail'],
                        'hqYn' => $list['hqYn']
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error getting notices',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function getBranchByName($bhfNm) {
        try {
            $branch = BranchesList::where('bhfNm', $bhfNm)->first();
            return response()->json([
                'message' => 'success',
                'data' => $branch
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'erroe',
                'data' => $e->getMessage()
            ]);
        }
    }
}