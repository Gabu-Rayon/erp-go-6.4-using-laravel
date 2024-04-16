<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use App\Models\Customer;
use App\Models\CustomField;
use App\Models\Transaction;
use App\Models\Utility;
use Auth;
use App\Models\User;
use App\Models\Plan;
use File;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;


class GetNoticeListController extends Controller
{
    public function index()
    {

            return view('notices.index');
        
    }
   
    //Get all the Notice Here from the Api 
      
    public function index()
    {
        if (\Auth::user()->can('manage branch')) {
            try {
                // $response = Http::withHeaders([
                //     'accept' => '/',
                //     'key' => '123456',
                // ])->get('https://etims.your-apps.biz/api/GetNoticeList?date=20220409120000', [
                //         'date' => date('20220409120000'),
                //     ]);

                $response = Http::withHeaders([
                    'accept' => '/',
                    'key' => '123456',
                ])->timeout(300)->get('https://etims.your-apps.biz/api/GetNoticeList?date=20220409120000', [
                            'date' => date('20220409120000'),
                        ]);


                if ($response->successful()) {
                    $notices = $response->json();
                    return view('notices.index', compact('notices'));
                } else {
                    // Log error and handle error response
                    \Log::error('Failed to fetch Notices List from API: ' . $response->status() . ' ' . $response->body());
                    return redirect()->back()->with('error', 'Failed to fetch Notices List from API.');
                }
            } catch (\Exception $e) {
                // Log exception and handle exception
                \Log::error('Exception occurred while fetching  Notices List: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to fetch Notices Lists from API.');
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}