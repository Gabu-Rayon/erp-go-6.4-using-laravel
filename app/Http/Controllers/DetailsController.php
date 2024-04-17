<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Details;

class DetailsController extends Controller
{
    //

    public function getDetailsList()
    {
        $url = 'https://etims.your-apps.biz/api/GetCodeList?date=20210101120000';

        try {
            $response = Http::withHeaders([
                'key' => '123456'
            ])->get($url);
            $data = $response->json();
            $classList = $data['data']['data']['clsList'];

            if (isset($classList)) {
                foreach ($classList as $class) {
                    $detailsList = $class['dtlList'];

                    if (isset($detailsList)) {
                        foreach ($detailsList as $detail) {
                            Details::create([
                                'cdCls' => $class['cdCls'],
                                'cd' => $detail['cd'],
                                'cdNm' => $detail['cdNm'],
                                'cdDtlDesc' => $detail['cdDesc'],
                                'useYn' => $detail['useYn'],
                                'srtOrd' => $detail['srtOrd'],
                                'userDfnCd1' => $detail['userDfnCd1'],
                                'userDfnCd2' => $detail['userDfnCd2'],
                                'userDfnCd3' => $detail['userDfnCd3']
                            ]);
                        }
                    }
                }
            }


        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error getting details',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}