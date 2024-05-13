<?php

namespace App\Http\Controllers;

use App\Models\BranchUser;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;

class BranchUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $branchUsers = BranchUser::all();
            return view('branchuser.index', compact('branchUsers'));
        } catch (\Exception $e) {
            \Log::info('BRANCH USER INDEX ERROR RENDER');
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            return view('branchuser.create');
        } catch (\Exception $e) {
            \Log::info('BRANCH USER CREATE ERROR RENDER');
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $validator = \Validator::make(
                $request->all(),
                [
                    'branchUserName' => 'required|max:120',
                    'address' => 'required',
                    'contactNo' => 'required',
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
                'branchUserName' => $request->branchUserName,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'contactNo' => $request->contactNo,
                'authenticationCode' => $authenticationCode,
                'remark' => $request->remark,
                'isUsed' => true,
            ];

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'accept' => 'application/json',
                'Content-Type' => 'application/json',
                'key' => '123456',
            ])->timeout(600)->post('https://etims.your-apps.biz/api/AddBranchUser', $requestData);

            // Log the API response
            \Log::info('API Request Data: ' . json_encode($requestData));
            \Log::info('API Response: ' . $response->body());
            \Log::info('API Response Status Code: ' . $response->status());

            if ($response['statusCode'] != 200) {
                return redirect()->back()->with('error', __('Failed to create Branch User.'));
            }


            BranchUser::create([
                'branchUserId' => $branchUserId,
                'branchUserName' => $request->branchUserName,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'contactNo' => $request->contactNo,
                'authenticationCode' => $authenticationCode,
                'remark' => $request->remark,
                'isUsed' => true,
                "created_by" => \Auth::user()->creatorId()
            ]);

            // Check if API call was successful
            if ($response->successful()) {
                return redirect()->route('branchuser.index')->with('success', __('Branch User successfully created.'));
            } else {
                // If API call failed, return with error message
                return redirect()->back()->with('error', __('Failed to create Branch User.'));
            }
    }

    /**
     * Display the specified resource.
     */
    public function show(BranchUser $branchUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $branchUser = BranchUser::find($id);
            return view('branchuser.edit', compact('branchUser'));
        } catch (\Exception $e) {
            \Log::info('BRANCH USER EDIT ERROR RENDER');
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BranchUser $branchUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BranchUser $branchUser)
    {
        //
    }
}
