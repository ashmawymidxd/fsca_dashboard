<?php

namespace App\Http\Controllers;

use App\Models\Sustainability;
use Illuminate\Http\Request;

class SustainabilityController extends Controller
{
    public function index()
    {
        $sustainabilities = Sustainability::with('translations')->get();
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

        $sustainability = Sustainability::create([
            'cover_image' => $imagePath,
            'is_active' => $request->has('is_active'),
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
        return redirect()->route('sustainabilities.index')->with('success', 'Sustainability deleted successfully.');
    }

    // API Methods
    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en'); // Default to English

        $sustainabilities = Sustainability::where('is_active', true)
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
                ];
            });

        return response()->json($sustainabilities);
    }
}
