@extends('layouts.admin')
@section('page-title')
    {{ __('Manage Purchase') }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Purchase') }}</li>
@endsection
@push('script-page')
    <script>
        $('.copy_link').click(function(e) {
            e.preventDefault();
            var copyText = $(this).attr('href');

            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);

            document.execCommand('copy');
            show_toastr('success', 'Url copied to clipboard', 'success');
        });
    </script>
@endpush


@section('action-btn')
    <div class="float-end">


        {{--        <a href="{{ route('bill.export') }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip" title="{{__('Export')}}"> --}}
        {{--            <i class="ti ti-file-export"></i> --}}
        {{--        </a> --}}

        @can('create purchase')
            <a href="{{ route('purchase.create', 0) }}" class="btn btn-sm btn-primary" data-bs-toggle="tooltip"
                title="{{ __('Create') }}">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection


@section('content')


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body table-border-style">
                    <div class="table-responsive">

                        @if ($purchases['statusCode'] === 200 && $purchases['message'] === 'Success')
                            <table class="table datatable">
                                <thead>
                                    <tr>
                                        <th>Supplier TIN</th>
                                        <th>Supplier Name</th>
                                        <th>Supplier BhfId</th>
                                        <th>Invoice Number</th>
                                        <th>Supplier SDC ID</th>
                                        <th>Supplier Merchant No</th>
                                        <th>Supplier Receipt Code</th>
                                        <th>Supplier Pmt Type Code</th>
                                        <th>Supplier Confirm Date</th>
                                        <th>Sales Date</th>
                                        <th>StockRsl Date</th>
                                        <th>Total Item Cnt</th>
                                        <th>Taxable Amount A</th>
                                        <th>Taxable Amount B</th>
                                        <th>Taxable Amount C</th>
                                        <th>Taxable Amount D</th>
                                        <th>Taxable Amount B</th>
                                        <th>Taxable Rate A</th>
                                        <th>Taxable Rate B</th>
                                        <th>Taxable Rate C</th>
                                        <th>Taxable Rate D</th>
                                        <th>Taxable Rate E</th>
                                        <th>Taxable Amount A</th>
                                        <th>Taxable Amount B</th>
                                        <th>Taxable Amount C</th>
                                        <th>Taxable Amount D</th>
                                        <th>Taxable Amount E</th>
                                        <th>Total Taxable Amount</th>
                                        <th>Total Tax Amount</th>
                                        <th>Total Amount</th>
                                        <th>Remark</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    @foreach ($purchases['data']['data']['saleList'] as $purchase)
                                        <tr>
                                            <td>{{ $purchase['spplrTin'] }}</td>
                                            <td>{{ $purchase['spplrNm'] }}</td>
                                            <td>{{ $purchase['spplrBhfId'] }}</td>
                                            <td>{{ $purchase['spplrInvcNo'] }}</td>
                                            <td>{{ $purchase['spplrSdcId'] }}</td>
                                            <td>{{ $purchase['spplrMrcNo'] }}</td>
                                            <td>{{ $purchase['rcptTyCd'] }}</td>
                                            <td>{{ $purchase['pmtTyCd'] }}</td>
                                            <td>{{ $purchase['cfmDt'] }}</td>
                                            <td>{{ $purchase['salesDt'] }}</td>
                                            <td>{{ $purchase['stockRlsDt'] }}</td>
                                            <td>{{ $purchase['totItemCnt'] }}</td>
                                            <td>{{ number_format($purchase['taxblAmtA'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxblAmtB'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxblAmtC'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxblAmtD'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxblAmtE'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxRtA'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxRtB'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxRtC'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxRtD'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxRtE'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxAmtA'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxAmtB'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxAmtC'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxAmtD'], 2) }}</td>
                                            <td>{{ number_format($purchase['taxAmtE'], 2) }}</td>
                                            <td>{{ number_format($purchase['totTaxblAmt'], 2) }}</td>
                                            <td>{{ number_format($purchase['totTaxAmt'], 2) }}</td>
                                            <td>{{ number_format($purchase['totAmt'], 2) }}</td>
                                            <td>{{ $purchase['remark']}}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @else
                            <p>Error: Failed to fetch purchases.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection



// public function fetchDataAndStoreForCodeList()
    // {
    //     $client = new Client();
    //     $response = $client->request('GET', 'https://etims.your-apps.biz/api/GetCodeList?date=20220409120000', [
    //         'headers' => [
    //             'accept' => '*/*',
    //             'key' => '123456',
    //         ],
    //     ]);
    //     if ($response->successful()) {
    //         $data = json_decode($response->getBody(), true);

    //         // Log the API response
    //         \Log::info('API Response:', $response->getBody());

    //         if (isset($data['data']) && isset($data['data']['clsList'])) {
    //             $clsList = $data['data']['clsList'];

    //             foreach ($clsList as $item) {
    //                 // Insert the main item from clsList into the CodeList table
    //                 CodeList::create([
    //                     'cdCls' => $item['cdCls'],
    //                     'cdClsNm' => $item['cdClsNm'],
    //                     'cdClsDesc' => $item['cdClsDesc'],
    //                     'useYn' => $item['useYn'],
    //                     'userDfnNm1' => $item['userDfnNm1'],
    //                     'userDfnNm2' => $item['userDfnNm2'],
    //                     'userDfnNm3' => $item['userDfnNm3'],
    //                 ]);

    //                 // Check if dtlList exists and is not empty
    //                 if (isset($item['dtlList']) && is_array($item['dtlList']) && count($item['dtlList']) > 0) {
    //                     $dtlList = $item['dtlList'];

    //                     foreach ($dtlList as $detail) {
    //                         // Insert each detail item from dtlList into the CodeListDetails table
    //                         CodeListDetail::create([
    //                             'cdCls' => $item['cdCls'],
    //                             'cd' => $detail['cd'],
    //                             'cdNm' => $detail['cdNm'],
    //                             'cdDesc' => $detail['cdDesc'],
    //                             'useYn' => $detail['useYn'],
    //                             'srtOrd' => $detail['srtOrd'],
    //                             'userDfnCd1' => $detail['userDfnCd1'],
    //                             'userDfnCd2' => $detail['userDfnCd2'],
    //                             'userDfnCd3' => $detail['userDfnCd3'],
    //                         ]);
    //                     }
    //                 }
    //             }

    //             // Return a success message
    //             return redirect()->back()->with('success', __('Code List Data fetched and stored successfully'));
    //         } else {
    //             // Log error if API request fails
    //             \Log::error('Failed to Insert Data to local server after fetching  Code List data from API. Status code: ' . $response->status());
    //             return redirect()->back()->with('error', __('Failed to Insert Data to local server after fetching  Code List data from API'));
    //         }
    //     } else {
    //         // Log error if API request fails
    //         \Log::error('Failed to fetch Code List data from API. Status code: ' . $response->status());
    //         return redirect()->back()->with('error', __('Failed to fetch Code List data from API'));
    //     }
    // }

    // public function fetchDataAndStoreForCodeList()
    // {
    //     $client = new Client();
    //     try {
    //         $response = $client->request('GET', 'https://etims.your-apps.biz/api/GetCodeList?date=20220409120000', [
    //             'headers' => [
    //                 'accept' => '*/*',
    //                 'key' => '123456',
    //             ],
    //         ]);

    //         if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {

    //             // Successful response
    //             $data = json_decode($response->getBody(), true);
    //             \Log::info('API Response JSON Data:', $data);
                

    //             if (isset($data['data']) && isset($data['data']['clsList'])) {
    //                 $clsList = $data['data']['clsList'];

    //                 // Log the $clsList before the foreach loop
    //                 \Log::info('clsList data:', $data['data']['clsList']);

    //                 foreach ($clsList as $item) {
    //                     // Insert the main item from clsList into the CodeList table
    //                     CodeList::create([
    //                         'cdCls' => $item['cdCls'],
    //                         'cdClsNm' => $item['cdClsNm'],
    //                         'cdClsDesc' => $item['cdClsDesc'],
    //                         'useYn' => $item['useYn'],
    //                         'userDfnNm1' => $item['userDfnNm1'],
    //                         'userDfnNm2' => $item['userDfnNm2'],
    //                         'userDfnNm3' => $item['userDfnNm3'],
    //                     ]);

    //                     // Check if dtlList exists and is not empty
    //                     if (isset($item['dtlList']) && is_array($item['dtlList']) && count($item['dtlList']) > 0) {
    //                         $dtlList = $item['dtlList'];

    //                         foreach ($dtlList as $detail) {
    //                             // Insert each detail item from dtlList into the CodeListDetails table
    //                             CodeListDetail::create([
    //                                 'cd' => $detail['cd'],
    //                                 'cdNm' => $detail['cdNm'],
    //                                 'cdDesc' => $detail['cdDesc'],
    //                                 'useYn' => $detail['useYn'],
    //                                 'srtOrd' => $detail['srtOrd'],
    //                                 'userDfnCd1' => $detail['userDfnCd1'],
    //                                 'userDfnCd2' => $detail['userDfnCd2'],
    //                                 'userDfnCd3' => $detail['userDfnCd3'],
    //                             ]);
    //                         }
    //                     }
    //                 }
    //                 // Return a success message
    //                 return redirect()->back()->with('success', __('Code List Data fetched and stored successfully'));
    //             } else {
    //                 // Log error if API request fails
    //                 \Log::error('Failed to Insert Data to local server after fetching  Code List data from API. Status code: ' . $response->getStatusCode());
    //                 return redirect()->back()->with('error', __('Failed to Insert Data to local server after fetching  Code List data from API'));
    //             }
    //         } else {
    //             // Log error if API request fails
    //             \Log::error('Failed to fetch Code List data from API. Status code: ' . $response->getStatusCode());
    //             return redirect()->back()->with('error', __('Failed to fetch Code List data from API'));
    //         }
    //     } catch (RequestException $e) {
    //         // Log error if Guzzle request fails
    //         \Log::error('Failed to make request to API: ' . $e->getMessage());
    //         return redirect()->back()->with('error', __('Failed to make request to API'));
    //     }
    // }





     public function fetchDataAndStoreForCodeList(Request $request){
    
    $client = new Client();
    try {
        $response = $client->request('GET', 'https://etims.your-apps.biz/api/GetCodeList?date=20220409120000', [
            'headers' => [
                'accept' => '*/*',
                'key' => '123456',
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            $data = json_decode($response->getBody(), true);
            \Log::info('API Response JSON Data:', $data);

            $codeListsData = [];
            $codeListDetailsData = [];
              
            if (isset($data['data'])) {
                $clsList = $data['data']['clsList'] ?? [];
                                 
                // if (isset($data['data'], $data['data']['clsList'])) {
                    
                foreach ($clsList as $clsList) {
                  
                    $codeListsData[] = [
                        'codeClass' => $clsList['cdCls'],
                        'codeClassName' => $clsList['cdClsNm'],
                        'codeClassDescription' => $clsList['cdClsDesc'],
                        'useYearno' => $clsList['useYn'],
                        'userDefineName1' => $clsList['userDfnNm1'],
                        'userDefinneName2' => $clsList['userDfnNm2'],
                        'userDefineName3' => $clsList['userDfnNm3'],
                    ];


                    if (isset($clsList['dtlList'])) {
                        foreach ($clsList['dtlList'] as $detail) {
                            $codeListDetailsData[] = [
                                'code' => $detail['cd'],
                                'codeName' => $detail['cdNm'],
                                'codeDescription' => $detail['cdDesc'],
                                'useYearno' => $detail['useYn'],
                                'srtOrder' => $detail['srtOrd'],
                                'userDefineCode1' => $clsList['userDfnCd1'],
                                'userDefinneCode2' => $clsList['userDfnCd2'],
                                'userDefineCode3' => $clsList['userDfnCd3'],
                            ];
                        }
                    }
                }
               
                $this->insertData($codeListsData, $codeListDetailsData);

                return redirect()->back()->with('success', __('Code List Data fetched and stored successfully'));
            } else {
                \Log::error('Invalid response data structure');
                return redirect()->back()->with('error', __('Failed to fetch Code List data from API'));
            }
        } else {
            \Log::error('Failed to fetch Code List data from API. Status code: ' . $response->getStatusCode());
            return redirect()->back()->with('error', __('Failed to fetch Code List data from API'));
        }
    } catch (RequestException $e) {
        \Log::error('Failed to make request to API: ' . $e->getMessage());
        return redirect()->back()->with('error', __('Failed to make request to API'));
    }
   }

    private function insertData($codeListsData, $codeListDetailsData){
        try {
            CodeList::insert($codeListsData);

            foreach ($codeListDetailsData as $detail) {
                CodeListDetail::create($detail);
            }
        } catch (Exception $e) {
            \Log::error('Failed to insert data: ' . $e->getMessage());
            return redirect()->back()->with('error', __('Failed to insert data'));
        }
    }


public function fetchDataAndStoreForCodeList(Request $request)
{
    // Fetch data from the API
    $dataFromApi = $this->fetchDataFromApi();

    if ($dataFromApi === null) {
        return redirect()->back()->with('error', __('Failed to fetch Code List data from API'));
    }

    // Extract code lists and details from the API data
    $codeListsData = $this->extractCodeListsData($dataFromApi);
    $codeListDetailsData = $this->extractCodeListDetailsData($dataFromApi);

    // Insert data into the local database
    $this->insertData($codeListsData, $codeListDetailsData);

    return redirect()->back()->with('success', __('Code List Data fetched and stored successfully'));
}

private function fetchDataFromApi()
{
    $client = new Client();
    
    try {
        $response = $client->request('GET', 'https://etims.your-apps.biz/api/GetCodeList?date=20220409120000', [
            'headers' => [
                'accept' => '*/*',
                'key' => '123456',
            ],
        ]);

        if ($response->getStatusCode() === 200) {
            return json_decode($response->getBody(), true);
        }

        return null;
    } catch (RequestException $e) {
        \Log::error('Failed to make request to API: ' . $e->getMessage());
        return null;
    }
}

private function extractCodeListsData($dataFromApi)
{
    $codeListsData = [];

    if (isset($dataFromApi['data']) && isset($dataFromApi['data']['clsList'])) {
        foreach ($dataFromApi['data']['clsList'] as $clsList) {
            $codeListsData[] = [
                'codeClass' => $clsList['cdCls'],
                'codeClassName' => $clsList['cdClsNm'],
                'codeClassDescription' => $clsList['cdClsDesc'],
                'useYearno' => $clsList['useYn'],
                'userDefineName1' => $clsList['userDfnNm1'],
                'userDefinneName2' => $clsList['userDfnNm2'],
                'userDefineName3' => $clsList['userDfnNm3'],
            ];
        }
    }

    return $codeListsData;
}

private function extractCodeListDetailsData($dataFromApi)
{
    $codeListDetailsData = [];

    if (isset($dataFromApi['data']) && isset($dataFromApi['data']['clsList'])) {
        foreach ($dataFromApi['data']['clsList'] as $clsList) {
            if (isset($clsList['dtlList'])) {
                foreach ($clsList['dtlList'] as $detail) {
                    $codeListDetailsData[] = [
                        'code' => $detail['cd'],
                        'codeName' => $detail['cdNm'],
                        'codeDescription' => $detail['cdDesc'],
                        'useYearno' => $detail['useYn'],
                        'srtOrder' => $detail['srtOrd'],
                        'userDefineCode1' => $detail['userDfnCd1'],
                        'userDefinneCode2' => $detail['userDfnCd2'],
                        'userDefineCode3' => $detail['userDfnCd3'],
                    ];
                }
            }
        }
    }

    return $codeListDetailsData;
}

private function insertData($codeListsData, $codeListDetailsData)
{
    try {
        CodeList::insert($codeListsData);

        foreach ($codeListDetailsData as $detail) {
            CodeListDetail::create($detail);
        }
    } catch (Exception $e) {
        \Log::error('Failed to insert data: ' . $e->getMessage());
        return redirect()->back()->with('error', __('Failed to insert data'));
    }
}


}


<!-- @if (\Auth::user()->type == 'company')
            <li class="dash-item dash-hasmenu {{ Request::segment(1) == 'notices' ? 'active' : '' }}">
                <a href="{{ route('notices.index') }}" class="dash-link">
                    <span class="dash-micon"><i class="ti ti-notification"></i></span><span
                        class="dash-mtext">{{ __('Notices') }}</span>
                </a>
            </li>
        @endif -->