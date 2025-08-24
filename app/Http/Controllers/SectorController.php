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
        $sectors = Sector::orderBy('order')->get();
        return view('pages.sectors.index', compact('sectors'));
    }

    public function create()
    {
        $nextOrder = Sector::max('order') + 1;
        return view('pages.sectors.create', compact('nextOrder'));
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

        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/sectors'), $imageName);
        }

        $nextOrder = Sector::max('order') + 1;

        Sector::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => 'assets/images/sectors/' . $imageName,
            'order' => $nextOrder,
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
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
        ];

        if ($request->hasFile('cover_image')) {
            if (File::exists(public_path($sector->cover_image))) {
                File::delete(public_path($sector->cover_image));
            }

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
        if (File::exists(public_path($sector->cover_image))) {
            File::delete(public_path($sector->cover_image));
        }

        $sector->delete();
        $this->reorderSectors();

        return redirect()->route('sectors.index')->with('success', 'Sector deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'sectors' => 'required|array',
            'sectors.*' => 'exists:sectors,id',
        ]);

        foreach ($request->sectors as $index => $sectorId) {
            Sector::where('id', $sectorId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function reorderSectors()
    {
        $sectors = Sector::orderBy('order')->get();

        foreach ($sectors as $index => $sector) {
            $sector->update(['order' => $index + 1]);
        }
    }

    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en');

        if (!in_array($lang, ['en', 'ar'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid language parameter. Use "en" or "ar".',
            ], 400);
        }

        return response()->json(
            Sector::orderBy('order')->get([
                "title_$lang as title",
                "description_$lang as description",
                'cover_image',
                'order',
            ])->map(function ($sector) {
                return [
                    'title' => $sector->title,
                    'description' => $sector->description,
                    'cover_image_url' => $sector->cover_image ? asset($sector->cover_image) : null,
                    'order' => $sector->order,
                ];
            })
        );
    }
}
