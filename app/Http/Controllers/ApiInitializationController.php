<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ApiInitialization;
use App\Models\BranchesList;
use App\Models\ConfigSettings;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ApiInitializationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            if (\Auth::user()->type == 'super admin') {
                $apiinitializations = ApiInitialization::all();
                return view('apiinitialization.index', compact('apiinitializations'));
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::error('RENDER API INITIALIZATION INDEX ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            if (\Auth::user()->type == 'super admin') {
                return view('apiinitialization.create');
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::error('RENDER API INITIALIZATION CREATE ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        if (\Auth::user()->type == 'super admin') {

            $validator = \Validator::make($request->all(), [
                'taxpayeridno' => 'required',
                'bhfId' => 'required',
                'devicesrlno' => 'required'
            ]);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('error', $messages->first());
            }

            try {
                $config = ConfigSettings::first();

                $url = $config->api_url . 'InitializationV2';

                $taxpayeridno = $request->taxpayeridno;
                $bhfId = $request->bhfId;
                $devicesrlno = $request->devicesrlno;

                $response = Http::withOptions([
                    'verify' => false
                ])->withHeaders([
                    'key' => $config->api_key,
                ])->post($url, [
                    'tin' => $taxpayeridno,
                    'bhfId' => $bhfId,
                    'dvcSrlNo' => $devicesrlno
                ]);

                \Log::info('CREATE API INITIALIZATION API RESPONSE');
                \Log::info($response);

                if (!$response['status']) {
                    return redirect()->back()->with('error', $response['message']);
                }

                $data = $response->json();

                if ($data['data']['resultCd'] != '0000') {
                    \Log::info($data);
                    return redirect()->back()->with('error', $data['data']['resultMsg']);
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
        } else {
            return redirect()->back()->with('error', 'Permission Denied');
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(ApiInitialization $apiinitialization)
    {
        try {
            if (\Auth::user()->type == 'super admin') {
                return view('apiinitialization.show', compact('apiinitialization'));
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::error('RENDER API INITIALIZATION SHOW ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ApiInitialization $apiinitialization)
    {
        try {
            if (\Auth::user()->type == 'superadmin') {
                $branches = BranchesList::all()->pluck('bhfNm', 'bhfNm');
                return view('apiinitialization.edit', compact('apiinitialization', 'branches'));
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::error('RENDER API INITIALIZATION EDIT ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ApiInitialization $apiinitialization)
    {
        try {
            if (\Auth::user()->type == 'super admin') {
                $data = $request->all();
                \Log::info('STORE EXISTING INITIALIZATION REQUEST DATA');
                \Log::info($data);
                \Log::info('STORE EXISTING INITIALIZATION GIVEN INITIALIZATION');
                \Log::info($apiinitialization);
                return redirect()->to('apiinitialization')->with('success', 'Initialization Updated');
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::error('STORE EXISTING VIEW ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            if (\Auth::user()->type == 'super admin') {
                $apiInitialization = ApiInitialization::find($id);
                $apiInitialization->delete();
                return redirect()->route('apiinitialization.index')->with('success', 'Initialization Deleted');
            } else {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::error('DELETE API INITIALIZATION ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
