<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class BranchController extends Controller
{
    // public function index()
    // {
    //     if (\Auth::user()->can('manage branch')) {
    //         $branches = Branch::where('created_by', '=', \Auth::user()->creatorId())->get();

    //         return view('branch.index', compact('branches'));
    //     } else {
    //         return redirect()->back()->with('error', __('Permission denied.'));
    //     }
    // }

    public function index()
    {
        if (\Auth::user()->can('manage branch')) {
            try {
                // $response = Http::withHeaders([
                //     'accept' => '/',
                //     'key' => '123456',
                // ])->get('https://etims.your-apps.biz/api/GetBranchList', [
                //         'date' => date('20220409120000'),
                //     ]);

                $response = Http::withHeaders([
                     'accept' => '/',
                    'key' => '123456',
                ])->timeout(300)->get('https://etims.your-apps.biz/api/GetBranchList', [
                            'date' => date('20220409120000'),
                        ]);


                if ($response->successful()) {
                    $branches = $response->json();
                    return view('branch.index', compact('branches'));
                } else {
                    // Log error and handle error response
                    \Log::error('Failed to fetch branches from API: ' . $response->status() . ' ' . $response->body());
                    return redirect()->back()->with('error', 'Failed to fetch branches from API.');
                }
            } catch (\Exception $e) {
                // Log exception and handle exception
                \Log::error('Exception occurred while fetching branches: ' . $e->getMessage());
                return redirect()->back()->with('error', 'Failed to fetch branches from API.');
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create branch')) {
            return view('branch.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }
     /******
      * creating a new Branch for both Local and Api EndPoint 
      */


      
    //   public function store(Request $request)
    // {
    //     if (\Auth::user()->can('create branch')) {

    //         $validator = \Validator::make(
    //             $request->all(),
    //             [
    //                 'name' => 'required',
    //             ]
    //         );
    //         if ($validator->fails()) {
    //             $messages = $validator->getMessageBag();

    //             return redirect()->back()->with('error', $messages->first());
    //         }

    //         $branch = new Branch();
    //         $branch->name = $request->name;
    //         $branch->created_by = \Auth::user()->creatorId();
    //         $branch->save();

    //         return redirect()->route('branch.index')->with('success', __('Branch  successfully created.'));
    //     } else {
    //         return redirect()->back()->with('error', __('Permission denied.'));
    //     }
    // }

    public function store(Request $request)
    {

        if (\Auth::user()->can('create branch')) {

            $validator = \Validator::make(
                $request->all(),
                [
                    'name' => 'required|max:120',
                    // 'email' => 'required|email|unique:users',
                    'address' => 'required',
                    'contact' => 'required',
                    'remark' => 'required',
                    'password' => 'required|min:6',
                ]
            );
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }
            // $uuid = Str::uuid()->toString();
            // $branchUserId = substr($uuid, 0, 20);

            $branchUserId = mt_rand(100000, 999999);
            $authenticationCode = mt_rand(1000, 9999);

            //array containing the data to be sent to the API
            $requestData = [
                'branchUserId' => $branchUserId,
                'branchUserName' => $request->name,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'contactNo' => $request->contact,
                'authenticationCode' => $authenticationCode,
                'remark' => $request->remark,

                //we set is true
                'isUsed' => true,
            ];

            // Make API call
            // $response = Http::withHeaders([
            //     'accept' => 'application/json',
            //     'Content-Type' => 'application/json',
            //     'key' => '123456',
            // ])->post('https://etims.your-apps.biz/api/AddBranchUser', $requestData);

            $response = Http::withHeaders([
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'key' => '123456',
            ])->timeout(600)->post('https://etims.your-apps.biz/api/AddBranchUser', $requestData);

            // Log the API response
            \Log::info('API Request Data: ' . json_encode($requestData));
            \Log::info('API Response: ' . $response->body());
            \Log::info('API Response Status Code: ' . $response->status());


            // Check if API call was successful
            if ($response->successful()) {
                return redirect()->route('branch.index')->with('success', __('Branch User successfully created.'));
            } else {
                // If API call failed, return with error message
                return redirect()->back()->with('error', __('Failed to create Branch User.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function show(Branch $branch)
    {
        return redirect()->route('branch.index');
    }

    public function edit(Branch $branch)
    {
        if (\Auth::user()->can('edit branch')) {
            if ($branch->created_by == \Auth::user()->creatorId()) {

                return view('branch.edit', compact('branch'));
            } else {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Branch $branch)
    {
        if (\Auth::user()->can('edit branch')) {
            if ($branch->created_by == \Auth::user()->creatorId()) {
                $validator = \Validator::make(
                    $request->all(),
                    [
                        'name' => 'required',
                    ]
                );
                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $branch->name = $request->name;
                $branch->save();

                return redirect()->route('branch.index')->with('success', __('Branch successfully updated.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Branch $branch)
    {
        if (\Auth::user()->can('delete branch')) {
            if ($branch->created_by == \Auth::user()->creatorId()) {
                $branch->delete();

                return redirect()->route('branch.index')->with('success', __('Branch successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
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