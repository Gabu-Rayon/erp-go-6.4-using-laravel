<?php

namespace App\Http\Controllers;

use App\Models\BranchesList;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {
        if(\Auth::user()->type == 'company')
        {
            $departments = Department::where('created_by', '=', \Auth::user()->creatorId())->get();
            $branches = BranchesList::all();
            \Log::info($departments);
            return view('department.index', compact('departments', 'branches'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function create()
    {
        try {
            if(\Auth::user()->type == 'company')
            {
                $branch = BranchesList::all()->pluck('bhfNm', 'bhfId');

                return view('department.create', compact('branch'));
            }
            else
            {
                return redirect()->back()->with('error', 'Permission Denied');
            }
        } catch (\Exception $e) {
            \Log::info('RENDER CREATE DEPARTMENT ERROR');
            \Log::info($e);
        }
    }

    public function store(Request $request)
    {
        if(\Auth::user()->type == 'company')
        {

            $validator = \Validator::make(
                $request->all(), [
                    'branch_id' => 'required',
                    'name' => 'required|max:20',
                    ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $department             = new Department();
            $department->branch_id  = $request->branch_id;
            $department->name       = $request->name;
            $department->created_by = \Auth::user()->creatorId();
            $department->save();

            return redirect()->route('department.index')->with('success', __('Department  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show(Department $department)
    {
        return redirect()->route('department.index');
    }

    public function edit(Department $department)
    {
        if(\Auth::user()->type == 'company')
        {
            if($department->created_by == \Auth::user()->creatorId())
            {
                $branch = BranchesList::all()->pluck('bhfNm', 'bhfId');

                return view('department.edit', compact('department', 'branch'));
            }
            else
            {
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        }
        else
        {
            return response()->json(['error' => __('Permission denied.')], 401);
        }
    }

    public function update(Request $request, Department $department)
    {
        if(\Auth::user()->type == 'company')
        {
            if($department->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'branch_id' => 'required',
                                       'name' => 'required|max:20',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $department->branch_id = $request->branch_id;
                $department->name      = $request->name;
                $department->save();

                return redirect()->route('department.index')->with('success', __('Department successfully updated.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function destroy(Department $department)
    {
        if(\Auth::user()->type == 'company')
        {
            if($department->created_by == \Auth::user()->creatorId())
            {
                $department->delete();

                return redirect()->route('department.index')->with('success', __('Department successfully deleted.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}
