<?php

function synchronizeItemClassifications() {

    try {
        // Fetch local item classifications
        $localClassifications = ItemClassification::select(
            'itemClsCd',
            'itemClsNm',
            'itemClsLvl',
            'taxTyCd',
            'mjrTgYn',
            'useYn'
        )->get()->toArray();



        // Fetch remote item classifications
        $url = 'https://etims.your-apps.biz/api/GetItemClassificationList?date=20220409120000';
        $response = Http::withHeaders([
            'key' => '123456'
        ])->get($url);

        $data = $response->json()['data'];
        $remoteClassifications = $data['data']['itemClsList'];

        // Log API request data, response, and status code
        \Log::info('API Request Data: ' . json_encode($data));
        \Log::info('API Response: ' . $response->body());
        \Log::info('API Response Status Code: ' . $response->status());

        // Compare local and remote classifications
        $newClassifications = array_udiff($remoteClassifications, $localClassifications, function ($a, $b) {
            return $a['itemClsCd'] <=> $b['itemClsCd'];
        });

        if (empty($newClassifications)) {
            \Log::info('No new item Classification  to be added from the API Item Classification are up to date');
            return response()->json(['info' => 'No new item Classification  to be added from the API Item Classification are up to date']);
        }

        // Insert new classifications
        foreach ($newClassifications as $classification) {
            if (!is_null($classification)) {
                ItemClassification::create([
                    'itemClsCd' => $classification['itemClsCd'],
                    'itemClsNm' => $classification['itemClsNm'],
                    'itemClsLvl' => $classification['itemClsLvl'],
                    'taxTyCd' => $classification['taxTyCd'],
                    'mjrTgYn' => $classification['mjrTgYn'],
                    'useYn' => $classification['useYn']
                ]);
            }
        }
        \Log::info('Synchronizing Item Classifications from the API successfully');
        return response()->json(['success' => 'Synchronizing Item Classifications from the API successfully']);

    } catch (\Exception $e) {
        \Log::error('Error synchronizing Item Classifications from the API: ' . $e);
        return response()->json(['error' => 'Error synchronizing Item Classifications from the API']);
    }
}