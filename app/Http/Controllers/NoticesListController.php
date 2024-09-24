<?php

namespace App\Http\Controllers;

use App\Models\ConfigSettings;
use Carbon\Carbon;
use App\Models\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NoticesListController extends Controller
{

    public function index()
    {
        $notices = Notice::all();
        return view('noticelist.index', compact('notices'));
    }

    public function getNoticeList()
    {
        $config = ConfigSettings::first();



        $url = $config->api_url . 'GetNoticeListV2?date=20210101120000';

        try {
            $response = Http::withHeaders([
                $config->api_key
            ])->get($url);
            $data = $response->json();
            $noticeList = $data['responseData']['noticeList'];

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
    public function show() {}

    public function synchronize()
    {
        try {

            $config = ConfigSettings::first();

            $url = $config->api_url . 'GetNoticeListV2?date=20210101120000';

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'key' => $config->api_key
            ])->timeout(60)->get($url);

            $data = $response->json();

            Log::info('DEYTTA');
            Log::info($data);

            $remoteNotices = $data['responseData']['noticeList'];

            Log::info('REMOTE NOTICES');
            Log::info($remoteNotices);

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

            Log::info('NOTICES RECENT TO SYNC', $noticesToSync);

            $syncedNotices = 0;

            foreach ($noticesToSync as $noticeToSync) {
                $exists = (bool)Notice::where('noticeNo', $noticeToSync['noticeNo'])->exists();
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
            Log::info('ERROR SYNCING NOTICE LIST');
            Log::info($e);
            return redirect()->back()->with('error', __('Error Syncing Code List'));
        }
    }


    public function noticeListSearchByDate(Request $request)
    {
        // Log the request from the form
        Log::info('Synchronization request received From Searching the Notice List Search Form:', $request->all());

        // Get the date passed from the search form
        $date = $request->input('searchByDate');
        if (!$date) {
            return redirect()->back()->with('error', __('Date is required for synchronization Search for Notice List.'));
        }

        // Format the date using Carbon
        $formattedDate = Carbon::createFromFormat('Y-m-d', $date)->format('Ymd') . '000000';

        Log::info('Date Formatted for Synchronization request:', ['formattedDate' => $formattedDate]);

        try {
            $config = ConfigSettings::first();

            $url = $config->api_url . 'GetNoticeListV2?date=' . $formattedDate;

            $response = Http::withOptions(['verify' => false])
                ->withHeaders([$config->api_key])
                ->get($url);

            $data = $response->json();

            Log::error('noticeList  found in response', ['response' => $data]);


            $remoteNoticeListinfo = $data['responseData']['noticeList'];
            Log::info('REMOTE Notice List INFO', ['remoteNoticeListinfo' => $remoteNoticeListinfo]);

            $remoteNoticeListinfoToSync = [];
            foreach ($remoteNoticeListinfo as $remoteNoticeList) {
                $noticeList = [
                    'noticeNo' => $remoteNoticeList['noticeNo'],
                    'title' => $remoteNoticeList['title'],
                    'cont' => $remoteNoticeList['cont'],
                    'dtlUrl' => $remoteNoticeList['dtlUrl'],
                    'regrNm' => $remoteNoticeList['regrNm'],
                    'regDt' => $remoteNoticeList['regDt'],
                ];
                array_push($remoteNoticeListinfoToSync, $noticeList);
            }

            Log::info('REMOTE NOTICE LIST INFO TO SYNC:', ['remoteNoticeListinfoToSync' => $remoteNoticeListinfoToSync]);

            $syncedLocalNoticeListinfo = 0;
            foreach ($remoteNoticeListinfoToSync as $remoteNoticeListInfo) {
                $exists = Notice::where('noticeNo', $remoteNoticeListInfo['noticeNo'])->exists();
                if (!$exists) {
                    Notice::create($remoteNoticeListInfo);
                    $syncedLocalNoticeListinfo++;
                }
            }

            if ($syncedLocalNoticeListinfo > 0) {
                return redirect()->back()->with('success', __('Synced ' . $syncedLocalNoticeListinfo . ' Notice List Successfully'));
            } else {
                return redirect()->back()->with('success', __('Notice List/s Up To Date'));
            }
        } catch (\Exception $e) {
            Log::error('Error syncing Notice List:', ['error' => $e->getMessage()]);
            return redirect()->back()->with('error', __('Error Syncing Notice List'));
        }
    }
}
