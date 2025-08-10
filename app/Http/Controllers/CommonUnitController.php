<?php
namespace App\Http\Controllers;

use App\Models\CommonUnit;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class CommonUnitController extends Controller
{
    public function index()
    {
        $commonUnits = CommonUnit::all();
        return view('pages.common-units.index', compact('commonUnits'));
    }

    public function create()
    {
        return view('pages.common-units.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'banner_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'page_name' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        $bannerImage = $this->uploadImage($request->file('banner_image'));
        $coverImage = $this->uploadImage($request->file('cover_image'));

        CommonUnit::create([
            'banner_image' => $bannerImage,
            'cover_image' => $coverImage,
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'page_name' => $request->page_name,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
        ]);

        return redirect()->route('common-units.index')->with('success', 'Common Unit created successfully.');
    }

    public function show(CommonUnit $commonUnit)
    {
        return view('pages.common-units.show', compact('commonUnit'));
    }

    public function edit(CommonUnit $commonUnit)
    {
        return view('pages.common-units.edit', compact('commonUnit'));
    }

    public function update(Request $request, CommonUnit $commonUnit)
    {
        $request->validate([
            'banner_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'page_name' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        $data = [
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'page_name' => $request->page_name,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
        ];

        if ($request->hasFile('banner_image')) {
            $this->deleteImage($commonUnit->banner_image);
            $data['banner_image'] = $this->uploadImage($request->file('banner_image'));
        }

        if ($request->hasFile('cover_image')) {
            $this->deleteImage($commonUnit->cover_image);
            $data['cover_image'] = $this->uploadImage($request->file('cover_image'));
        }

        $commonUnit->update($data);

        return redirect()->route('common-units.index')->with('success', 'Common Unit updated successfully.');
    }

    public function destroy(CommonUnit $commonUnit)
    {
        $this->deleteImage($commonUnit->banner_image);
        $this->deleteImage($commonUnit->cover_image);
        $commonUnit->delete();

        return redirect()->route('common-units.index')->with('success', 'Common Unit deleted successfully.');
    }

    private function uploadImage($image)
    {
        $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
        $imagePath = 'assets/images/' . $imageName;

        // Ensure the directory exists
        if (!File::exists(public_path('assets/images'))) {
            File::makeDirectory(public_path('assets/images'), 0755, true);
        }

        $image->move(public_path('assets/images'), $imageName);
        return $imagePath;
    }

    private function deleteImage($imagePath)
    {
        $fullPath = public_path($imagePath);
        if (File::exists($fullPath)) {
            File::delete($fullPath);
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
            CommonUnit::get([
                "title_$lang as title",
                "description_$lang as description",
                'banner_image',
                'cover_image'
            ])->map(function ($commonUnit) {
                return [
                    'title' => $commonUnit->title,
                    'description' => $commonUnit->description,
                    'banner_image_url' => $commonUnit->banner_image ? asset($commonUnit->banner_image) : null,
                    'cover_image_url' => $commonUnit->cover_image ? asset($commonUnit->cover_image) : null
                ];
            })
        );
    }

    public function apiShow(Request $request, $page_name)
    {
        $lang = $request->query('lang', 'en');

        if (!in_array($lang, ['en', 'ar'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid language parameter. Use "en" or "ar".',
            ], 400);
        }

        $commonUnit = CommonUnit::where('page_name', $page_name)->first();

        if (!$commonUnit) {
            return response()->json([
                'success' => false,
                'message' => 'Common Unit not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'title' => $commonUnit["title_$lang"],
                'description' => $commonUnit["description_$lang"],
                'banner_image_url' => $commonUnit->banner_image ? asset($commonUnit->banner_image) : null,
                'cover_image_url' => $commonUnit->cover_image ? asset($commonUnit->cover_image) : null,
                'page_name' => $commonUnit->page_name,
                'created_at' => $commonUnit->created_at,
                'updated_at' => $commonUnit->updated_at,
            ]
        ]);
    }
}
