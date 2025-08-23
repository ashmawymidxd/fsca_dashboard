<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('order')->get();
        return view('pages.banners.index', compact('banners'));
    }

    public function create()
    {
        $nextOrder = Banner::max('order') + 1;
        return view('pages.banners.create', compact('nextOrder'));
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

        $image = $request->file('cover_image');
        $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('assets/images/banners'), $imageName);

        $nextOrder = Banner::max('order') + 1;

        Banner::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => 'assets/images/banners/' . $imageName,
            'order' => $nextOrder,
        ]);

        return redirect()->route('banners.index')->with('success', 'Banner created successfully.');
    }

    public function show(Banner $banner)
    {
        return view('pages.banners.show', compact('banner'));
    }

    public function edit(Banner $banner)
    {
        return view('pages.banners.edit', compact('banner'));
    }

    public function update(Request $request, Banner $banner)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'title_en', 'title_ar', 'description_en', 'description_ar'
        ]);

        if ($request->hasFile('cover_image')) {
            if (File::exists(public_path($banner->cover_image))) {
                File::delete(public_path($banner->cover_image));
            }
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/banners'), $imageName);
            $data['cover_image'] = 'assets/images/banners/' . $imageName;
        }

        $banner->update($data);
        return redirect()->route('banners.index')->with('success', 'Banner updated successfully.');
    }

    public function destroy(Banner $banner)
    {
        if (File::exists(public_path($banner->cover_image))) {
            File::delete(public_path($banner->cover_image));
        }

        $banner->delete();
        $this->reorderBanners();

        return redirect()->route('banners.index')->with('success', 'Banner deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'banners' => 'required|array',
            'banners.*' => 'exists:banners,id',
        ]);

        foreach ($request->banners as $index => $bannerId) {
            Banner::where('id', $bannerId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function reorderBanners()
    {
        $banners = Banner::orderBy('order')->get();
        foreach ($banners as $index => $banner) {
            $banner->update(['order' => $index + 1]);
        }
    }

    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en');
        if (!in_array($lang, ['en','ar'])) {
            return response()->json(['success' => false, 'message'=>'Invalid language'],400);
        }

        return response()->json(
            Banner::orderBy('order')->get(["title_$lang as title","description_$lang as description",'cover_image','order'])
            ->map(fn($b) => [
                'title'=>$b->title,
                'description'=>$b->description,
                'cover_image_url'=>$b->cover_image? asset($b->cover_image):null,
                'order'=>$b->order
            ])
        );
    }
}
