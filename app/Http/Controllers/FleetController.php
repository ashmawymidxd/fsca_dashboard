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
        $fleets = Fleet::orderBy('order')->get();
        return view('pages.fleets.index', compact('fleets'));
    }

    public function create()
    {
        $nextOrder = Fleet::max('order') + 1;
        return view('pages.fleets.create', compact('nextOrder'));
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

        // Get the next order value
        $nextOrder = Fleet::max('order') + 1;

        Fleet::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => 'assets/images/fleets/' . $imageName,
            'order' => $nextOrder,
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

        // Reorder remaining fleets
        $this->reorderFleets();

        return redirect()->route('fleets.index')->with('success', 'Fleet deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'fleets' => 'required|array',
            'fleets.*' => 'exists:fleets,id',
        ]);

        foreach ($request->fleets as $index => $fleetId) {
            Fleet::where('id', $fleetId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function reorderFleets()
    {
        $fleets = Fleet::orderBy('order')->get();

        foreach ($fleets as $index => $fleet) {
            $fleet->update(['order' => $index + 1]);
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
            Fleet::orderBy('order')->get([
                "title_$lang as title",
                "description_$lang as description",
                'cover_image',
                'order',
            ])->map(function ($fleet) {
                return [
                    'title' => $fleet->title,
                    'description' => $fleet->description,
                    'cover_image_url' => $fleet->cover_image ? asset($fleet->cover_image) : null,
                    'order' => $fleet->order,
                ];
            })
        );
    }
}
