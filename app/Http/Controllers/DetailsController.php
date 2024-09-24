<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\ConfigSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Details;
use Exception;
use Illuminate\Support\Facades\Log;

class DetailsController extends Controller
{
    //

    public function synchronize(Request $request)
    {
        try {
            $detailToSync = array_keys($request->all())[0];

            $config = ConfigSettings::first();

            $url = $config->api_url . 'GetCodeListV2?date=20210101120000';

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'key' => $config->api_key,
            ])->get($url);

            $data = $response->json();
            $classList = $data['data']['data']['clsList'];

            Log::info('CLASSLIST');
            Log::info(json_encode($classList));

            $syncMap = [
                'bank' => '36',
                'taxes' => '04',
                'countries' => '05',
                'refundreasons' => '32',
                'currencies' => '33',
                'languages' => '48',
                'paymenttypes' => '07'
            ];

            if (!isset($syncMap[$detailToSync])) {
                return redirect()->back()->with('error', __('Invalid detail to sync.'));
            }

            $cdClsValue = $syncMap[$detailToSync];

            $filteredItems = array_filter($classList, function ($item) use ($cdClsValue) {
                return $item['cdCls'] === $cdClsValue;
            });

            Log::info('FILTERED ITEMS');
            Log::info($filteredItems);

            if (empty($filteredItems)) {
                return redirect()->back()->with('error', __('No items found to sync.'));
            }

            // Assuming that $filteredItems is not empty and has the required structure.
            $this->syncCodes($filteredItems, $detailToSync);
            $syncedDetails = $this->syncDetails($filteredItems);

            if ($syncedDetails > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedDetails . ' ' . ucfirst($detailToSync) . ' Successfully'));
            } else {
                return redirect()->back()->with('success', __(ucfirst($detailToSync) . ' Up To Date'));
            }
        } catch (Exception $e) {
            Log::error('Synchronization failed: ' . $e->getMessage());
            return redirect()->back()->with('error', __('Synchronization failed. Please try again.'));
        }
    }

    private function syncCodes(array $filteredItems, string $detailType)
    {
        $firstItem = reset($filteredItems);

        Code::firstOrCreate([
            'cdCls' => $firstItem['cdCls'],
            'cdClsNm' => $firstItem['cdClsNm'],
            'cdClsDesc' => $firstItem['cdClsDesc'],
            'useYn' => $firstItem['useYn'],
            'userDfnNm1' => $firstItem['userDfnNm1'],
            'userDfnNm2' => $firstItem['userDfnNm2'],
            'userDfnNm3' => $firstItem['userDfnNm3'],
        ]);
    }

    private function syncDetails(array $filteredItems)
    {
        $syncedDetails = 0;

        foreach ($filteredItems as $item) {
            if (isset($item['dtlList'])) {
                foreach ($item['dtlList'] as $detail) {
                    Log::info('SYNCING DETAIL');
                    Log::info($detail);

                    if (!Details::where('cd', $detail['cd'])->exists()) {
                        Details::create([
                            'cdCls' => $item['cdCls'],
                            'cd' => $detail['cd'],
                            'cdNm' => $detail['cdNm'],
                            'cdDesc' => $detail['cdDesc'],
                            'useYn' => $detail['useYn'],
                            'srtOrd' => $detail['srtOrd'],
                            'userDfnCd1' => $detail['userDfnCd1'],
                            'userDfnCd2' => $detail['userDfnCd2'],
                            'userDfnCd3' => $detail['userDfnCd3'],
                        ]);
                        $syncedDetails++;
                    }
                }
            } else {
                Log::info('No dtlList found for item:');
                Log::info($item);
            }
        }

        return $syncedDetails;
    }


    public function countries()
    {
        $countries = Details::where('cdCls', '=', '05')->get();

        return view('details.countries')->with('countries', $countries);
    }

    public function refundreasons()
    {
        $refundreasons = Details::where('cdCls', '=', '32')->get();

        return view('details.refundreasons')->with('refundreasons', $refundreasons);
    }

    public function currencies()
    {
        $currencies = Details::where('cdCls', '=', '33')->get();

        return view('details.currencies')->with('currencies', $currencies);
    }

    public function banks()
    {
        $banks = Details::where('cdCls', '=', '36')->get();

        Log::info('BANKS');
        Log::info($banks);

        return view('details.banks')->with('banks', $banks);
    }

    public function languages()
    {
        $languages = Details::where('cdCls', '=', '48')->get();

        return view('details.languages')->with('languages', $languages);
    }

    public function paymentTypes()
    {
        $paymentTypes = Details::where('cdCls', '=', '07')->get();

        return view('details.payment-types', compact('paymentTypes'));
    }
}
