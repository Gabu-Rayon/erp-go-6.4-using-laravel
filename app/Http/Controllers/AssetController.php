<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\Employee;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    public function index()
    {
        try {
            if(\Auth::user()->type == 'company' || \Auth::user()->type == 'accountant')
        {
            $assets = Asset::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('assets.index', compact('assets'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        } catch (\Exception $e) {
            \Log::error('ASSET INDEX ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function create()
    {
        try {
            if(\Auth::user()->type == 'company' || \Auth::user()->type == 'accountant')
        {
            $employee      = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'user_id');

            return view('assets.create',compact('employee'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        } catch (\Exception $e) {
            \Log::error('ASSET CREATE ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function store(Request $request)
    {
        try {
            if(\Auth::user()->type == 'company' || \Auth::user()->type == 'accountant')
        {
            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                                   'purchase_date' => 'required',
                                   'supported_date' => 'required',
                                   'amount' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $assets                 = new Asset();
            $assets->employee_id         = !empty($request->employee_id) ? implode(',', $request->employee_id) : '';
            $assets->name           = $request->name;
            $assets->purchase_date  = $request->purchase_date;
            $assets->supported_date = $request->supported_date;
            $assets->amount         = $request->amount;
            $assets->description    = $request->description;
            $assets->created_by     = \Auth::user()->creatorId();
            $assets->save();

            return redirect()->route('account-assets.index')->with('success', __('Assets successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        } catch (\Exception $e) {
            \Log::error('ASSET STORE ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            if(\Auth::user()->type == 'company' || \Auth::user()->type == 'accountant')
        {
            $asset = Asset::find($id);
            $employee      = Employee::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $asset->employee_id      = explode(',', $asset->employee_id);



            return view('assets.edit', compact('asset','employee'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        } catch (\Exception $e) {
            \Log::error('ASSET EDIT ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function update(Request $request, $id)
    {
        try {
            if(\Auth::user()->type == 'company' || \Auth::user()->type == 'accountant')
        {
            $asset = Asset::find($id);
            if($asset->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required',
                                       'purchase_date' => 'required',
                                       'supported_date' => 'required',
                                       'amount' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $asset->name           = $request->name;
                $asset->employee_id         = !empty($request->employee_id) ? implode(',', $request->employee_id) : '';

                $asset->purchase_date  = $request->purchase_date;
                $asset->supported_date = $request->supported_date;
                $asset->amount         = $request->amount;
                $asset->description    = $request->description;
                $asset->save();

                return redirect()->route('account-assets.index')->with('success', __('Assets successfully updated.'));
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
            \Log::error('ASSET UPDATE ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            if(\Auth::user()->type == 'company' || \Auth::user()->type == 'accountant')
        {
            $asset = Asset::find($id);
            if($asset->created_by == \Auth::user()->creatorId())
            {
                $asset->delete();

                return redirect()->route('account-assets.index')->with('success', __('Assets successfully deleted.'));
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
            \Log::error('ASSET DESTROY ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
