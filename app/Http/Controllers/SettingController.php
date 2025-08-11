<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::first();
        return view('pages.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'website_name' => 'required|string|max:255',
            'website_description' => 'nullable|string',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'location_name' => 'nullable|string|max:255',
            'location_link' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
        ]);

        DB::transaction(function () use ($validated) {
            Setting::updateOrCreate(
                ['id' => 1], // Assuming you only have one settings record
                $validated
            );
        });

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }

    /**
     * Get settings data as JSON organized by categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex()
    {
        $settings = Setting::first() ?? new Setting();

        $response = [
            'basic_info' => [
                'website_name' => $settings->website_name,
                'website_description' => $settings->website_description,
            ],
            'contact_info' => [
                'email' => $settings->email,
                'phone' => $settings->phone,
                'whatsapp' => $settings->whatsapp,
            ],
            'location_info' => [
                'location_name' => $settings->location_name,
                'location_link' => $settings->location_link,
            ],
            'social_media' => [
                'facebook' => $settings->facebook,
                'twitter' => $settings->twitter,
                'instagram' => $settings->instagram,
                'linkedin' => $settings->linkedin,
            ],
        ];

        return response()->json([
            'data' => $response,
        ]);
    }
}
