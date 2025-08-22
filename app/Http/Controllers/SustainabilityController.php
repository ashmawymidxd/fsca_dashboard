<?php

namespace App\Http\Controllers;

use App\Models\Sustainability;
use Illuminate\Http\Request;

class SustainabilityController extends Controller
{
    public function index()
    {
        // Order by the order column
        $sustainabilities = Sustainability::with('translations')->orderBy('order')->get();
        return view('pages.sustainabilities.index', compact('sustainabilities'));
    }

    public function create()
    {
        return view('pages.sustainabilities.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        // Store image in public directory
        $imageName = time().'.'.$request->cover_image->extension();
        $request->cover_image->move(public_path('assets/images/sustainabilities'), $imageName);
        $imagePath = 'assets/images/sustainabilities/'.$imageName;

        // Get the count of existing sustainabilities to set the order
        $order = Sustainability::count() + 1;

        $sustainability = Sustainability::create([
            'cover_image' => $imagePath,
            'is_active' => $request->has('is_active'),
            'order' => $order,
        ]);

        $sustainability->translations()->createMany([
            [
                'locale' => 'en',
                'title' => $request->title_en,
                'description' => $request->description_en,
            ],
            [
                'locale' => 'ar',
                'title' => $request->title_ar,
                'description' => $request->description_ar,
            ],
        ]);

        return redirect()->route('sustainabilities.index')->with('success', 'Sustainability created successfully.');
    }

    public function show(Sustainability $sustainability)
    {
        return view('pages.sustainabilities.show', compact('sustainability'));
    }

    public function edit(Sustainability $sustainability)
    {
        return view('pages.sustainabilities.edit', compact('sustainability'));
    }

    public function update(Request $request, Sustainability $sustainability)
    {
        $request->validate([
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if (file_exists(public_path($sustainability->cover_image))) {
                unlink(public_path($sustainability->cover_image));
            }

            // Store new image in public directory
            $imageName = time().'.'.$request->cover_image->extension();
            $request->cover_image->move(public_path('assets/images/sustainabilities'), $imageName);
            $imagePath = 'assets/images/sustainabilities/'.$imageName;
            $sustainability->cover_image = $imagePath;
        }

        $sustainability->is_active = $request->has('is_active');
        $sustainability->save();

        $sustainability->translations()->where('locale', 'en')->update([
            'title' => $request->title_en,
            'description' => $request->description_en,
        ]);

        $sustainability->translations()->where('locale', 'ar')->update([
            'title' => $request->title_ar,
            'description' => $request->description_ar,
        ]);

        return redirect()->route('sustainabilities.index')->with('success', 'Sustainability updated successfully.');
    }

    public function destroy(Sustainability $sustainability)
    {
        // Delete image
        if (file_exists(public_path($sustainability->cover_image))) {
            unlink(public_path($sustainability->cover_image));
        }

        $sustainability->delete();

        // Reorder the remaining items
        $sustainabilities = Sustainability::orderBy('order')->get();
        foreach ($sustainabilities as $index => $item) {
            $item->update(['order' => $index + 1]);
        }

        return redirect()->route('sustainabilities.index')->with('success', 'Sustainability deleted successfully.');
    }

    // Add this method for reordering
    public function reorder(Request $request)
    {
        $request->validate([
            'sustainabilities' => 'required|array',
            'sustainabilities.*' => 'exists:sustainabilities,id',
        ]);

        foreach ($request->sustainabilities as $index => $sustainabilityId) {
            Sustainability::where('id', $sustainabilityId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    // API Methods
    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en'); // Default to English

        $sustainabilities = Sustainability::where('is_active', true)
            ->orderBy('order') // Add ordering for API as well
            ->with(['translations' => function($query) use ($lang) {
                $query->where('locale', $lang);
            }])
            ->get()
            ->map(function($sustainability) use ($lang) {
                $translation = $sustainability->translation($lang);

                return [
                    'cover_image' => url($sustainability->cover_image),
                    'title' => $translation ? $translation->title : 'No translation available',
                    'description' => $translation ? $translation->description : 'No translation available',
                    'order' => $sustainability->order,
                ];
            });

        return response()->json($sustainabilities);
    }
}
