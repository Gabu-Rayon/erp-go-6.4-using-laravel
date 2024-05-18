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
     
    public function synchronize () {
        try {

            $url = 'https://etims.your-apps.biz/api/GetNoticeList?date=20210101120000';

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'key' => '123456'
            ])->timeout(60)->get($url);

            $data = $response->json()['data'];

            $remoteNotices = $data['data']['noticeList'];

            \Log::info('REMOTE NOTICES');
            \Log::info($remoteNotices);

            $noticesToSync = [];

            foreach ($remoteNotices as $remoteNotice) {
                $notice = [
                    'noticeNo' => $remoteNotice['noticeNo'],
                    'title' => $remoteNotice['title'],
                    'cont' => $remoteNotice['cont'],
                    'dtlUrl' => $remoteNotice['dtlUrl'],
                    'regrNm' => $remoteNotice['regrNm'],
                    'regDt' => $remoteNotice['regDt'],
                ];
                array_push($noticesToSync, $notice);
            }

            \Log::info('NOTICES TO SYNC');
            \Log::info($noticesToSync);

            $syncedNotices = 0;

            foreach ($noticesToSync as $noticeToSync) {
                $exists = (boolean)Notice::where('noticeNo', $noticeToSync['noticeNo'])->exists();
                if (!$exists) {
                    Notice::create($noticeToSync);
                    $syncedNotices++;
                }
            }
    
            if ($syncedNotices > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedNotices . ' Notices' . 'Successfully'));
            } else {
                return redirect()->back()->with('success', __('Notices Up To Date'));
            }
            
        } catch (\Exception $e) {
            \Log::info('ERROR SYNCING NOTICE LIST');
            \Log::info($e);
            return redirect()->back()->with('error', __('Error Syncing Code List'));
        }
    }
}