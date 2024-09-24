<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Exception;
use App\Models\Code;
use App\Models\ConfigSettings;
use Illuminate\Support\Facades\Log;

class CodeController extends Controller
{
    //

    public function getCodesList()
    {
        $config = ConfigSettings::first();

        $url = $config->api_url . 'GetCodeListV2?date=20210101120000';

        try {
            $response = Http::withHeaders([
                'key' => $config->api_key,
            ])->get($url);

            Log::info('CODE LIST RESPONSE');
            Log::info($response);


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
