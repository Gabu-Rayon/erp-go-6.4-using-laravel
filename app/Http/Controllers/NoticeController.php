<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\Notice;

class NoticeController extends Controller
{
    //

    public function getNoticeList()
    {
        $url = 'https://etims.your-apps.biz/api/GetNoticeList?date=20210101120000';

        try {
            $response = Http::withHeaders([
                'key' => '123456'
            ])->get($url);
            $data = $response->json();
            $noticeList = $data['data']['data']['noticeList'];

            if (isset($noticeList)) {
                foreach ($noticeList as $notice) {
                    Notice::create([
                        'noticeNo' => $notice['noticeNo'],
                        'title' => $notice['title'],
                        'cont' => $notice['cont'],
                        'dtlUrl' => $notice['dtlUrl'],
                        'regrNm' => $notice['regrNm'],
                        'regDt' => $notice['regDt']
                    ]);
                }
            }
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error getting notices',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}