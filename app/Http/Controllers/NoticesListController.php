<?php

namespace App\Http\Controllers;

use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class NoticesListController extends Controller
{

    public function index()
    {


        $notices = Notice::all();

        return view('noticelist.index', compact('notices'));
    }

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

     //to show the  show blade page 


    public function show(){
        
     }
     
    public function synchronize()
    {

        try {
            // Fetch local item classifications
            $localNoticeLists = Notice::select(
                'noticeNo',
                'title',
                'cont',
                'dtlUrl',
                'regrNm',
                'regDt'
            )->get()->toArray();
            // Fetch remote item classifications
            $url = 'https://etims.your-apps.biz/api/GetNoticeList?date=20210101120000';
            $response = Http::withHeaders([
                'key' => '123456'
            ])->get($url);
            
            $data = $response->json()['data'];
            $remoteNoticeLists = $data['data']['noticeList'];
            // Log API request data, response, and status code
            \Log::info('API Request Data: ' . json_encode($data));
            \Log::info('API Response: ' . $response->body());
            \Log::info('API Response Status Code: ' . $response->status());

            // Compare local and remote classifications
            $newNoticeLists = array_udiff($remoteNoticeLists, $localNoticeLists, function ($a, $b) {
                return $a['noticeNo'] <=> $b['noticeNo'];
            });

            if (empty($newNoticeLists)) {
                \Log::info('No new Notice List  to be added from the API Notice Lists are up to date');
                return response()->json(['info' => 'No new Notice List to be added from the API  Notice Lists are up to date']);
            }
            // Insert new noticelIST
            foreach ($newNoticeLists as $notice) {
                if (!is_null($notice)) {
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
            \Log::info('Synchronizing  Notice Lists from the API successfully');
            return response()->json(['success' => 'Synchronizing Notice Lists from the API successfully']);

        } catch (\Exception $e) {
            \Log::error($e);
            return response()->json(['error' => 'Error synchronizing  Notice Lists from the API'], 500);
        }
    }
}