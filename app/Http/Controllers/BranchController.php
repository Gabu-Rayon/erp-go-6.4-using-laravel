<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\BranchesList;
use App\Models\ConfigSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BranchController extends Controller
{
    public function index()
    {
        try {
            if (\Auth::user()->type == 'company') {
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
        if (\Auth::user()->type == 'company') {
            return view('branch.create');
        } else {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        try {
            if (\Auth::user()->type == 'company') {
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
            } else {
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

    public function sync()
    {
        try {

            $config = ConfigSettings::first();

            $url = $config->api_url . 'GetBranchListV2?date=20210101120000';


            $response = Http::withOptions([
                'verify' => false,
            ])->withHeaders([
                'key' => $config->api_key,
            ])->get($url);

            Log::info('BRANCH RESPONSE');
            Log::info($response);

            $branches = $response['responseData']['bhfList'];

            Log::info('BRANCHES');
            Log::info($branches);

            foreach ($branches as $branch) {
                BranchesList::updateOrCreate([
                    'bhfId' => $branch['bhfId'],
                ], [
                    'bhfNm' => $branch['bhfNm'],
                    'tin' => $branch['tin'],
                    'bhfSttsCd' => $branch['bhfSttsCd'],
                    'prvncNm' => $branch['prvncNm'],
                    'dstrtNm' => $branch['dstrtNm'],
                    'sctrNm' => $branch['sctrNm'],
                    'locDesc' => $branch['locDesc'],
                    'mgrNm' => $branch['mgrNm'],
                    'mgrTelNo' => $branch['mgrTelNo'],
                    'mgrEmail' => $branch['mgrEmail'],
                    'hqYn' => $branch['hqYn'],
                    'created_by' => \Auth::user()->creatorId(),
                ]);
            }

            return redirect()->back()->with('success', 'Branches Synced Successfully');
        } catch (\Exception $e) {
            Log::info('Sync Branches Error');
            Log::info($e);
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
            if (\Auth::user()->type == 'company') {
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
            if (\Auth::user()->type == 'company') {
                $validator = \Validator::make($request->all(), [
                    'bhfNm' => 'required',
                    'tin' => 'required',
                ]);

                if ($validator->fails()) {
                    return redirect()->back()->with('error', $validator->errors()->first());
                }

                $branch->update($request->all());

                return redirect()->route('branch.index')->with('success', __('Branch successfully updated.'));
            } else {
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
        if (\Auth::user()->type == 'company') {
            $branch->delete();

            return redirect()->route('branch.index')->with('success', __('Branch successfully deleted.'));
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
