<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Settings::first();
        return view('setting.index',compact('data'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Store Shopify A credentials
        $setting = Settings::first();
        $setting->shopifyA_host = $request->input('shopifyA_host') ?? $setting->shopifyA_host;
        $setting->shopifyA_access_token = $request->input('shopifyA_access_token') ?? $setting->shopifyA_access_token;
        $setting->shopifyA_api_version = $request->input('shopifyA_api_version') ?? $setting->shopifyA_api_version;
        $setting->shopifyB_host = $request->input('shopifyB_host') ?? $setting->shopifyB_host;
        $setting->shopifyB_access_token = $request->input('shopifyB_access_token') ?? $setting->shopifyB_access_token;
        $setting->shopifyB_api_version = $request->input('shopifyB_api_version') ?? $setting->shopifyB_api_version;
        $setting->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Credentials saved successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Settings $settings)
    {
        //
    }
}
