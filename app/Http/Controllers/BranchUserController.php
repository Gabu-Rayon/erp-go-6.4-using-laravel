<?php

namespace App\Http\Controllers;

use App\Models\BranchUser;
use App\Http\Controllers\Controller;
use App\Models\ConfigSettings;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

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
            Log::info('BRANCH USER INDEX ERROR RENDER');
            Log::info($e);
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
        } catch (Exception $e) {
            Log::info('BRANCH USER CREATE ERROR RENDER');
            Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
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

        $config = ConfigSettings::first();

        $url = $config->api_url . 'AddBranchUserV2';

        $response = Http::withOptions([
            'verify' => false
        ])->withHeaders([
            'accept' => 'application/json',
            'Content-Type' => 'application/json',
            'key' => '123456',
        ])->timeout(600)->post($url, $requestData);

        Log::info('BRANCH USER RESPONSE');
        Log::info($response);

        if ($response['status']) {
            BranchUser::create([
                'branchUserId' => $branchUserId,
                'branchUserName' => $request->branchUserName,
                'password' => Hash::make($request->password),
                'address' => $request->address,
                'contactNo' => $request->contactNo,
                'authenticationCode' => $authenticationCode,
                'remark' => $request->remark,
                'isUsed' => true,
                "created_by" => Auth::user()->creatorId(),
                'isKRASync' => $response["responseData"]["isKRASync"],
            ]);
            return redirect()->route('branchuser.index')->with('success', __('Branch User successfully created.'));
        }

        return redirect()->back()->with('error', __('Failed to create Branch User.'));
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
            Log::info('BRANCH USER EDIT ERROR RENDER');
            Log::info($e);
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
