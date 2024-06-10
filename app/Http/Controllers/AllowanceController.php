<?php

namespace App\Http\Controllers;

use App\Models\Allowance;
use App\Models\AllowanceOption;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AllowanceController extends Controller
{
    
    public function allowanceCreate($id){
        try {
            $allowance_options = AllowanceOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
            $employee          = Employee::find($id);
            $Allowancetypes = Allowance::$Allowancetype;

            return view('allowance.create', compact('employee', 'allowance_options','Allowancetypes'));
        } catch (\Exception $e) {
            Log::info('CREATE ALLOWANCE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request){
        try {
            if(\Auth::user()->type = 'company'){
                $validator = \Validator::make($request->all(), [
                    'employee_id' => 'required',
                    'allowance_option' => 'required',
                    'title' => 'required',
                    'amount' => 'required',
                ]);
                if($validator->fails()){
                    $messages = $validator->getMessageBag();
                    return redirect()->back()->with('error', $messages->first());
                }
                        
                $allowance = new Allowance();
                $allowance->employee_id = $request->employee_id;
                $allowance->allowance_option = $request->allowance_option;
                $allowance->title = $request->title;
                $allowance->type = $request->type;
                $allowance->amount = $request->amount;
                $allowance->created_by = \Auth::user()->creatorId();
                $allowance->save();
                
                return redirect()->back()->with('success', __('Allowance  successfully created.'));
            } else{
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } catch (\Exception $e) {
            Log::info('STORE ALLOWANCE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Allowance $allowance){
        try {
            return redirect()->route('allowance.index');
        } catch (\Exception $e) {
            Log::info('SHOW ALLOWANCE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($allowance){
        try {
            $allowance = Allowance::find($allowance);
            if(\Auth::user()->type == 'company'){
                if($allowance->created_by == \Auth::user()->creatorId()){
                    $allowance_options = AllowanceOption::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                    $Allowancetypes =Allowance::$Allowancetype;
                    return view('allowance.edit', compact('allowance', 'allowance_options','Allowancetypes'));
                } else{
                    return response()->json(['error' => __('Permission denied.')], 401);
                }
            } else{
                return response()->json(['error' => __('Permission denied.')], 401);
            }
        } catch (\Exception $e) {
            Log::info('EDIT ALLOWANCE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Allowance $allowance){
        try {
            if(\Auth::user()->type == 'company'){
                if($allowance->created_by == \Auth::user()->creatorId()){
                    $validator = \Validator::make($request->all(), [
                        'allowance_option' => 'required',
                        'title' => 'required',
                        'amount' => 'required',
                        ]);
                        if($validator->fails()){
                            $messages = $validator->getMessageBag();
                            return redirect()->back()->with('error', $messages->first());
                        }
                        
                        $allowance->allowance_option = $request->allowance_option;
                        $allowance->title = $request->title;
                        $allowance->type = $request->type;
                        $allowance->amount = $request->amount;
                        $allowance->save();
                        
                        return redirect()->back()->with('success', __('Allowance successfully updated.'));
                    } else {
                        return redirect()->back()->with('error', __('Permission denied.'));
                    }
                }
                else{
                    return redirect()->back()->with('error', __('Permission denied.'));
                }
        } catch (\Exception $e) {
            Log::info('UPDATE ALLOWANCE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Allowance $allowance){
        try {
            if(\Auth::user()->type == 'company'){
                if($allowance->created_by == \Auth::user()->creatorId()){
                    $allowance->delete();
                    return redirect()->back()->with('success', __('Allowance successfully deleted.'));
                } else {
                    return redirect()->back()->with('error', __('Permission denied.'));
                }
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } catch (\Exception $e) {
            Log::info('DESTROY ALLOWANCE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
