<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

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
            'website_name_ar' => 'nullable|string|max:255',
            'website_name_en' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'pdf' => 'nullable|file|mimes:pdf|max:5120',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'location_name_ar' => 'nullable|string|max:255',
            'location_name_en' => 'nullable|string|max:255',
            'location_link' => 'nullable|url',
            'facebook' => 'nullable|url',
            'twitter' => 'nullable|url',
            'instagram' => 'nullable|url',
            'linkedin' => 'nullable|url',
            'maintenance_mode' => 'nullable|boolean',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $settings = Setting::firstOrNew(['id' => 1]);
            $data = $validated;

            // Convert maintenance_mode to boolean if not set
            $data['maintenance_mode'] = $request->input('maintenance_mode', false);

            // Handle logo upload
            if ($request->hasFile('logo')) {
                // Delete old logo if exists
                if ($settings->logo && File::exists(public_path($settings->logo))) {
                    File::delete(public_path($settings->logo));
                }

                $logo = $request->file('logo');
                $logoName = 'logo-' . time() . '.' . $logo->getClientOriginalExtension();
                $logoPath = 'assets/images/settings/' . $logoName;
                $logo->move(public_path('assets/images/settings'), $logoName);
                $data['logo'] = $logoPath;
            } else {
                unset($data['logo']);
            }

            // Handle PDF upload
            if ($request->hasFile('pdf')) {
                // Delete old PDF if exists
                if ($settings->pdf && File::exists(public_path($settings->pdf))) {
                    File::delete(public_path($settings->pdf));
                }

                $pdf = $request->file('pdf');
                $pdfName = 'document-' . time() . '.' . $pdf->getClientOriginalExtension();
                $pdfPath = 'assets/images/settings/' . $pdfName;
                $pdf->move(public_path('assets/images/settings'), $pdfName);
                $data['pdf'] = $pdfPath;
            } else {
                unset($data['pdf']);
            }

            $settings->fill($data);
            $settings->save();
        });

        return redirect()->route('settings.index')->with('success', 'Settings updated successfully!');
    }

    /**
     * Get settings data as JSON organized by categories
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en');

        // Validate language parameter
        if (!in_array($lang, ['en', 'ar'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid language parameter. Use "en" or "ar".',
            ], 400);
        }

        $settings = Setting::first() ?? new Setting();

        $response = [
            'basic_info' => [
                'website_name' => $settings->{"website_name_$lang"},
                'logo' => $settings->logo ? url($settings->logo) : null,
                'pdf' => $settings->pdf ? url($settings->pdf) : null,
                'maintenance_mode' => (bool)$settings->maintenance_mode,
            ],
            'contact_info' => [
                'email' => $settings->email,
                'phone' => $settings->phone,
                'whatsapp' => $settings->whatsapp,
            ],
            'location_info' => [
                'location_name' => $settings->{"location_name_$lang"},
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
            'success' => true,
            'data' => $response,
        ]);
    }
}
