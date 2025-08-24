<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class AboutUsController extends Controller
{
    public function index()
    {
        $aboutUs = AboutUs::orderBy('order')->get();
        return view('pages.about-us.index', compact('aboutUs'));
    }

    public function create()
    {
        $nextOrder = AboutUs::max('order') + 1;
        return view('pages.about-us.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = null;

        // Handle image upload
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/about-us'), $imageName);
            $imagePath = 'assets/images/about-us/' . $imageName;
        }

        // Get the next order value
        $nextOrder = AboutUs::max('order') + 1;

        AboutUs::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => $imagePath,
            'order' => $nextOrder,
        ]);

        return redirect()->route('about-us.index')->with('success', 'About Us section created successfully.');
    }


    public function show(AboutUs $aboutU)
    {
        return view('pages.about-us.show', compact('aboutU'));
    }

    public function edit(AboutUs $aboutU)
    {
        return view('pages.about-us.edit', compact('aboutU'));
    }

    public function update(Request $request, AboutUs $aboutU)
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
            // Delete old image if exists
            if ($aboutU->cover_image && File::exists(public_path($aboutU->cover_image))) {
                File::delete(public_path($aboutU->cover_image));
            }

            // Upload new image
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/about-us'), $imageName);
            $data['cover_image'] = 'assets/images/about-us/' . $imageName;
        }

        $aboutU->update($data);

        return redirect()->route('about-us.index')->with('success', 'About Us section updated successfully.');
    }


    public function destroy(AboutUs $aboutU)
    {
        // Delete image
        if (File::exists(public_path($aboutU->cover_image))) {
            File::delete(public_path($aboutU->cover_image));
        }

        $aboutU->delete();

        // Reorder remaining about us sections
        $this->reorderAboutUs();

        return redirect()->route('about-us.index')->with('success', 'About Us section deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'about_us' => 'required|array',
            'about_us.*' => 'exists:about_us,id',
        ]);

        foreach ($request->about_us as $index => $aboutUsId) {
            AboutUs::where('id', $aboutUsId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function reorderAboutUs()
    {
        $aboutUs = AboutUs::orderBy('order')->get();

        foreach ($aboutUs as $index => $aboutU) {
            $aboutU->update(['order' => $index + 1]);
        }
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
            AboutUs::orderBy('order')->get([
                "title_$lang as title",
                "description_$lang as description",
                'cover_image',
                'order',
            ])->map(function ($aboutU) {
                return [
                    'title' => $aboutU->title,
                    'description' => $aboutU->description,
                    'cover_image_url' => $aboutU->cover_image ? asset($aboutU->cover_image) : null,
                    'order' => $aboutU->order,
                ];
            })
        );
    }
}
