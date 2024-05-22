<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Details;

class DetailsController extends Controller
{
    //

    public function synchronize (Request $request) {
        try {
            
            $detailToSync = array_keys($request->all())[0];

            \Log::info('DETAILS TO SYNC');
            \Log::info($detailToSync);

            $url = 'https://etims.your-apps.biz/api/GetCodeList?date=20210101120000';

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'key' => '123456'
            ])->get($url);
            $data = $response->json();
            $classList = $data['data']['data']['clsList'];


            \Log::info('CLASSLIST');
            \Log::info($classList);

            if ($detailToSync == 'bank') {
                // Filter banks with 'cdCls' value equal to '36'
                $banks = array_filter($classList, function ($item) {
                    return $item['cdCls'] === '36';
                });
            
                \Log::info('FILTERED BANKS');
                \Log::info($banks);
            
                $syncedDetails = 0;
            
                foreach ($banks as $bank) {
                    // Ensure 'dtlList' key exists in the current bank array
                    if (isset($bank['dtlList'])) {
                        foreach ($bank['dtlList'] as $detail) {
                            \Log::info('GIVEN BANK');
                            \Log::info($detail);
                            $exists = (boolean) Details::where('cd', $detail['cd'])->exists();
                            if (!$exists) {
                                Details::create([
                                    'cdCls' => $bank['cdCls'],
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
                        \Log::info('No dtlList found for bank:');
                        \Log::info($bank);
                    }
                }
            
                if ($syncedDetails > 0) {
                    return redirect()->back()->with('success', __('Synced ' . $syncedDetails . ' Banks Successfully'));
                } else {
                    return redirect()->back()->with('success', __('Banks Up To Date'));
                }
            }
            

            if ($detailToSync == 'taxes') {
                // Filter banks with 'cdCls' value equal to '36'
                $banks = array_filter($classList, function ($item) {
                    return $item['cdCls'] === '04';
                });
            
                \Log::info('FILTERED TAXES');
                \Log::info($banks);
            
                $syncedDetails = 0;
            
                foreach ($banks as $bank) {
                    // Ensure 'dtlList' key exists in the current bank array
                    if (isset($bank['dtlList'])) {
                        foreach ($bank['dtlList'] as $detail) {
                            \Log::info('GIVEN TAX');
                            \Log::info($detail);
                            $exists = (boolean) Details::where('cd', $detail['cd'])->exists();
                            if (!$exists) {
                                Details::create([
                                    'cdCls' => $bank['cdCls'],
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
                        \Log::info('No dtlList found for tax:');
                        \Log::info($bank);
                    }
                }
            
                if ($syncedDetails > 0) {
                    return redirect()->back()->with('success', __('Synced ' . $syncedDetails . ' Taxes Successfully'));
                } else {
                    return redirect()->back()->with('success', __('Taxes Up To Date'));
                }
            }

            if ($detailToSync == 'countries') {
                // Filter banks with 'cdCls' value equal to '36'
                $banks = array_filter($classList, function ($item) {
                    return $item['cdCls'] === '05';
                });
            
                \Log::info('FILTERED COUNTRIES');
                \Log::info($banks);
            
                $syncedDetails = 0;
            
                foreach ($banks as $bank) {
                    // Ensure 'dtlList' key exists in the current bank array
                    if (isset($bank['dtlList'])) {
                        foreach ($bank['dtlList'] as $detail) {
                            \Log::info('GIVEN COUNTRY');
                            \Log::info($detail);
                            $exists = (boolean) Details::where('cd', $detail['cd'])->exists();
                            if (!$exists) {
                                Details::create([
                                    'cdCls' => $bank['cdCls'],
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
                        \Log::info('No dtlList found for country:');
                        \Log::info($bank);
                    }
                }
            
                if ($syncedDetails > 0) {
                    return redirect()->back()->with('success', __('Synced ' . $syncedDetails . ' Countries Successfully'));
                } else {
                    return redirect()->back()->with('success', __('Countries Up To Date'));
                }
            }

            if ($detailToSync == 'refundreasons') {
                $banks = array_filter($classList, function ($item) {
                    return $item['cdCls'] === '32';
                });
            
                \Log::info('FILTERED REFUND REASONS');
                \Log::info($banks);
            
                $syncedDetails = 0;
            
                foreach ($banks as $bank) {

                    if (isset($bank['dtlList'])) {
                        foreach ($bank['dtlList'] as $detail) {
                            \Log::info('GIVEN REFUND REASON');
                            \Log::info($detail);
                            $exists = (boolean) Details::where('cd', $detail['cd'])->exists();
                            if (!$exists) {
                                Details::create([
                                    'cdCls' => $bank['cdCls'],
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
                        \Log::info('No dtlList found for refund reason:');
                        \Log::info($bank);
                    }
                }
            
                if ($syncedDetails > 0) {
                    return redirect()->back()->with('success', __('Synced ' . $syncedDetails . ' Refund Reasons Successfully'));
                } else {
                    return redirect()->back()->with('success', __('Refund Reasons Up To Date'));
                }
            }

            if ($detailToSync == 'currencies') {
                $banks = array_filter($classList, function ($item) {
                    return $item['cdCls'] === '33';
                });
            
                \Log::info('FILTERED CURRENCIES');
                \Log::info($banks);
            
                $syncedDetails = 0;
            
                foreach ($banks as $bank) {

                    if (isset($bank['dtlList'])) {
                        foreach ($bank['dtlList'] as $detail) {
                            \Log::info('GIVEN CURRENCY');
                            \Log::info($detail);
                            $exists = (boolean) Details::where('cd', $detail['cd'])->exists();
                            if (!$exists) {
                                Details::create([
                                    'cdCls' => $bank['cdCls'],
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
                        \Log::info('No dtlList found for currency:');
                        \Log::info($bank);
                    }
                }
            
                if ($syncedDetails > 0) {
                    return redirect()->back()->with('success', __('Synced ' . $syncedDetails . ' Currencies Successfully'));
                } else {
                    return redirect()->back()->with('success', __('Currencies Up To Date'));
                }
            }

            if ($detailToSync == 'languages') {
                $banks = array_filter($classList, function ($item) {
                    return $item['cdCls'] === '48';
                });
            
                \Log::info('FILTERED LANGUAGES');
                \Log::info($banks);
            
                $syncedDetails = 0;
            
                foreach ($banks as $bank) {

                    if (isset($bank['dtlList'])) {
                        foreach ($bank['dtlList'] as $detail) {
                            \Log::info('GIVEN LANGUAGE');
                            \Log::info($detail);
                            $exists = (boolean) Details::where('cd', $detail['cd'])->exists();
                            if (!$exists) {
                                Details::create([
                                    'cdCls' => $bank['cdCls'],
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
                        \Log::info('No dtlList found for language:');
                        \Log::info($bank);
                    }
                }
            
                if ($syncedDetails > 0) {
                    return redirect()->back()->with('success', __('Synced ' . $syncedDetails . ' Languages Successfully'));
                } else {
                    return redirect()->back()->with('success', __('Languages Up To Date'));
                }
            }
            

        } catch (\Exception $e) {
            \Log::info('SYNC DETAILS ERROR');
            \Log::info($e);

            return redirect()->back()->with('error', __('Something Went Wrong'));
        }
    }

    public function countries () {
        $countries = Details::where('cdCls', '=', '05')->get();
        
        return view('details.countries')->with('countries', $countries);
    }

    public function refundreasons () {
        $refundreasons = Details::where('cdCls', '=', '32')->get();
        
        return view('details.refundreasons')->with('refundreasons', $refundreasons);
    }

    public function currencies () {
        $currencies = Details::where('cdCls', '=', '33')->get();
        
        return view('details.currencies')->with('currencies', $currencies);
    }

    public function banks () {
        $banks = Details::where('cdCls', '=', '36')->get();

        \Log::info('BANKS');
        \Log::info($banks);
        
        return view('details.banks')->with('banks', $banks);
    }

    public function languages () {
        $languages = Details::where('cdCls', '=', '48')->get();
        
        return view('details.languages')->with('languages', $languages);
    }
}