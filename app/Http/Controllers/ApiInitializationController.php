<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Http;
use App\Models\ApiInitialization;

class ApiInitializationController extends Controller
{
    //
    public function index()
    {
        return view('apiinitialization.index');
    }

    public function create () {
        return view('apiinitialization.create');
    }

    public function store (Request $request) {

        $validator = Validator::make($request->all(), [
            'taxpayeridno' => 'required',
            'bhfId' => 'required',
            'devicesrlno' => 'required'
        ]);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }

        try {
            $url = 'https://etims.your-apps.biz/api/Initialization';

            $taxpayeridno = $request->taxpayeridno;
            $bhfId = $request->bhfId;
            $devicesrlno = $request->devicesrlno;

            $response = Http::withHeaders([
                'key' => 'value'
            ])->post($url, [
                'tin' => $taxpayeridno,
                'bhfId' => $bhfId,
                'dvcSrlNo' => $devicesrlno
            ]);

            // Log::info($response->body());

            $data = $response->json();

            if ($data['resultCd'] != '0000') {
                return redirect()->back()->with('error', $data['resultMsg']);
            }

            $apiInitialization = new ApiInitialization();
            $apiInitialization->tin = $data['tin'];
            $apiInitialization->bhfId = $data['bhfId'];
            $apiInitialization->dvcSrlNo = $data['dvcSrlNo'];
            $apiInitialization->taxprNm = $data['taxprNm'];
            $apiInitialization->bsnsActv = $data['bsnsActv'];
            $apiInitialization->bhfNm = $data['bhfNm'];
            $apiInitialization->bhfOpenDt = $data['bhfOpenDt'];
            $apiInitialization->prvncNm = $data['prvncNm'];
            $apiInitialization->dstrtNm = $data['dstrtNm'];
            $apiInitialization->sctrNm = $data['sctrNm'];
            $apiInitialization->locDesc = $data['locDesc'];
            $apiInitialization->hqYn = $data['hqYn'];
            $apiInitialization->mgrNm = $data['mgrNm'];
            $apiInitialization->mgrTelNo = $data['mgrTelNo'];
            $apiInitialization->mgrEmail = $data['mgrEmail'];
            $apiInitialization->dvcId = $data['dvcId'];
            $apiInitialization->sdcId = $data['sdcId'];
            $apiInitialization->mrcNo = $data['mrcNo'];
            $apiInitialization->cmcKey = $data['cmcKey'];
            $apiInitialization->resultCd = $data['resultCd'];
            $apiInitialization->resultMsg = $data['resultMsg'];
            $apiInitialization->resultDt = $data['resultDt'];

            $apiInitialization->save();


        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while initializing the API');
        }
        
        
        return redirect()->route('apiinitialization.index')->with('success', __('Successfully Initialized.'));
    }
}
