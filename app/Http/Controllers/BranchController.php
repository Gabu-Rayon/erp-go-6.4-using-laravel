<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use Illuminate\Support\Str;
use App\Models\BranchesList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class BranchController extends Controller
{
    public function index()
    {
        try {
            if (\Auth::user()->type == 'company')
            {
                $branches = BranchesList::all();
                return view('branch.index', compact('branches'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } catch (\Exception $e) {
            \Log::info('Render Branches List Error');
            \Log::info($e);
            return redirect()->back()->with('error', 'An Error Occurred');
        }
    }

    public function create()
    {
        if (\Auth::user()->type == 'company')
        {
            return view('branch.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        try {
            if (\Auth::user()->type == 'company')
            {
                    $data = $request->all();
                    BranchesList::create([
                        'bhfNm' => $data["bhfNm"],
                        'bhfId' => $data["bhfId"],
                        'tin' => $data["tin"],
                        'bhfSttsCd' => $data["bhfSttsCd"],
                        'prvncNm' => $data["prvncNm"],
                        'dstrtNm' => 'dstrtNm',
                        'sctrNm' => $data["sctrNm"],
                        'locDesc' => $data["locDesc"],
                        'mgrNm' => $data["mgrNm"],
                        'mgrTelNo' => $data["mgrTelNo"],
                        'mgrEmail' => $data["mgrEmail"],
                        'hqYn' => $data["hqYn"],
                    ]);
                    \Log::info($data);
                    return redirect()->back()->with('success', 'Branch Created Successfully');
                } 
                else {
                    return redirect()->back()->with('error', __('Permission denied.'));
                }
            } catch (\Exception $e) {
                \Log::info($data);
                return redirect()->back()->with('error', $e->getMessage());
            }
    }

    /**
     * Synchronize Branches from API
     */

    public function sync() {
        try {

            $url = 'https://etims.your-apps.biz/api/GetBranchList';
        } catch (\Exception $e) {
            \Log::info('Sync Branches Error');
            \Log::info($e);
            return redirect()->back()->with('error', 'An Error Occurred');
        }
    }



    public function show(BranchesList $branch)
    {
        return redirect()->route('branch.index');
    }

    public function edit(BranchesList $branch)
    {
        try {
            if (\Auth::user()->type == 'company')
            {
                \Log::info('Render Edit Branch Success');
                \Log::info($branch);
                return view('branch.edit', compact('branch'));
            } else {
                return redirect()->back()->with('error', 'Permission denied.');
            }
        } catch (\Exception $e) {
            \Log::info('Render Edit Branch Error');
            \Log::info($e);
            return redirect()->back()->with('error', 'An Error Occurred');
        }
    }

    public function update(Request $request, BranchesList $branch)
{
    try {
        if (\Auth::user()->type == 'company')
        {
                $validator = \Validator::make($request->all(), [
                    'bhfNm' => 'required',
                    'tin' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->with('error', $validator->errors()->first());
                }

                $branch->update($request->all());

                return redirect()->route('branch.index')->with('success', __('Branch successfully updated.'));
            } 
         else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    } catch (\Exception $e) {
        \Log::error('Update Branch Error: ');
        \Log::info($e);
        return redirect()->back()->with('error', 'An Error Occurred');
    }
}

    public function destroy(BranchesList $branch)
    {
        if (\Auth::user()->type == 'company')
        {
                $branch->delete();

                return redirect()->route('branch.index')->with('success', __('Branch successfully deleted.'));
            }
        else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getdepartment(Request $request)
    {

        if ($request->branch_id == 0) {
            $departments = Department::get()->pluck('name', 'id')->toArray();
        } else {
            $departments = Department::where('branch_id', $request->branch_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($departments);
    }

    public function getemployee(Request $request)
    {
        if (in_array('0', $request->department_id)) {
            $employees = \App\Models\Employee::get()->pluck('name', 'id')->toArray();
        } else {
            $employees = \App\Models\Employee::whereIn('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($employees);
    }
}



/**
 * Using Api Endpoint
 *  
 */

// public function index()
// {
//     if (\Auth::user()->can('manage user') && (\Auth::user()->type == 'super admin')) {
//         $response = Http::withHeaders([
//             'accept' => 'application/json',
//             'Content-Type' => 'application/json',
//             'key' => '123456',
//         ])->get('https://etims.your-apps.biz/api/GetBranchList', [
//                     'date' => date('2024-04-08'),
//                 ]);
//         if ($response->successful()) {
//             $users = $response->json();
//         } else {
//             // Log the error
//             \Log::error('Failed to fetch users from API: ' . $response->status() . ' ' . $response->body());

//             // Handle error response
//             return redirect()->back()->with('error', 'Failed to fetch users from API.');
//         }
//         return view('user.index')->with('users', $users);
//     } else {
//         return redirect()->back();
//     }
// }