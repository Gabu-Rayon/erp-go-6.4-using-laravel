<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use App\Models\AnnouncementEmployee;
use App\Models\BranchesList;
use App\Models\Department;
use App\Models\Employee;
use App\Models\Utility;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function index()
    {
        try {
            if(\Auth::user()->type == 'company' || \Auth::user()->type == 'employee')
        {

            if(Auth::user()->type == 'Employee')
            {
                $current_employee = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $announcements    = Announcement::orderBy('announcements.id', 'desc')->leftjoin('announcement_employees', 'announcements.id', '=', 'announcement_employees.announcement_id')->where('announcement_employees.employee_id', '=', $current_employee->id)->orWhere(
                    function ($q){
                        $q->where('announcements.department_id', '["0"]')->where('announcements.employee_id', '["0"]');
                    }
                )->get();
            }
            else
            {
                $current_employee = Employee::where('user_id', '=', \Auth::user()->id)->first();
                $announcements    = Announcement::where('created_by', '=', \Auth::user()->creatorId())->get();
            }

            return view('announcement.index', compact('announcements', 'current_employee'));
        }
        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        } catch (\Exception $e) {
            \Log::info('GET ANNOUNCEMENT ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        try {
            if(\Auth::user()->type == 'company')
            {
                $employees   = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id');
                $branch      = BranchesList::all()->pluck('bhfNm', 'id');
                $departments = Department::where('created_by', '=', \Auth::user()->creatorId())->get();

                return view('announcement.create', compact('employees', 'branch', 'departments'));
            }
            else
            {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } catch (\Exception $e) {
            \Log::info('CREATE ANNOUNCEMENT RENDER ERROR');
            \Log::info($e);
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
                                   'title' => 'required',
                                   'start_date' => 'required',
                                   'end_date' => 'required',
                                   'branch_id' => 'required',
                                   'department_id' => 'required',
                                   'employee_id' => 'required',
                               ]
            );
            if($validator->fails())
            {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $announcement                = new Announcement();
            $announcement->title         = $request->title;
            $announcement->start_date    = $request->start_date;
            $announcement->end_date      = $request->end_date;
            $announcement->branch_id     = !empty($request)?$request->branch_id:0;
            $announcement->department_id = json_encode($request->department_id);
            $announcement->employee_id   = json_encode($request->employee_id);
            $announcement->description   = $request->description;
            $announcement->created_by    = \Auth::user()->creatorId();

            $announcement->save();

            if(in_array('0', $request->employee_id))
            {
                $departmentEmployee = Employee::whereIn('department_id', $request->department_id)->get()->pluck('id');
                $departmentEmployee = $departmentEmployee;

            }
            else
            {
                $departmentEmployee = $request->employee_id;
            }
            foreach($departmentEmployee as $employee)
            {
                $announcementEmployee                  = new AnnouncementEmployee();
                $announcementEmployee->announcement_id = $announcement->id;
                $announcementEmployee->employee_id     = $employee;
                $announcementEmployee->created_by      = \Auth::user()->creatorId();
                $announcementEmployee->save();
            }

            //For Notification
            $setting  = Utility::settings(\Auth::user()->creatorId());
            if($request->branch_id == 0)
            {
                $branch = BranchesList::get()->pluck('bhfId' , 'id')->toArray();
            }
            else
            {
                $branch = BranchesList::find($request->branch_id);
                $branch = explode(',',$branch->name);
            }

            $announceNotificationArr = [
                'announcement_title' =>  $request->title,
                'branch_name' =>  implode(',',$branch),
                'start_date' =>  $request->start_date,
                'end_date' =>  $request->end_date,
            ];
            //Slack Notification
            if(isset($setting['announcement_notification']) && $setting['announcement_notification'] ==1)
            {
                Utility::send_slack_msg('new_announcement', $announceNotificationArr);
            }
            //Telegram Notification
            if(isset($setting['telegram_announcement_notification']) && $setting['telegram_announcement_notification'] ==1)
            {
                Utility::send_telegram_msg('new_announcement', $announceNotificationArr);
            }

            //webhook
            $module ='New Announcement';
            $webhook=  Utility::webhookSetting($module);
            if($webhook)
            {
                $parameter = json_encode($announcement);
                $status = Utility::WebhookCall($webhook['url'],$parameter,$webhook['method']);
                if($status == true)
                {
                    return redirect()->back()->with('success', __('Announcement successfully created.'));
                }
                else
                {
                    return redirect()->back()->with('error', __('Webhook call failed.'));
                }
            }


            return redirect()->route('announcement.index')->with('success', __('Announcement successfully created.'));
        }

        else
        {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
        } catch (\Exception $e) {
            \Log::info('STORE ANNOUNCEMENT ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show(Announcement $announcement)
    {
        try {
            return redirect()->route('announcement.index');
        } catch (\Exception $e) {
            \Log::info('SHOW ANNOUNCEMENT ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($announcement)
    {
        try {
            if(\Auth::user()->type == 'company')
        {
            $announcement = Announcement::find($announcement);
            if($announcement->created_by == Auth::user()->creatorId())
            {
                $branch      = BranchesList::all()->pluck('bhfNm', 'id');
                $departments = Department::where('created_by', \Auth::user()->creatorId())->get()->pluck('name', 'id');

                return view('announcement.edit', compact('announcement', 'branch', 'departments'));
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
            \Log::info('EDIT ANNOUNCEMENT RENDER ERROR');
            \Log::info($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, Announcement $announcement)
    {
        try {
            if(\Auth::user()->type == 'company' )
        {
            if($announcement->created_by == \Auth::user()->creatorId())
            {

                $validator = \Validator::make(
                    $request->all(), [
                                       'title' => 'required',
                                       'start_date' => 'required',
                                       'end_date' => 'required',
                                       'branch_id' => 'required',
                                       'department_id' => 'required',
                                   ]
                );
                if($validator->fails())
                {
                    $messages = $validator->getMessageBag();

                    return redirect()->back()->with('error', $messages->first());
                }

                $announcement->title         = $request->title;
                $announcement->start_date    = $request->start_date;
                $announcement->end_date      = $request->end_date;
                $announcement->branch_id     = $request->branch_id;
                $announcement->department_id = $request->department_id;
                $announcement->description   = $request->description;
                $announcement->save();

                return redirect()->route('announcement.index')->with('success', __('Announcement successfully updated.'));
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
            \Log::info('UPDATE ANNOUNCEMENT ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function destroy(Announcement $announcement)
    {
        try {
            if(\Auth::user()->type == 'company')
        {
            if($announcement->created_by == \Auth::user()->creatorId())
            {
                $announcement->delete();

                return redirect()->route('announcement.index')->with('success', __('Announcement successfully deleted.'));
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
            \Log::info('DESTROY ANNOUNCEMENT ERROR');
            \Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function getdepartment(Request $request)
    {
        try {
            if($request->branch_id == 0)
        {
            $departments = Department::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id')->toArray();
        }
        else
        {
            $departments = Department::where('created_by', '=', \Auth::user()->creatorId())->where('branch_id', $request->branch_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($departments);
        } catch (\Exception $e) {
            \Log::info('GET DEPARTMENT ERROR');
            \Log::error($e);
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }


    public function getemployee(Request $request)
    {
        try {
            if(!$request->department_id )
        {
            $employees = Employee::where('created_by', '=', \Auth::user()->creatorId())->get()->pluck('name', 'id')->toArray();
        }
        else
        {
            $employees = Employee::where('created_by', '=', \Auth::user()->creatorId())->where('department_id', $request->department_id)->get()->pluck('name', 'id')->toArray();
        }

        return response()->json($employees);
        } catch (\Exception $e) {
            \Log::info('GET EMPLOYEE ERROR');
            \Log::error($e);
            return response()->json(['error' => $e->getMessage()], 401);
        }
    }
}
