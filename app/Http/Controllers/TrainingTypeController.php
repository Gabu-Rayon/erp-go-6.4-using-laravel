<?php

namespace App\Http\Controllers;

use App\Models\TrainingType;
use Illuminate\Http\Request;

class TrainingTypeController extends Controller
{

    public function index()
    {
        if(\Auth::user()->type == 'company')
        {
            $trainingtypes = TrainingType::where('created_by', '=', \Auth::user()->creatorId())->get();

            return view('trainingtype.index', compact('trainingtypes'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if(\Auth::user()->type == 'company')
        {
            return view('trainingtype.create');
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function store(Request $request)
    {
        if(\Auth::user()->type == 'company')
        {

            $validator = \Validator::make(
                $request->all(), [
                                   'name' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $trainingtype             = new TrainingType();
            $trainingtype->name       = $request->name;
            $trainingtype->created_by = \Auth::user()->creatorId();
            $trainingtype->save();

            return redirect()->route('trainingtype.index')->with('success', __('TrainingType  successfully created.'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function show(TrainingType $trainingType)
    {
        //
    }


    public function edit($id)
    {

        if(\Auth::user()->type == 'company')
        {
            $trainingType = TrainingType::find($id);
            if($trainingType->created_by == \Auth::user()->creatorId())
            {

                return view('trainingtype.edit', compact('trainingType'));
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


    public function update(Request $request, $id)
    {
        if(\Auth::user()->type == 'company')
        {
            $trainingType = TrainingType::find($id);
            if($trainingType->created_by == \Auth::user()->creatorId())
            {
                $validator = \Validator::make(
                    $request->all(), [
                                       'name' => 'required',

                                   ]
                );

                $trainingType->name = $request->name;
                $trainingType->save();

                return redirect()->route('trainingtype.index')->with('success', __('TrainingType successfully updated.'));
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


    public function destroy($id)
    {
        if(\Auth::user()->type == 'company')
        {

            $trainingType = TrainingType::find($id);
            if($trainingType->created_by == \Auth::user()->creatorId())
            {
                $trainingType->delete();

                return redirect()->route('trainingtype.index')->with('success', __('TrainingType successfully deleted.'));
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
