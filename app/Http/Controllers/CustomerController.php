<?php

namespace App\Http\Controllers;

use Auth;
use File;
use App\Models\Plan;
use App\Models\User;
use App\Models\Utility;
use App\Models\Customer;
use App\Models\CustomField;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ConfigSettings;
use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;

class CustomerController extends Controller
{

    public function dashboard()
    {
        $data['invoiceChartData'] = \Auth::user()->invoiceChartData();

        return view('customer.dashboard', $data);
    }

    public function index()
    {
        if (
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ) {
            $customers = Customer::where('created_by', \Auth::user()->creatorId())->get();

            return view('customer.index', compact('customers'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function create()
    {
        if (
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ) {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'customer')->get();

            return view('customer.create', compact('customFields'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /***
        public function store(Request $request)
        {
            if (\Auth::user()->can('create customer')) {

                $rules = [
                    'customertin' => 'required',
                    'name' => 'required',
                    'address' => 'required',
                    'telno' => 'required',
                    'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                    'email' => [
                        'required',
                        Rule::unique('customers')->where(function ($query) {
                            return $query->where('created_by', \Auth::user()->id);
                        }),
                        'faxno' => 'required',
                        'remark' => 'required',
                    ],
                ];


                $validator = \Validator::make($request->all(), $rules);

                if ($validator->fails()) {
                    $messages = $validator->getMessageBag();
                    return redirect()->route('customer.index')->with('error', $messages->first());
                }

                $objCustomer = \Auth::user();
                $creator = User::find($objCustomer->creatorId());
                $total_customer = $objCustomer->countCustomers();
                $plan = Plan::find($creator->plan);

                $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->first();
                if ($total_customer < $plan->max_customers || $plan->max_customers == -1) {
                    $customer = new Customer();
                    $customer->customer_id = $this->customerNumber();
                    $customer->customertin = $request->customertin;
                    $customer->name = $request->name;
                    $customer->address = $request->address;
                    $customer->telno = $request->telno;
                    $customer->email = $request->email;
                    $customer->faxno = $request->faxno;
                    $customer->remark = $request->remark;
                    $customer->tax_number = $request->tax_number;
                    $customer->contact = $request->contact;
                    $customer->created_by = \Auth::user()->creatorId();
                    $customer->billing_name = $request->billing_name;
                    $customer->billing_country = $request->billing_country;
                    $customer->billing_state = $request->billing_state;
                    $customer->billing_city = $request->billing_city;
                    $customer->billing_phone = $request->billing_phone;
                    $customer->billing_zip = $request->billing_zip;
                    $customer->billing_address = $request->billing_address;

                    $customer->shipping_name = $request->shipping_name;
                    $customer->shipping_country = $request->shipping_country;
                    $customer->shipping_state = $request->shipping_state;
                    $customer->shipping_city = $request->shipping_city;
                    $customer->shipping_phone = $request->shipping_phone;
                    $customer->shipping_zip = $request->shipping_zip;
                    $customer->shipping_address = $request->shipping_address;

                    $customer->lang = !empty($default_language) ? $default_language->value : '';

                    $customer->save();
                    CustomField::saveData($customer, $request->customField);
                } else {
                    return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
                }

                //For Notification
                $setting = Utility::settings(\Auth::user()->creatorId());
                $customerNotificationArr = [
                    'user_name' => \Auth::user()->name,
                    'customer_name' => $customer->name,
                    'customer_email' => $customer->email,
                ];

                //Twilio Notification
                if (isset($setting['twilio_customer_notification']) && $setting['twilio_customer_notification'] == 1) {
                    Utility::send_twilio_msg($request->contact, 'new_customer', $customerNotificationArr);
                }


                return redirect()->route('customer.index')->with('success', __('Customer successfully created.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        }
    
    public function store(Request $request)
    {


        //retrievie the Api endpoint config from the database that is api_url and api_key  
        $config = ConfigSettings::first();
        \Log::info('Api Endpoint Config data from my local Database :');
        \Log::info($config);        

        \Log::info('creacting customer Request : ');
        \Log::info($request);
        if(
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ){

            $rules = [
                'customerTin' => 'required|between:9,15',
                'customerName' => 'required',
                'address' => 'required',
                'telNo' => 'required',
                'email' => [
                    'required',
                    Rule::unique('customers')->where(function ($query) {
                        return $query->where('created_by', \Auth::user()->id);
                    }),
                    'faxNo' => 'required',
                    'remark' => 'required',
                ],
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route('customer.index')->with('error', $messages->first());
            }


            // Create a new customer instance
            $customer = new Customer();
            $customer->customer_id = $this->customerNumber();
            $customer->customerNo = $request->customerNo;
            $customer->customerTin = $request->customerTin;
            $customer->customerName = $request->customerName;
            $customer->email = $request->email;
            $customer->address = $request->address;
            $customer->telNo = $request->telNo;
            $customer->faxNo = $request->faxNo;
            $customer->isUsed = $request->isUsed;
            $customer->remark = $request->remark;
            $customer->created_by = \Auth::user()->creatorId();
            $customer->billing_name = $request->billing_name;
            $customer->billing_country = $request->billing_country;
            $customer->billing_state = $request->billing_state;
            $customer->billing_city = $request->billing_city;
            $customer->billing_phone = $request->billing_phone;
            $customer->billing_zip = $request->billing_zip;
            $customer->billing_address = $request->billing_address;

            $customer->shipping_name = $request->shipping_name;
            $customer->shipping_country = $request->shipping_country;
            $customer->shipping_state = $request->shipping_state;
            $customer->shipping_city = $request->shipping_city;
            $customer->shipping_phone = $request->shipping_phone;
            $customer->shipping_zip = $request->shipping_zip;
            $customer->shipping_address = $request->shipping_address;

            $customer->lang = !empty($default_language) ? $default_language->value : '';
            // Save customer to local database
            $customer->save();
            CustomField::saveData($customer, $request->customField);

            //array containing the data to be sent to the API
            $requestData = [
                'customerNo' => $request->customerNo,
                'customerTin' => $request->customerTin,
                'customerName' => $request->customerName,
                'address' => $request->address,
                'telNo' => $request->telNo,
                'email' => $request->email,
                'faxNo' => $request->faxNo,
                'isUsed' => true,
                'remark' => $request->remark,
            ];
            try {
                $response = Http::withOptions(['verify' => false])
                    ->withHeaders([
                        'accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'key' => $config->api_key,
                    ])
                    ->post($config->api_url . 'AddCustomer', $requestData);

                \Log::info('API Request Data: ' . json_encode($requestData));
                \Log::info('API Response: ' . $response->body());

                // Check if API call was successful
                if ($response->successful()) {
                    return redirect()->route('customer.index')->with('success', __('Customer successfully created.'));
                } else {
                    return redirect()->back()->with('error', __('Failed to create customer. Error: ') . $response->body());
                }
            } catch (\Exception $e) {
                \Log::error('API Request Exception: ' . $e->getMessage());
                return redirect()->back()->with('error', __('Failed to create customer due to an error.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
****/


    public function store(Request $request)
    {
        $config = ConfigSettings::first();

        if (\Auth::user()->type === 'accountant' || \Auth::user()->type === 'company') {
            $rules = [
                'customerTin' => 'required|between:9,15',
                'customerName' => 'required',
                'address' => 'required',
                'telNo' => 'required',
                'email' => [
                    'required',
                    Rule::unique('customers')->where(function ($query) {
                        return $query->where('created_by', \Auth::user()->id);
                    }),
                ],
                'faxNo' => 'required',
                'remark' => 'required',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->route('customer.index')->with('error', $validator->errors()->first());
            }

            $requestData = [
                'customerNo' => $request->customerNo,
                'customerTin' => $request->customerTin,
                'customerName' => $request->customerName,
                'address' => $request->address,
                'telNo' => $request->telNo,
                'email' => $request->email,
                'faxNo' => $request->faxNo,
                'isUsed' => true,
                'remark' => $request->remark,
            ];

            try {
                $response = Http::withOptions(['verify' => false])
                    ->withHeaders([
                        'accept' => 'application/json',
                        'Content-Type' => 'application/json',
                        'key' => $config->api_key,
                    ])
                    ->post($config->api_url . 'AddCustomer', $requestData);

                \Log::info('API Request Data: ' . json_encode($requestData));
                \Log::info('API Response: ' . $response->body());

                if ($response->successful()) {
                    // Save customer to local database
                    $customer = new Customer();
                    $customer->customer_id = $this->customerNumber();
                    $customer->fill($request->all());
                    $customer->created_by = \Auth::user()->creatorId();
                    $customer->lang = config('app.locale', 'en');
                    $customer->save();

                    CustomField::saveData($customer, $request->customField);

                    return redirect()->route('customer.index')->with('success', __('Customer successfully created.'));
                } else {

                    return redirect()->route('customer.index')->with('error', __('Error occured when Creating Customer Check your  Input Data'));
                    
                }
            } catch (\Exception $e) {
                \Log::error('API Request Exception: ' . $e->getMessage());
                return redirect()->back()->with('error', __('Failed to create customer due to an error.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function show($ids)
    {
        try {
            $id = Crypt::decrypt($ids);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Customer Not Found.'));
        }
        $id = \Crypt::decrypt($ids);
        $customer = Customer::find($id);

        return view('customer.show', compact('customer'));
    }


    public function edit($id)
    {
        if (
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ) {
            $customer = Customer::find($id);
            $customer->customField = CustomField::getData($customer, 'customer');

            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'customer')->get();

            return view('customer.edit', compact('customer', 'customFields'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, Customer $customer)
    {

        if (
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ) {

            $rules = [
                'name' => 'required',
                'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            ];


            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('customer.index')->with('error', $messages->first());
            }

            $customer->name = $request->name;
            $customer->contact = $request->contact;
            $customer->email = $request->email;
            $customer->tax_number = $request->tax_number;
            $customer->created_by = \Auth::user()->creatorId();
            $customer->billing_name = $request->billing_name;
            $customer->billing_country = $request->billing_country;
            $customer->billing_state = $request->billing_state;
            $customer->billing_city = $request->billing_city;
            $customer->billing_phone = $request->billing_phone;
            $customer->billing_zip = $request->billing_zip;
            $customer->billing_address = $request->billing_address;
            $customer->shipping_name = $request->shipping_name;
            $customer->shipping_country = $request->shipping_country;
            $customer->shipping_state = $request->shipping_state;
            $customer->shipping_city = $request->shipping_city;
            $customer->shipping_phone = $request->shipping_phone;
            $customer->shipping_zip = $request->shipping_zip;
            $customer->shipping_address = $request->shipping_address;
            $customer->save();

            CustomField::saveData($customer, $request->customField);

            return redirect()->route('customer.index')->with('success', __('Customer successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(Customer $customer)
    {
        if (
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ) {
            if ($customer->created_by == \Auth::user()->creatorId()) {
                $customer->delete();

                return redirect()->route('customer.index')->with('success', __('Customer successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    function customerNumber()
    {
        $latest = Customer::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->customer_id + 1;
    }

    public function customerLogout(Request $request)
    {
        \Auth::guard('customer')->logout();

        $request->session()->invalidate();

        return redirect()->route('customer.login');
    }

    public function payment(Request $request)
    {

        if (\Auth::user()->type == 'customer') {
            $category = [
                'Invoice' => 'Invoice',
                'Deposit' => 'Deposit',
                'Sales' => 'Sales',
            ];

            $query = Transaction::where('user_id', \Auth::user()->id)->where('user_type', 'Customer')->where('type', 'Payment');
            if (!empty($request->date)) {
                $date_range = explode(' - ', $request->date);
                $query->whereBetween('date', $date_range);
            }

            if (!empty($request->category)) {
                $query->where('category', '=', $request->category);
            }
            $payments = $query->get();

            return view('customer.payment', compact('payments', 'category'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function transaction(Request $request)
    {
        if (
            \Auth::user()->type == 'customer'
        ) {
            $category = [
                'Invoice' => 'Invoice',
                'Deposit' => 'Deposit',
                'Sales' => 'Sales',
            ];

            $query = Transaction::where('user_id', \Auth::user()->id)->where('user_type', 'Customer');

            if (!empty($request->date)) {
                $date_range = explode(' - ', $request->date);
                $query->whereBetween('date', $date_range);
            }

            if (!empty($request->category)) {
                $query->where('category', '=', $request->category);
            }
            $transactions = $query->get();

            return view('customer.transaction', compact('transactions', 'category'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function profile()
    {
        $userDetail = \Auth::user();
        $userDetail->customField = CustomField::getData($userDetail, 'customer');
        $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'customer')->get();

        return view('customer.profile', compact('userDetail', 'customFields'));
    }

    public function editprofile(Request $request)
    {
        $userDetail = \Auth::user();
        $user = Customer::findOrFail($userDetail['id']);

        $this->validate(
            $request,
            [
                'name' => 'required|max:120',
                'contact' => 'required',
                'email' => 'required|email|unique:users,email,' . $userDetail['id'],
            ]
        );

        if ($request->hasFile('profile')) {
            $filenameWithExt = $request->file('profile')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('profile')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $dir = storage_path('uploads/avatar/');
            $image_path = $dir . $userDetail['avatar'];

            if (File::exists($image_path)) {
                File::delete($image_path);
            }

            if (!file_exists($dir)) {
                mkdir($dir, 0777, true);
            }

            $path = $request->file('profile')->storeAs('uploads/avatar/', $fileNameToStore);

        }

        if (!empty($request->profile)) {
            $user['avatar'] = $fileNameToStore;
        }
        $user['name'] = $request['name'];
        $user['email'] = $request['email'];
        $user['contact'] = $request['contact'];
        $user->save();
        CustomField::saveData($user, $request->customField);

        return redirect()->back()->with(
            'success',
            'Profile successfully updated.'
        );
    }

    public function editBilling(Request $request)
    {
        $userDetail = \Auth::user();
        $user = Customer::findOrFail($userDetail['id']);
        $this->validate(
            $request,
            [
                'billing_name' => 'required',
                'billing_country' => 'required',
                'billing_state' => 'required',
                'billing_city' => 'required',
                'billing_phone' => 'required',
                'billing_zip' => 'required',
                'billing_address' => 'required',
            ]
        );
        $input = $request->all();
        $user->fill($input)->save();

        return redirect()->back()->with(
            'success',
            'Profile successfully updated.'
        );
    }

    public function editShipping(Request $request)
    {
        $userDetail = \Auth::user();
        $user = Customer::findOrFail($userDetail['id']);
        $this->validate(
            $request,
            [
                'shipping_name' => 'required',
                'shipping_country' => 'required',
                'shipping_state' => 'required',
                'shipping_city' => 'required',
                'shipping_phone' => 'required',
                'shipping_zip' => 'required',
                'shipping_address' => 'required',
            ]
        );
        $input = $request->all();
        $user->fill($input)->save();

        return redirect()->back()->with(
            'success',
            'Profile successfully updated.'
        );
    }
    public function changeLanquage($lang)
    {

        $user = Auth::user();
        $user->lang = $lang;
        $user->save();

        return redirect()->back()->with('success', __('Language Change Successfully!'));

    }


    public function export()
    {
        $name = 'customer_' . date('Y-m-d i:h:s');
        $data = Excel::download(new CustomerExport(), $name . '.xlsx');
        ob_end_clean();

        return $data;
    }

    public function importFile()
    {
        return view('customer.import');
    }

    public function import(Request $request)
    {

        if (
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ) {

            $rules = [
                'file' => 'required|mimes:csv,txt',
            ];

            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->back()->with('error', $messages->first());
            }

            $customers = (new CustomerImport())->toArray(request()->file('file'))[0];

            $totalCustomer = count($customers) - 1;
            $errorArray = [];
            for ($i = 1; $i <= count($customers) - 1; $i++) {
                $customer = $customers[$i];

                $customerByEmail = Customer::where('email', $customer[2])->first();
                if (!empty($customerByEmail)) {
                    $customerData = $customerByEmail;
                } else {
                    $customerData = new Customer();
                    $customerData->customer_id = $this->customerNumber();
                }

                $customerData->customer_id = $customer[0];
                $customerData->customerNo = $customer[2];
                $customerData->customertin = $customer[3];
                $customerData->name = $customer[4];
                $customerData->email = $customer[5];
                $customerData->address = $customer[6];
                $customerData->tax_number = $customer[7];
                $customerData->contact = $customer[8];
                $customerData->faxno = $customer[9];
                $customerData->isUsed = $customer[10];
                $customerData->remark = $customer[11];
                $customerData->avatar = $customer[12];
                $customerData->created_by = \Auth::user()->creatorId();
                $customerData->is_active = $customer[13];
                $customerData->billing_name = $customer[14];
                $customerData->billing_country = $customer[15];
                $customerData->billing_state = $customer[16];
                $customerData->billing_city = $customer[17];
                $customerData->billing_phone = $customer[18];
                $customerData->billing_zip = $customer[19];
                $customerData->billing_address = $customer[20];

                $customerData->shipping_name = $customer[21];
                $customerData->shipping_country = $customer[22];
                $customerData->shipping_state = $customer[23];
                $customerData->shipping_city = $customer[24];
                $customerData->shipping_phone = $customer[25];
                $customerData->shipping_zip = $customer[26];
                $customerData->shipping_address = $customer[27];
                $customerData->lang = $customer[28];
                $customerData->balance = [29];

                if (empty($customerData)) {
                    $errorArray[] = $customerData;
                } else {
                    $customerData->save();
                }
            }

            $errorRecord = [];
            if (empty($errorArray)) {
                $data['status'] = 'success';
                $data['msg'] = __('Record successfully imported');
            } else {
                $data['status'] = 'error';
                $data['msg'] = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalCustomer . ' ' . 'record');


                foreach ($errorArray as $errorData) {

                    $errorRecord[] = implode(',', $errorData);

                }

                \Session::put('errorArray', $errorRecord);
            }

            return redirect()->back()->with($data['status'], $data['msg']);

            // return $customers;
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function searchCustomers(Request $request)
    {
        if (
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ) {
            $customers = [];
            $search = $request->search;
            if ($request->ajax() && isset($search) && !empty($search)) {
                $customers = Customer::select('id as value', 'name as label', 'email')->where('is_active', '=', 1)->where('created_by', '=', Auth::user()->getCreatedBy())->Where('name', 'LIKE', '%' . $search . '%')->orWhere('email', 'LIKE', '%' . $search . '%')->get();

                return json_encode($customers);
            }

            return $customers;
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getCustomer($id)
    {
        if (
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ) {
            try {
                $customerInfo = Customer::where('customer_id', $id)->first();
                \Log::info('CUSTOMER');
                \Log::info($customerInfo);
                return response()->json([
                    'message' => 'success',
                    'data' => $customerInfo
                ]);
            } catch (\Exception $e) {
                \Log::info('Get Item Error');
                \Log::info($e);
                return response()->json([
                    'message' => 'error',
                    'error' => $e->getMessage()
                ]);
            }

        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function getCustomerByName($name)
    {
        if (
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ) {
            try {
                $customerInfo = Customer::where('name', $name)->first();
                \Log::info('CUSTOMER');
                \Log::info($customerInfo);
                return response()->json([
                    'message' => 'success',
                    'data' => $customerInfo
                ]);
            } catch (\Exception $e) {
                \Log::info('Get Item Error');
                \Log::info($e);
                return response()->json([
                    'message' => 'error',
                    'error' => $e->getMessage()
                ]);
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function getCustomerByTin()
    {
        if (
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ) {
            $customers = Customer::where('created_by', \Auth::user()->creatorId())->get();

            return view('customer.customerbypin', compact('customers'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
}