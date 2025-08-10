<?php

namespace App\Http\Controllers;

use App\Models\Fleet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FleetController extends Controller
{
    public function index()
    {
        $fleets = Fleet::latest()->get();
        return view('pages.fleets.index', compact('fleets'));
    }

    public function create()
    {
        return view('pages.fleets.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/fleets'), $imageName);
        }

        Fleet::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => 'assets/images/fleets/' . $imageName,
        ]);

        return redirect()->route('fleets.index')->with('success', 'Fleet created successfully.');
    }

    public function show(Fleet $fleet)
    {
        return view('pages.fleets.show', compact('fleet'));
    }

    public function edit(Fleet $fleet)
    {
        return view('pages.fleets.edit', compact('fleet'));
    }

    public function update(Request $request, Fleet $fleet)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
        ];

        // Handle image update
        if ($request->hasFile('cover_image')) {
            // Delete old image
            if (File::exists(public_path($fleet->cover_image))) {
                File::delete(public_path($fleet->cover_image));
            }

            // Upload new image
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/fleets'), $imageName);
            $data['cover_image'] = 'assets/images/fleets/' . $imageName;
        }

        $fleet->update($data);

        return redirect()->route('fleets.index')->with('success', 'Fleet updated successfully.');
    }

    public function destroy(Fleet $fleet)
    {
        // Delete image
        if (File::exists(public_path($fleet->cover_image))) {
            File::delete(public_path($fleet->cover_image));
        }

        $fleet->delete();

        return redirect()->route('fleets.index')->with('success', 'Fleet deleted successfully.');
    }

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

        return response()->json(
            Fleet::get([
                "title_$lang as title",
                "description_$lang as description",
                'cover_image'
            ])->map(function ($fleet) {
                return [
                    'title' => $fleet->title,
                    'description' => $fleet->description,
                    'cover_image_url' => $fleet->cover_image ? asset($fleet->cover_image) : null
                ];
            })
        );
    }
}
