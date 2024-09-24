<?php

namespace App\Http\Controllers;

use File;
use Illuminate\Support\Facades\DB;
use App\Models\Vender;
use App\Models\User;
use App\Models\Plan;
use Spatie\Permission\Models\Role;
use App\Models\CustomField;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Exports\VenderExport;
use App\Imports\VenderImport;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\BranchesList;
use App\Models\ConfigSettings;

class VenderController extends Controller
{

    public function dashboard()
    {
        try {
            $data['billChartData'] = Auth::user()->billChartData();

            return view('vender.dashboard', $data);
        } catch (\Exception $e) {
            Log::error('VENDER DASHBOARD ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function index()
    {
        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            $venders = Vender::where('created_by', \Auth::user()->creatorId())->get();
            Log::info('VENDERS');
            Log::info($venders);
            return view('vender.index', compact('venders'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function create()
    {
        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'vendor')->get();
            $branches = BranchesList::all()->pluck('bhfNm', 'bhfId');

            return view('vender.create', compact('customFields', 'branches'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
            $rules = [
                'spplrNm' => 'required',
                'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
                'email' => [
                    'required',
                    Rule::unique('venders')->where(function ($query) {
                        return $query->where('created_by', Auth::user()->id);
                    })
                ],
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->route('vender.index')->with('error', $messages->first());
            }

            $data = $request->all();

            DB::beginTransaction();

            $objVendor = Auth::user();
            $creator = User::find($objVendor->creatorId());
            $total_vendor = $objVendor->countVenders();
            $plan = Plan::find($creator->plan);
            $default_language = DB::table('settings')->select('value')->where('name', 'default_language')->first();
            if ($total_vendor < $plan->max_venders || $plan->max_venders == -1) {
                // store the vender image
                $filename = null;
                if ($request->hasFile('avatar')) {
                    $avatar = $request->file('avatar');
                    $filename = time() . '.' . $avatar->getClientOriginalExtension();
                    $avatar->move(public_path('uploads/vendor_avatar/'), $filename);
                }

                $vender = Vender::create([
                    'spplrNm' => $data['spplrNm'],
                    'spplrTin' => $data['spplrTin'],
                    'spplrBhfId' => $data['spplrBhfId'],
                    'spplrSdcId' => $data['spplrSdcId'],
                    'spplrMrcNo' => $data['spplrMrcNo'],
                    'email' => $data['email'],
                    'contact' => $data['contact'],
                    'avatar' => $filename ?? null,
                    'is_active' => true,
                    'created_by' => Auth::user()->creatorId(),
                    'billing_name' => $data['billing_name'] ?? null,
                    'billing_country' => $data['billing_country'] ?? null,
                    'billing_state' => $data['billing_state'] ?? null,
                    'billing_city' => $data['billing_city'] ?? null,
                    'billing_phone' => $data['billing_phone'] ?? null,
                    'billing_zip' => $data['billing_zip'] ?? null,
                    'billing_address' => $data['billing_address'] ?? null,
                    'shipping_name' => $data['shipping_name'] ?? null,
                    'shipping_country' => $data['shipping_country'] ?? null,
                    'shipping_state' => $data['shipping_state'] ?? null,
                    'shipping_city' => $data['shipping_city'] ?? null,
                    'shipping_phone' => $data['shipping_phone'] ?? null,
                    'shipping_zip' => $data['shipping_zip'] ?? null,
                    'shipping_address' => $data['shipping_address'] ?? null,
                ]);
            } else {
                return redirect()->back()->with('error', __('Your user limit is over, Please upgrade plan.'));
            }

            CustomField::saveData($vender, $request->customField);

            $role_r = Role::where('name', '=', 'vender')->firstOrFail();
            $vender->assignRole($role_r);

            $vender->type = 'Vender';

            DB::commit();

            return redirect()->route('vender.index')->with('success', __('Vendor successfully created.'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('VENDER STORE ERROR');
            Log::error($e);
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function show($ids)
    {
        try {
            $id       = Crypt::decrypt($ids);
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', __('Vendor Not Found.'));
        }

        $id     = \Crypt::decrypt($ids);
        $vendor = Vender::find($id);

        return view('vender.show', compact('vendor'));
    }


    public function edit($id)
    {
        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            $vender              = Vender::find($id);
            $vender->customField = CustomField::getData($vender, 'vendor');
            $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'vendor')->get();

            return view('vender.edit', compact('vender', 'customFields'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function update(Request $request, Vender $vender)
    {
        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {

            $rules = [
                'name' => 'required',
                'contact' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/',
            ];


            $validator = \Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();

                return redirect()->route('vender.index')->with('error', $messages->first());
            }

            $vender->name             = $request->name;
            $vender->contact          = $request->contact;
            $vender->tax_number      = $request->tax_number;
            $vender->created_by       = \Auth::user()->creatorId();
            $vender->billing_name     = $request->billing_name;
            $vender->billing_country  = $request->billing_country;
            $vender->billing_state    = $request->billing_state;
            $vender->billing_city     = $request->billing_city;
            $vender->billing_phone    = $request->billing_phone;
            $vender->billing_zip      = $request->billing_zip;
            $vender->billing_address  = $request->billing_address;
            $vender->shipping_name    = $request->shipping_name;
            $vender->shipping_country = $request->shipping_country;
            $vender->shipping_state   = $request->shipping_state;
            $vender->shipping_city    = $request->shipping_city;
            $vender->shipping_phone   = $request->shipping_phone;
            $vender->shipping_zip     = $request->shipping_zip;
            $vender->shipping_address = $request->shipping_address;
            $vender->save();
            CustomField::saveData($vender, $request->customField);

            return redirect()->route('vender.index')->with('success', __('Vendor successfully updated.'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }


    public function destroy(Vender $vender)
    {
        if (
            \Auth::user()->type == 'company'
            || \Auth::user()->type == 'accountant'
        ) {
            if ($vender->created_by == \Auth::user()->creatorId()) {
                $vender->delete();

                return redirect()->route('vender.index')->with('success', __('Vendor successfully deleted.'));
            } else {
                return redirect()->back()->with('error', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    function venderNumber()
    {
        $latest = Vender::where('created_by', '=', \Auth::user()->creatorId())->latest()->first();
        if (!$latest) {
            return 1;
        }

        return $latest->vender_id + 1;
    }

    public function venderLogout(Request $request)
    {
        \Auth::guard('vender')->logout();

        $request->session()->invalidate();

        return redirect()->route('vender.login');
    }

    public function payment(Request $request)
    {

        if (\Auth::user()->type == 'vender') {
            $category = [
                'Bill' => 'Bill',
                'Deposit' => 'Deposit',
                'Sales' => 'Sales',
            ];

            $query = Transaction::where('user_id', \Auth::user()->id)->where('created_by', \Auth::user()->creatorId())->where('user_type', 'Vender')->where('type', 'Payment');
            if (!empty($request->date)) {
                $date_range = explode(' - ', $request->date);
                $query->whereBetween('date', $date_range);
            }

            if (!empty($request->category)) {
                $query->where('category', '=', $request->category);
            }
            $payments = $query->get();

            return view('vender.payment', compact('payments', 'category'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function transaction(Request $request)
    {

        if (\Auth::user()->type == 'vender') {

            $category = [
                'Bill' => 'Bill',
                'Deposit' => 'Deposit',
                'Sales' => 'Sales',
            ];

            $query = Transaction::where('user_id', \Auth::user()->id)->where('user_type', 'Vender');

            if (!empty($request->date)) {
                $date_range = explode(' - ', $request->date);
                $query->whereBetween('date', $date_range);
            }

            if (!empty($request->category)) {
                $query->where('category', '=', $request->category);
            }
            $transactions = $query->get();

            return view('vender.transaction', compact('transactions', 'category'));
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    public function profile()
    {
        $userDetail              = \Auth::user();
        $userDetail->customField = CustomField::getData($userDetail, 'vendor');
        $customFields            = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'vendor')->get();

        return view('vender.profile', compact('userDetail', 'customFields'));
    }

    public function editprofile(Request $request)
    {

        $userDetail = \Auth::user();
        $user       = Vender::findOrFail($userDetail['id']);
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
            $filename        = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension       = $request->file('profile')->getClientOriginalExtension();
            $fileNameToStore = $filename . '_' . time() . '.' . $extension;

            $dir        = storage_path('uploads/avatar/');
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
        $user['name']    = $request['name'];
        $user['email']   = $request['email'];
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
        $user       = Vender::findOrFail($userDetail['id']);
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
        $user       = Vender::findOrFail($userDetail['id']);
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


        $user       = Auth::user();
        $user->lang = $lang;
        $user->save();

        return redirect()->back()->with('success', __('Language successfully change.'));
    }

    public function export()
    {
        $name = 'vendor_' . date('Y-m-d i:h:s');
        $data = Excel::download(new VenderExport(), $name . '.xlsx');

        return $data;
    }

    public function importFile()
    {
        return view('vender.import');
    }

    public function import(Request $request)
    {

        $rules = [
            'file' => 'required|mimes:csv,txt',
        ];

        $validator = \Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            $messages = $validator->getMessageBag();

            return redirect()->back()->with('error', $messages->first());
        }

        $vendors = (new VenderImport())->toArray(request()->file('file'))[0];

        $totalCustomer = count($vendors) - 1;
        $errorArray    = [];
        for ($i = 1; $i <= count($vendors) - 1; $i++) {
            $vendor = $vendors[$i];

            $vendorByEmail = Vender::where('email', $vendor[2])->first();

            if (!empty($vendorByEmail)) {
                $vendorData = $vendorByEmail;
            } else {
                $vendorData            = new Vender();
                $vendorData->vender_id = $this->venderNumber();
            }

            $vendorData->vender_id          = $vendor[0];
            $vendorData->name               = $vendor[1];
            $vendorData->email              = $vendor[2];
            $vendorData->contact            = $vendor[3];
            $vendorData->avatar             = $vendor[4];
            $vendorData->billing_name       = $vendor[5];
            $vendorData->billing_country    = $vendor[6];
            $vendorData->billing_state      = $vendor[7];
            $vendorData->billing_city       = $vendor[8];
            $vendorData->billing_phone      = $vendor[9];
            $vendorData->billing_zip        = $vendor[10];
            $vendorData->billing_address    = $vendor[11];
            $vendorData->shipping_name      = $vendor[12];
            $vendorData->shipping_country   = $vendor[13];
            $vendorData->shipping_state     = $vendor[14];
            $vendorData->shipping_city      = $vendor[15];
            $vendorData->shipping_phone     = $vendor[16];
            $vendorData->shipping_zip       = $vendor[17];
            $vendorData->shipping_address   = $vendor[18];
            $vendorData->created_by         = \Auth::user()->creatorId();

            if (empty($vendorData)) {
                $errorArray[] = $vendorData;
            } else {
                $vendorData->save();
            }
        }

        $errorRecord = [];
        if (empty($errorArray)) {
            $data['status'] = 'success';
            $data['msg']    = __('Record successfully imported');
        } else {
            $data['status'] = 'error';
            $data['msg']    = count($errorArray) . ' ' . __('Record imported fail out of' . ' ' . $totalCustomer . ' ' . 'record');


            foreach ($errorArray as $errorData) {

                $errorRecord[] = implode(',', $errorData);
            }

            \Session::put('errorArray', $errorRecord);
        }

        return redirect()->back()->with($data['status'], $data['msg']);
    }
    public function getSuppliersDetailsFromApi()
    {
        try {
            ini_set('max_execution_time', 300);

            $config = ConfigSettings::first();

            $url = $config->api_url . 'GetPurchaseListV2?date=20210101120000';

            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                'key' => '123456'
            ])->timeout(300)->get($url);

            $data = $response->json();
            \Log::info('VENDER ERROR');
            \Log::info($data);
            $salesSuppliers = $data['responseData']['saleList'];

            // Log API request and response details
            \Log::info('API Request Data of Suppliers / Vender Details  of Sales and Purchases: ' . json_encode($data));
            \Log::info('API Request Data of Suppliers / Vender Details  of Sales and Purchases: ' . json_encode($salesSuppliers));
            \Log::info('API Response: ' . $response->body());
            \Log::info('API Response Status Code: ' . $response->status());

            // Divide the data into batches of 100 items each
            $batches = array_chunk($salesSuppliers, 100);

            foreach ($batches as $batch) {
                foreach ($batch as $item) {
                    // Process each batch
                    Vender::create([
                        'vender_id' => $this->venderNumber(),
                        'name' => $item['spplrNm'],
                        'tax_number' => $item['spplrTin'],
                        'spplrTin' => $item['spplrTin'],
                        'spplrNm' => $item['spplrNm'],
                        'spplrBhfId' => $item['spplrBhfId'],
                        'spplrInvcNo' => $item['spplrInvcNo'],
                        'spplrSdcId' => $item['spplrSdcId'],
                        'spplrMrcNo' => $item['spplrMrcNo'],
                        'created_by' => \Auth::user()->creatorId(),
                    ]);
                }
            }

            return redirect()->route('vender.index')->with('success', __('Suppliers / Vender Details successfully created From Api.'));
        } catch (\Exception $e) {
            \Log::error('Error addingSuppliers / Vender Details  Details  from the API: ');
            \Log::info($e);
            return redirect()->route('vender.index')->with('error', __('Error adding Suppliers / Vender Details  Details  from the API.'));
        }
    }



    // get SupplierInformationto to auto fill listing form
    public function getSupplierInformation(Request $request)
    {
        // Fetch Supplier  information based on the item code
        $supplierName = $request->input('supplierName');

        \Log::info('Supplier Name: ' . $supplierName);

        $supplierInfo['data'] = Vender::where('spplrNm', $supplierName)->first();

        if ($supplierInfo['data']) {
            // Return Supplier information as JSON response
            return response()->json($supplierInfo);
        } else {
            // If supplier information not found, return empty response
            \Log::error('No data found for supplier: ' . $supplierName);
            return response()->json([]);
        }
    }
}
