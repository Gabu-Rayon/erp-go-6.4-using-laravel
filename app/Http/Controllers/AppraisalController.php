<?php

namespace App\Http\Controllers;

use App\Models\Appraisal;
use App\Models\BranchesList;
use App\Models\Competencies;
use App\Models\Employee;
use App\Models\Indicator;
use App\Models\Performance_Type;
use App\Models\PerformanceType;
use Illuminate\Http\Request;

class AppraisalController extends Controller
{

    public function index()
    {
        try {
            if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
        {
            $user = \Auth::user();
            if($user->type == 'Employee')
            {
                $employee   = Employee::where('user_id', $user->id)->first();
                $competencyCount = Competencies::where('created_by', '=', $user->creatorId())->count();
                $appraisals = Appraisal::where('created_by', '=', \Auth::user()->creatorId())->where('branch', $employee->branch_id)->where('employee', $employee->id)->with(['employees','branches'])->get();
            }
            else
            {
                $competencyCount = Competencies::where('created_by', '=', $user->creatorId())->count();

                $appraisals = Appraisal::where('created_by', '=', \Auth::user()->creatorId())->with(['employees','branches'])->get();
            }

            return view('appraisal.index', compact('appraisals','competencyCount'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        } catch (\Exception $e) {
            \Log::info('GET APPRAISAL ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        try {
            if(\Auth::user()->type == 'company')
            {

                $performance = PerformanceType::where('created_by', '=', \Auth::user()->creatorId())->get();
                $brances = BranchesList::all()->pluck('bhfNm', 'bhfId');
                $employees = Employee::all()->pluck('name', 'id');
                return view('appraisal.create', compact( 'brances', 'performance', 'employees'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } catch (\Exception $e) {
            \Log::info('RENDER CREATE APPRAISAL ERROR');
            \Log::info($e);

            redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function store(Request $request)
    {
        try {
            
        if(\Auth::user()->type == 'company')
        {
            $validator = \Validator::make(
                $request->all(), [
                    'branch' => 'required',
                    'employee' => 'required',
                    ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $appraisal                 = new Appraisal();
            $appraisal->branch         = $request->branch;
            $appraisal->employee       = $request->employee;
            $appraisal->appraisal_date = $request->appraisal_date;
            $appraisal->rating         = json_encode($request->rating, true);
            $appraisal->remark         = $request->remark;
            $appraisal->created_by     = \Auth::user()->creatorId();
            $appraisal->save();

            return redirect()->route('appraisal.index')->with('success', __('Appraisal successfully created.'));
        }
        } catch (\Exception $e) {
            \Log::info('STORE APPRAISAL ERROR');
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Appraisal $appraisal)
    {
        try {
            $rating = json_decode($appraisal->rating, true);
        $performance_types     = PerformanceType::where('created_by', '=', \Auth::user()->creatorId())->get();
        $employee = Employee::find($appraisal->employee);

        $indicator = Indicator::where('branch',$employee->branch_id)->where('department',$employee->department_id)->where('designation',$employee->designation_id)->first();
        if ($indicator != null) {
            $ratings = json_decode($indicator->rating, true);
        }else {
            $ratings = null;
        }

        return view('appraisal.show', compact('appraisal', 'performance_types', 'ratings','rating'));
        } catch (\Exception $e) {
            \Log::info('SHOW APPRAISAL ERROR');
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Appraisal $appraisal)
    {
        try {
            try {
                if(\Auth::user()->type == 'company')
                {
    
                    $performance_types     = PerformanceType::where('created_by', '=', \Auth::user()->creatorId())->get();
                    $brances = BranchesList::all()->pluck('bhfNm', 'id');
                    $ratings = json_decode($appraisal->rating,true);
    
    
                    return view('appraisal.edit', compact( 'brances', 'appraisal', 'performance_types','ratings'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Permission denied.'));
                }
            } catch (\Exception $e) {
                \Log::info('RENDER EDIT APPRAISAL ERROR');
                \Log::info($e);
            }
        } catch (\Exception $e) {
            \Log::info('EDIT APPRAISAL ERROR');
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Appraisal $appraisal)
    {
        try {
            if(\Auth::user()->type == 'company')
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'branch' => 'required',
                                       'employee' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();
    
                    return redirect()->back()->with('error', $messages->first());
                }
    
                $appraisal->branch         = $request->branch;
                $appraisal->employee       = $request->employee;
                $appraisal->appraisal_date = $request->appraisal_date;
                $appraisal->rating         = json_encode($request->rating, true);
                $appraisal->remark         = $request->remark;
                $appraisal->save();
    
                return redirect()->route('appraisal.index')->with('success', __('Appraisal successfully updated.'));
            }
        } catch (\Exception $e) {
            \Log::info('UPDATE APPRAISAL ERROR');
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Appraisal $appraisal)
    {
        try {
            if(\Auth::user()->type == 'company')
        {
            if($appraisal->created_by == \Auth::user()->creatorId())
            {
                $appraisal->delete();

                return redirect()->route('appraisal.index')->with('success', __('Appraisal successfully deleted.'));
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
            \Log::info('DESTROY APPRAISAL ERROR');
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function empByStar(Request $request)
    {
        try {
            $employee = Employee::find($request->employee);

        $indicator = Indicator::where('branch',$employee->branch_id)->where('department',$employee->department_id)->where('designation',$employee->designation_id)->first();

        $ratings = !empty($indicator)? json_decode($indicator->rating, true):[];

        $performance_types = PerformanceType::where('created_by', '=', \Auth::user()->creatorId())->get();

        $viewRender = view('appraisal.star', compact('ratings','performance_types'))->render();
        // dd($viewRender);
        return response()->json(array('success' => true, 'html'=>$viewRender));
        } catch (\Exception $e) {
            \Log::info('EMPLOYEE BY STAR ERROR');
            \Log::info($e);
            return response()->json($e->getMessage());
        }
    }

    public function empByStar1(Request $request)
    {
        try {
            $employee = Employee::find($request->employee);

        $appraisal = Appraisal::find($request->appraisal);

        $indicator = Indicator::where('branch',$employee->branch_id)->where('department',$employee->department_id)->where('designation',$employee->designation_id)->first();

        if ($indicator != null) {
            $ratings = json_decode($indicator->rating, true);
        }else {
            $ratings = null;
        }
        $rating = json_decode($appraisal->rating,true);
        $performance_types = PerformanceType::where('created_by', '=', \Auth::user()->creatorId())->get();
        $viewRender = view('appraisal.staredit', compact('ratings','rating','performance_types'))->render();
        // dd($viewRender);
        return response()->json(array('success' => true, 'html'=>$viewRender));
        } catch (\Exception $e) {
            \Log::info('EMPLOYEE BY STAR1 ERROR');
            \Log::info($e);
            return response()->json($e->getMessage());
        }
    }

    public function getemployee(Request $request)
    {
        try {
            $data['employee'] = Employee::where('branch_id',$request->branch_id)->get();
        return response()->json($data);
        } catch (\Exception $e) {
            \Log::info('GET EMPLOYEE ERROR');
            \Log::info($e);
            return response()->json($e->getMessage());
        }
    }
}
