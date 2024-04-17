<?php

namespace App\Http\Controllers;

use App\Models\CustomField;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class CompositionListController extends Controller
{
    public function addCompositionList()
    {

        return view('compositionlist.index');
    }


    public function createCompositionList(Request $request)
    {

        $customFields = CustomField::where('created_by', '=', \Auth::user()->creatorId())->where('module', '=', 'customer')->get();

        return view('compositionlist.create', compact('customFields'));

        // return view('compositionlist.create');
    }
    public function postCompositionList(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'main_item_code' => 'required|string',
            'composition_item_code' => 'required|array',
            'composition_item_quantity' => 'required|array',
            // Add validation rules for other fields if needed
        ]);

        // Prepare the data to be sent to the API
        $data = [
            'mainItemCode' => $request->input('main_item_code'),
            'compositionItems' => [],
        ];

        // Combine composition item codes and quantities into arrays
        $compositionItemCodes = $request->input('composition_item_code');
        $compositionItemQuantities = $request->input('composition_item_quantity');

        // Loop through the composition items and add them to the data array
        foreach ($compositionItemCodes as $key => $compositionItemCode) {
            $data['compositionItems'][] = [
                'compoItemCode' => $compositionItemCode,
                'compoItemQty' => $compositionItemQuantities[$key],
            ];
        }

        // Log the request body
        \Log::info('Request Body:', $data);

        // Send the POST request to the API endpoint
        $response = Http::post('https://etims.your-apps.biz/api/PostCompositionList', $data, [
            'accept' => '*/*',
            'key' => '123456',
        ]);

        // Log the response status code
        \Log::info('API Response Status Code: ' . $response->status());
        \Log::info('API Response: ' . $response->body());
        \Log::info('API Response Status Code: ' . $response->status());


        // Check if the request was successful
        if ($response->successful()) {
            // API call was successful
            return redirect()->back()->with('success', __('Composition List created successfully'));
        } else {
            // API call failed
            \Log::error('Failed to post Composition List data to API. Status code: ' . $response->status());
            return redirect()->back()->with('error', __('Failed to post Composition List data to API'));
        }
    }

}