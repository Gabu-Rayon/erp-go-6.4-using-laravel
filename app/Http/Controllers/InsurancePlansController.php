<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Illuminate\Http\Request;
use App\Models\ConfigSettings;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;

class InsurancePlansController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (\Auth::user()->type == 'company') {
            try {
                $insurances = Insurance::all();
                return view('insurance.index', compact('insurances'));
            } catch (\Exception $e) {
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (\Auth::user()->type == 'company') {
            return view('insurance.create');
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //retrievie the Api endpoint config from the database that is api_url and api_key  
        $config = ConfigSettings::first();
        if (\Auth::user()->type == 'company') {
            // Validate the incoming request data
            $request->validate([
                'insurancecode' => 'required|string',
                'insurancename' => 'required|string',
                'premiumrate' => 'required|numeric',
                'isUsed' => 'required',
            ]);

            // Prepare the data to be sent in the request   
            $requestData = [
                'insuranceCode' => $request->all()['insurancecode'],
                'insuranceName' => $request->all()['insurancename'],
                'premiumRate' => $request->all()['premiumrate'],
                'isUsed' => (boolean) $request->all()['isUsed'],
            ];

            // $requestData = [
            //     'insuranceCode' => 'ABC123',
            //     'insuranceName' => 'Test Insurance',
            //     'premiumRate' => 100,
            //     'isUsed' => true, 
            // ];
            // Save the data to the local database using the model

            // Send the POST request to the API endpoint using the ConfigSettings Model 
            $response = Http::withOptions([
                'verify' => false
            ])->withHeaders([
                        'accept' => 'application/json',
                        'key' => $config->api_key,
                        'Content-Type' => 'application/json-patch+json',
                    ])->post($config->api_url . 'AddInsuranceV2', $requestData);

            // Log the API response
            \Log::info('API Request Data Posting Insurance Plan: ' . json_encode($requestData));
            \Log::info('API Response from posting Insurance Plan: ' . $response->body());
            \Log::info('API Response Status Code: ' . $response->status());

            // Check if the request was successful
            // if ($response->successful()) {
            //     if ($response['data']['resultCd'] == 910) {
            //         return redirect()->back()->with('error', __('Rate must be between 0 and 100.'));
            //     }
            //     $insurance = Insurance::create($requestData);                
            //     $insurance->save();

            //     return redirect()->back()->with('success', __('Insurance Plan Successfully created.'));
            // } else {
            //     // API call failed, log the error and return an error response
            //     \Log::error('Failed to add insurance via API: ' . $response->status() . ' ' . $response->body());
            //     return redirect()->back()->with('error', __('Failed to add insurance Plan via API.'));
            // }

            // Check if the request was successful
            if ($response->successful()) {
                $responseData = $response->json();

                // Handle the case where the response indicates success
                if ($responseData['status']) {
                    // Extract the isKRASync value from the response
                    $isKRASync = $responseData['responseData']['isKRASync'] ?? false; // Default to false if not set

                    // Save the insurance data to the local database
                    $insurance = Insurance::create(array_merge($requestData, ['isKRASync' => $isKRASync]));

                    return redirect()->back()->with('success', __('Insurance Plan Successfully created.'));
                } else {
                    return redirect()->back()->with('error', $responseData['message']);
                }
            } else {
                // Handle unsuccessful API calls that don't return a successful status
                $responseData = $response->json(); // Attempt to decode the response to get the message

                // Format the error messages for display
                $errorMessages = [];
                if (isset($responseData['errors'])) {
                    foreach ($responseData['errors'] as $field => $messages) {
                        foreach ($messages as $message) {
                            $errorMessages[] = "{$field}: {$message}";
                        }
                    }
                } else {
                    $errorMessages[] = $responseData['message'] ?? __('Failed to add insurance Plan via API.');
                }

                // Log the error message
                \Log::error('Failed to add insurance via API: ' . $response->status() . ' ' . json_encode($errorMessages));

                return redirect()->back()->with('error', implode(', ', $errorMessages));
            }
        } else {
            return redirect()->back()->with('error', __('Permission denied.'));
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {


        if (\Auth::user()->type == 'company') {
            $insurance = Insurance::find($id);
            return view('insurance.view', compact('insurance'));

        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Insurance $Insurance)
    {
        if (\Auth::user()->type == 'company') {
            //method code here
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Insurance $Insurance)
    {
        if (\Auth::user()->type == 'company') {
            //method code here  //method code here
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Insurance $Insurance)
    {
        if (\Auth::user()->type == 'company') {
            //method code here
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

}