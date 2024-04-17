<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Exception;
use App\Models\Code;

class CodeController extends Controller
{
    //

    public function getCodesList()
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
                    Code::create([
                        'cdCls' => $class['cdCls'],
                        'cdClsNm' => $class['cdClsNm'],
                        'cdClsDesc' => $class['cdClsDesc'],
                        'useYn' => $class['useYn'],
                        'userDfnNm1' => $class['userDfnNm1'],
                        'userDfnNm2' => $class['userDfnNm2'],
                        'userDfnNm3' => $class['userDfnNm3']
                    ]);
                }
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Error getting codes',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}