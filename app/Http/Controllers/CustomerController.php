<?php

namespace App\Http\Controllers;

use App\Exports\CustomerExport;
use App\Imports\CustomerImport;
use App\Models\Customer;
use App\Models\CustomField;
use App\Models\Transaction;
use Auth;
use File;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{

    public function dashboard()
    {
        $data['invoiceChartData'] = \Auth::user()->invoiceChartData();

        return view('customer.dashboard', $data);
    }

    public function index()
    {
        if(
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ){
            $customers = Customer::where('created_by', \Auth::user()->creatorId())->get();

            return view('customer.index', compact('customers'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    public function create()
    {
        if(
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ) {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'customer')->get();

            return view('customer.create', compact('customFields'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request) {
        try {

            $data = $request->all();

            $validator = \Validator::make($data, [
                'customerNo' => 'required|unique:customers|min:1|max:9',
                'customerTin' => 'required|unique:customers|min:1|max:11',
                'customerName' => 'required|min:1|max:60',
                'address' => 'string|nullable',
                'telNo' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
                'email' => 'nullable|email|unique:customers',
                'faxNo' => 'nullable|regex:/^([0-9\s\-\+\(\)]*)$/',
                'isUsed' => 'boolean|nullable',
                'remark' => 'string|nullable',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with('error', $validator->errors()->first());
            }

            $apiData = [
                "customerNo"=> $data['customerNo'],
                "customerTin"=> $data['customerTin'],
                "customerName"=> $data['customerName'],
                "address"=> $data['address'],
                "telNo"=> $data['telNo'],
                "email"=> $data['email'],
                "faxNo"=> $data['faxNo'],
                "isUsed"=> $data['isUsed'] == '1' ? true : false,
                "remark"=> $data['remark'],
            ];

            \Log::info('API DATA');
            \Log::info($apiData);

            $url = 'https://etims.your-apps.biz/api/AddCustomer';

            $response = Http::withHeaders([
                'key' => '123456',
            ])->withOptions([
                'verify' => false,
            ])->post($url, $apiData);

            if (!$response['statusCode'] || $response['statusCode'] != 200) {
                return redirect()->back()->with('error', 'Error in creating customer');
            }

            \DB::beginTransaction();

            $customer = Customer::create([
                'customerNo' => $data['customerNo'],
                'customerTin' => $data['customerTin'],
                'customerName' => $data['customerName'],
                'address' => $data['address'],
                'telNo' => $data['telNo'],
                'email' => $data['email'],
                'faxNo' => $data['faxNo'],
                'isUsed' => $data['isUsed'] == '1' ? true : false,
                'remark' => $data['remark'],
                'created_by' => \Auth::user()->creatorId(),
                'billing_name' => $data['billing_name'],
                'billing_country' => $data['billing_country'],
                'billing_state' => $data['billing_state'],
                'billing_city' => $data['billing_city'],
                'billing_phone' => $data['billing_phone'],
                'billing_zip' => $data['billing_zip'],
                'billing_address' => $data['billing_address'],
                'shipping_name' => $data['shipping_name'],
                'shipping_country' => $data['shipping_country'],
                'shipping_state' => $data['shipping_state'],
                'shipping_city' => $data['shipping_city'],
                'shipping_phone' => $data['shipping_phone'],
                'shipping_zip' => $data['shipping_zip'],
                'shipping_address' => $data['shipping_address'],
                'lang' => $data['lang'] ?? 'en',
                'balance' => $data['balance'] ?? 0,
            ]);

            CustomField::saveData($customer, $request->customField);

            \DB::commit();

            return redirect()->route('customer.index')->with('success', __('Customer successfully created.'));
        } catch (\Exception $e) {
            \DB::rollBack();
            \Log::error('STORE CUSTOMER ERROR');
            \Log::error($e);

            return redirect()->back()->with('error', $e->getMessage());
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
        if(
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

        if(
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ){

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
        if(
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

        if(\Auth::user()->type == 'customer') {
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
        if(
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

        if(
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
        if(
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
        if(
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
        if(
            \Auth::user()->type == 'accountant'
            || \Auth::user()->type == 'company'
        ){
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


    public function getCustomerByTin(){
        if(
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