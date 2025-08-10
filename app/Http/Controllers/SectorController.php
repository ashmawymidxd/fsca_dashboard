<?php

namespace App\Http\Controllers;

use App\Models\Sector;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SectorController extends Controller
{
    public function index()
    {
        $sectors = Sector::latest()->get();
        return view('pages.sectors.index', compact('sectors'));
    }

    public function create()
    {
        return view('pages.sectors.create');
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
            $image->move(public_path('assets/images/sectors'), $imageName);
        }

        Sector::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => 'assets/images/sectors/' . $imageName,
        ]);

        return redirect()->route('sectors.index')->with('success', 'Sector created successfully.');
    }

    public function show(Sector $sector)
    {
        return view('pages.sectors.show', compact('sector'));
    }

    public function edit(Sector $sector)
    {
        return view('pages.sectors.edit', compact('sector'));
    }

    public function update(Request $request, Sector $sector)
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
            if (File::exists(public_path($sector->cover_image))) {
                File::delete(public_path($sector->cover_image));
            }

            // Upload new image
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/sectors'), $imageName);
            $data['cover_image'] = 'assets/images/sectors/' . $imageName;
        }

        $sector->update($data);

        return redirect()->route('sectors.index')->with('success', 'Sector updated successfully.');
    }

    public function destroy(Sector $sector)
    {
        // Delete image
        if (File::exists(public_path($sector->cover_image))) {
            File::delete(public_path($sector->cover_image));
        }

        $sector->delete();

        return redirect()->route('sectors.index')->with('success', 'Sector deleted successfully.');
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
            Sector::get([
                "title_$lang as title",
                "description_$lang as description",
                'cover_image'
            ])->map(function ($sector) {
                return [
                    'title' => $sector->title,
                    'description' => $sector->description,
                    'cover_image_url' => $sector->cover_image ? asset($sector->cover_image) : null
                ];
            })
        );
    }
}
