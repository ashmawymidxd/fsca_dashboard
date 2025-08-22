<?php

namespace App\Http\Controllers;

use App\Models\SupportAndHelp;
use Illuminate\Http\Request;

class SupportAndHelpController extends Controller
{
    public function index()
    {
        $supportAndHelps = SupportAndHelp::with('translations')
            ->orderBy('order')
            ->get();
        return view('pages.support_and_helps.index', compact('supportAndHelps'));
    }

    public function create()
    {
        return view('pages.support_and_helps.create');
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
        $request->cover_image->move(public_path('assets/images/support_and_helps'), $imageName);
        $imagePath = 'assets/images/support_and_helps/'.$imageName;

        // Get the next order value
        $order = SupportAndHelp::max('order') + 1;

        $supportAndHelp = SupportAndHelp::create([
            'cover_image' => $imagePath,
            'is_active' => $request->has('is_active'),
            'order' => $order,
        ]);

        $supportAndHelp->translations()->createMany([
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

        return redirect()->route('support-and-helps.index')->with('success', 'SupportAndHelp created successfully.');
    }

    public function show(SupportAndHelp $supportAndHelp)
    {
        return view('pages.support_and_helps.show', compact('supportAndHelp'));
    }

    public function edit(SupportAndHelp $supportAndHelp)
    {
        return view('pages.support_and_helps.edit', compact('supportAndHelp'));
    }

    public function update(Request $request, SupportAndHelp $supportAndHelp)
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
            if (file_exists(public_path($supportAndHelp->cover_image))) {
                unlink(public_path($supportAndHelp->cover_image));
            }

            // Store new image in public directory
            $imageName = time().'.'.$request->cover_image->extension();
            $request->cover_image->move(public_path('assets/images/support_and_helps'), $imageName);
            $imagePath = 'assets/images/support_and_helps/'.$imageName;
            $supportAndHelp->cover_image = $imagePath;
        }

        $supportAndHelp->is_active = $request->has('is_active');
        $supportAndHelp->save();

        $supportAndHelp->translations()->where('locale', 'en')->update([
            'title' => $request->title_en,
            'description' => $request->description_en,
        ]);

        $supportAndHelp->translations()->where('locale', 'ar')->update([
            'title' => $request->title_ar,
            'description' => $request->description_ar,
        ]);

        return redirect()->route('support-and-helps.index')->with('success', 'SupportAndHelp updated successfully.');
    }

    public function destroy(SupportAndHelp $supportAndHelp)
    {
         // Delete image
         if (file_exists(public_path($supportAndHelp->cover_image))) {
            unlink(public_path($supportAndHelp->cover_image));
        }
        $supportAndHelp->delete();
        return redirect()->route('support-and-helps.index')->with('success', 'SupportAndHelp deleted successfully.');
    }

    // API Methods
    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en'); // Default to English

        $supportAndHelps = SupportAndHelp::where('is_active', true)
            ->with(['translations' => function($query) use ($lang) {
                $query->where('locale', $lang);
            }])
            ->get()
            ->map(function($supportAndHelp) use ($lang) {
                $translation = $supportAndHelp->translation($lang);

                return [
                    'cover_image' => url($supportAndHelp->cover_image),
                    'title' => $translation ? $translation->title : 'No translation available',
                    'description' => $translation ? $translation->description : 'No translation available',
                    'order' => $supportAndHelp->order
                ];
            });

        return response()->json($supportAndHelps);
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'exists:support_and_helps,id',
        ]);

        foreach ($request->items as $index => $itemId) {
            SupportAndHelp::where('id', $itemId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }
}
