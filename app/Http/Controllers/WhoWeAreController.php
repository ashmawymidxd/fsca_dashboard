<?php

namespace App\Http\Controllers;

use App\Models\WhoWeAre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class WhoWeAreController extends Controller
{
    public function index()
    {
        $whoWeAres = WhoWeAre::orderBy('order')->get();
        return view('pages.who_we_are.index', compact('whoWeAres'));
    }

    public function create()
    {
        $nextOrder = WhoWeAre::max('order') + 1;
        return view('pages.who_we_are.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle image upload
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/who_we_are'), $imageName);
        }

        // Get the next order value
        $nextOrder = WhoWeAre::max('order') + 1;

        WhoWeAre::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => 'assets/images/who_we_are/' . $imageName,
            'order' => $nextOrder,
        ]);

        return redirect()->route('who_we_are.index')->with('success', 'Who We Are entry created successfully.');
    }

    public function show(WhoWeAre $whoWeAre)
    {
        return view('pages.who_we_are.show', compact('whoWeAre'));
    }

    public function edit(WhoWeAre $whoWeAre)
    {
        return view('pages.who_we_are.edit', compact('whoWeAre'));
    }

    public function update(Request $request, WhoWeAre $whoWeAre)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jjpg,gif,svg|max:2048',
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
            if (File::exists(public_path($whoWeAre->cover_image))) {
                File::delete(public_path($whoWeAre->cover_image));
            }

            // Upload new image
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/who_we_are'), $imageName);
            $data['cover_image'] = 'assets/images/who_we_are/' . $imageName;
        }

        $whoWeAre->update($data);

        return redirect()->route('who_we_are.index')->with('success', 'Who We Are entry updated successfully.');
    }

    public function destroy(WhoWeAre $whoWeAre)
    {
        // Delete image
        if (File::exists(public_path($whoWeAre->cover_image))) {
            File::delete(public_path($whoWeAre->cover_image));
        }

        $whoWeAre->delete();

        // Reorder remaining items
        $this->reorderWhoWeAres();

        return redirect()->route('who_we_are.index')->with('success', 'Who We Are entry deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'who_we_ares' => 'required|array',
            'who_we_ares.*' => 'exists:who_we_ares,id',
        ]);

        foreach ($request->who_we_ares as $index => $whoWeAreId) {
            WhoWeAre::where('id', $whoWeAreId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function reorderWhoWeAres()
    {
        $whoWeAres = WhoWeAre::orderBy('order')->get();

        foreach ($whoWeAres as $index => $whoWeAre) {
            $whoWeAre->update(['order' => $index + 1]);
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
            WhoWeAre::orderBy('order')->get([
                "title_$lang as title",
                "description_$lang as description",
                'cover_image',
                'order',
            ])->map(function ($whoWeAre) {
                return [
                    'title' => $whoWeAre->title,
                    'description' => $whoWeAre->description,
                    'cover_image_url' => $whoWeAre->cover_image ? asset($whoWeAre->cover_image) : null,
                    'order' => $whoWeAre->order,
                ];
            })
        );
    }
}
