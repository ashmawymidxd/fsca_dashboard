<?php

namespace App\Http\Controllers;

use App\Models\Hero;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class HeroController extends Controller
{
    public function index()
    {
        $heroes = Hero::all();
        return view('pages.heroes.index', compact('heroes'));
    }

    public function create()
    {
        return view('pages.heroes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'button_text_en' => 'required|string|max:255',
            'button_text_ar' => 'required|string|max:255',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);

        $imagePath = $this->uploadImage($request->file('cover_image'), 'heroes');

        $hero = Hero::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'button_text_en' => $request->button_text_en,
            'button_text_ar' => $request->button_text_ar,
            'cover_image' => $imagePath,
            'slug_en' => Str::slug($request->title_en),
            'slug_ar' => Str::slug($request->title_ar),
        ]);

        return redirect()->route('heroes.index')->with('success', 'Hero created successfully.');
    }

    public function show(Hero $hero)
    {
        return view('pages.heroes.show', compact('hero'));
    }

    public function edit(Hero $hero)
    {
        return view('pages.heroes.edit', compact('hero'));
    }

    public function update(Request $request, Hero $hero)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'button_text_en' => 'required|string|max:255',
            'button_text_ar' => 'required|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120', // 5MB
        ]);

        $data = [
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'button_text_en' => $request->button_text_en,
            'button_text_ar' => $request->button_text_ar,
            'slug_en' => Str::slug($request->title_en),
            'slug_ar' => Str::slug($request->title_ar),
        ];

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if (file_exists(public_path($hero->cover_image))) {
                unlink(public_path($hero->cover_image));
            }
            $data['cover_image'] = $this->uploadImage($request->file('cover_image'), 'heroes');
        }

        $hero->update($data);

        return redirect()->route('heroes.index')->with('success', 'Hero updated successfully.');
    }

    public function destroy(Hero $hero)
    {
        // Delete cover image
        if (file_exists(public_path($hero->cover_image))) {
            unlink(public_path($hero->cover_image));
        }

        $hero->delete();

        return redirect()->route('heroes.index')->with('success', 'Hero deleted successfully.');
    }

    private function uploadImage($image, $folder)
    {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $path = 'uploads/' . $folder . '/';
        $image->move(public_path($path), $imageName);
        return $path . $imageName;
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
            Hero::select([
                "title_$lang as title",
                "description_$lang as description",
                "button_text_$lang as button_text",
                'cover_image'
            ])
            ->get()
            ->map(function ($hero) {
                return [
                    'title' => $hero->title,
                    'description' => $hero->description,
                    'button_text' => $hero->button_text,
                    'cover_image_url' => $hero->cover_image ? asset($hero->cover_image) : null,
                ];
            })
        );
    }
}
