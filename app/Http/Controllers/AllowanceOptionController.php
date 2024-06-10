<?php

namespace App\Http\Controllers;

use App\Models\AllowanceOption;
use Illuminate\Http\Request;

class AllowanceOptionController extends Controller
{
    public function index()
    {
        try {
            if(\Auth::user()->type == 'company'){
                $allowanceoptions = AllowanceOption::where('created_by', '=', \Auth::user()->creatorId())->get();

                return view('allowanceoption.index', compact('allowanceoptions'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        } catch (\Exception $e) {
            \Log::info('GET ALLOWANCE OPTION ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        try {
            if(\Auth::user()->type == 'company')
        {
            return view('allowanceoption.create');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        } catch (\Exception $e) {
            \Log::info('CREATE ALLOWANCE OPTION ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            if(\Auth::user()->type == 'company')
            {
    
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
    
                    return redirect()->back()->with('error', $messages->first());
                }
    
                $allowanceoption             = new AllowanceOption();
                $allowanceoption->name       = $request->name;
                $allowanceoption->created_by = \Auth::user()->creatorId();
                $allowanceoption->save();
    
                return redirect()->route('allowanceoption.index')->with('success', __('AllowanceOption  successfully created.'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } catch (\Exception $e) {
            \Log::info('STORE ALLOWANCE OPTION ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(AllowanceOption $allowanceoption)
    {
        try {
            return redirect()->route('allowanceoption.index');
        } catch (\Exception $e) {
            \Log::info('SHOW ALLOWANCE OPTION ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(AllowanceOption $allowanceoption)
    {
        try {
            if(\Auth::user()->type == 'company')
        {
            if($allowanceoption->created_by == \Auth::user()->creatorId())
            {

                return view('allowanceoption.edit', compact('allowanceoption'));
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
        } catch (\Exception $e) {
            \Log::info('EDIT ALLOWANCE OPTION ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, AllowanceOption $allowanceoption)
    {
        try {
            if(\Auth::user()->type == 'company')
        {
            if($allowanceoption->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required|max:20',

                                   ]
                );

                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }
                $allowanceoption->name = $request->name;
                $allowanceoption->save();

                return redirect()->route('allowanceoption.index')->with('success', __('AllowanceOption successfully updated.'));
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
        } catch (\Exception $e) {
            \Log::info('UPDATE ALLOWANCE OPTION ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(AllowanceOption $allowanceoption)
    {
        try {
            if(\Auth::user()->type == 'company')
        {
            if($allowanceoption->created_by == \Auth::user()->creatorId())
            {
                $allowanceoption->delete();

                return redirect()->route('allowanceoption.index')->with('success', __('AllowanceOption successfully deleted.'));
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
        } catch (\Exception $e) {
            \Log::info('DESTROY ALLOWANCE OPTION ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

}
