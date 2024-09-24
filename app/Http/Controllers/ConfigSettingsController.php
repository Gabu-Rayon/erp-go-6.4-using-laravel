<?php

namespace App\Http\Controllers;

use App\Models\ConfigSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ConfigSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $data = $request->all();

        $validator = Validator::make($data, [
            'local_storage' => 'required|string|in:on,off',
            'stock_update' => 'required|string|in:on,off',
            'customer_mapping_by_tin' => 'required|string|in:on,off',
            'item_mapping_by_code' => 'required|string|in:on,off',
            'api_type' => 'required|string|in:OSCU,VSCU',
            'api_url' => 'required|string',
            'api_key' => 'required|string'
        ]);

        if ($validator->fails()) {
            Log::info('VALIDATION ERROR');
            Log::info($validator->errors());

            return redirect()->back()->with('error', $validator->errors()->first());
        }

        $config_settings = ConfigSettings::first();

        $config_settings->update([
            'local_storage' => $data['local_storage'],
            'stock_update' => $data['stock_update'],
            'customer_mapping_by_tin' => $data['customer_mapping_by_tin'],
            'item_mapping_by_code' => $data['item_mapping_by_code'],
            'api_type' => $data['api_type'],
            'api_url' => $data['api_url'],
            'api_key' => $data['api_key']

        ]);

        return redirect()->back()->with('success', 'Configuration settings updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}