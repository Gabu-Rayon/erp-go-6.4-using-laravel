<?php

function synchronize() {
    try {
        // Fetch local items  information
        $localiteminfo = ItemInformation::select(
            'tin',
            'itemCd',
            'itemClsCd',
            'itemTyCd',
            'itemNm',
            'itemStdNm',
            'orgnNatCd',
            'pkgUnitCd',
            'qtyUnitCd',
            'taxTyCd',
            'btchNo',
            'regBhfId',
            'bcd',
            'dftPrc',
            'grpPrcL1',
            'grpPrcL1',
            'grpPrcL2',
            'grpPrcL3',
            'grpPrcL4',
            'grpPrcL5',
            'addInfo',
            'sftyQty',
            'isrcAplcbYn',
            'useYn'
        )->get()->toArray();
        $url = 'https://etims.your-apps.biz/api/GetItemInformation?date=20220409120000';

        $response = Http::withHeaders([
            'key' => '123456'
        ])->get($url);

        $data = $response->json()['data'];
        $remoteiteminfo = $data['data']['itemList'];

        \Log::info('API Request Data: ' . json_encode($data));
        \Log::info('API Request Data: ' . json_encode($remoteiteminfo));
        \Log::info('API Response: ' . $response->body());
        \Log::info('API Response Status Code: ' . $response->status());

        // Compare local and remote classifications
        $newItemsInfo = array_udiff($remoteiteminfo, $localiteminfo, function ($a, $b) {
            return $a['itemCd'] <=> $b['itemCd'];
        });

        if (empty($newItemsInfo)) {
            \Log::info('No new items Information to be added from the API Items are up to date');
            return response()->json(['info' => 'No new items Information to be added from the API Items are up to date']);
        }

        foreach ($newItemsInfo as $item) {
            ItemInformation::create([
                'tin' => $item['tin'],
                'itemCd' => $item['itemCd'],
                'itemClsCd' => $item['itemClsCd'],
                'itemTyCd' => $item['itemTyCd'],
                'itemNm' => $item['itemNm'],
                'itemStdNm' => $item['itemStdNm'],
                'orgnNatCd' => $item['orgnNatCd'],
                'pkgUnitCd' => $item['pkgUnitCd'],
                'qtyUnitCd' => $item['qtyUnitCd'],
                'taxTyCd' => $item['taxTyCd'],
                'btchNo' => $item['btchNo'],
                'regBhfId' => $item['regBhfId'],
                'bcd' => $item['bcd'],
                'dftPrc' => $item['dftPrc'],
                'grpPrcL1' => $item['grpPrcL1'],
                'grpPrcL2' => $item['grpPrcL2'],
                'grpPrcL3' => $item['grpPrcL3'],
                'grpPrcL4' => $item['grpPrcL4'],
                'grpPrcL5' => $item['grpPrcL5'],
                'addInfo' => $item['addInfo'],
                'sftyQty' => $item['sftyQty'],
                'isrcAplcbYn' => $item['isrcAplcbYn'],
                'rraModYn' => $item['rraModYn'],
                'useYn' => $item['useYn']
            ]);
        }
        \Log::info('Synchronizing Item Informations from the API successfully successfully');
        return response()->json(['success' => 'Synchronizing Item Informations from the API successfully successfully']);
    } catch (\Exception $e) {
        \Log::error('Error Synchronizing Item Informations from the API: ' . $e->getMessage());
        return response()->json(['error' => 'Error Synchronizing Item Informations from the API']);
    }
}