<?php

namespace App\Http\Controllers;

use App\Models\Train;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class trainController extends Controller
{
    public function index()
    {
        $trains = Train::latest()->get();
        return view('pages.trains.index', compact('trains'));
    }

    public function create()
    {
        return view('pages.trains.create');
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
            $image->move(public_path('assets/images/trains'), $imageName);
        }

        Train::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => 'assets/images/trains/' . $imageName,
        ]);

        return redirect()->route('trains.index')->with('success', 'train created successfully.');
    }

    public function show(Train $train)
    {
        return view('pages.trains.show', compact('train'));
    }

    public function edit(Train $train)
    {
        return view('pages.trains.edit', compact('train'));
    }

    public function update(Request $request, Train $train)
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
            if (File::exists(public_path($train->cover_image))) {
                File::delete(public_path($train->cover_image));
            }

            // Upload new image
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/trains'), $imageName);
            $data['cover_image'] = 'assets/images/trains/' . $imageName;
        }

        $train->update($data);

        return redirect()->route('trains.index')->with('success', 'train updated successfully.');
    }

    public function destroy(Train $train)
    {
        // Delete image
        if (File::exists(public_path($train->cover_image))) {
            File::delete(public_path($train->cover_image));
        }

        $train->delete();

        return redirect()->route('trains.index')->with('success', 'train deleted successfully.');
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
            Train::get([
                "title_$lang as title",
                "description_$lang as description",
                'cover_image'
            ])->map(function ($train) {
                return [
                    'title' => $train->title,
                    'description' => $train->description,
                    'cover_image_url' => $train->cover_image ? asset($train->cover_image) : null
                ];
            })
        );
    }
}
