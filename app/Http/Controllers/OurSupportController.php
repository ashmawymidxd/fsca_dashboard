<?php

namespace App\Http\Controllers;

use App\Models\OurSupport;
use Illuminate\Http\Request;

class OurSupportController extends Controller
{
    public function index()
    {
        $supports = OurSupport::orderBy('order')->get();
        return view('pages.our-supports.index', compact('supports'));
    }

    public function create()
    {
        $nextOrder = OurSupport::max('order') + 1;
        return view('pages.our-supports.create', compact('nextOrder'));
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
            'sub_header_en' => 'required|string|max:255',
            'sub_header_ar' => 'required|string|max:255',
        ]);

        // Get the next order value
        $nextOrder = OurSupport::max('order') + 1;

        OurSupport::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'button_text_en' => $request->button_text_en,
            'button_text_ar' => $request->button_text_ar,
            'sub_header_en' => $request->sub_header_en,
            'sub_header_ar' => $request->sub_header_ar,
            'order' => $nextOrder,
        ]);

        return redirect()->route('our-supports.index')->with('success', 'Support created successfully.');
    }

    public function show(OurSupport $ourSupport)
    {
        return view('pages.our-supports.show', compact('ourSupport'));
    }

    public function edit(OurSupport $ourSupport)
    {
        return view('pages.our-supports.edit', compact('ourSupport'));
    }

    public function update(Request $request, OurSupport $ourSupport)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'button_text_en' => 'required|string|max:255',
            'button_text_ar' => 'required|string|max:255',
            'sub_header_en' => 'required|string|max:255',
            'sub_header_ar' => 'required|string|max:255',
        ]);

        $ourSupport->update([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'button_text_en' => $request->button_text_en,
            'button_text_ar' => $request->button_text_ar,
            'sub_header_en' => $request->sub_header_en,
            'sub_header_ar' => $request->sub_header_ar,
        ]);

        return redirect()->route('our-supports.index')->with('success', 'Support updated successfully.');
    }

    public function destroy(OurSupport $ourSupport)
    {
        $ourSupport->delete();

        // Reorder remaining supports
        $this->reorderSupports();

        return redirect()->route('our-supports.index')->with('success', 'Support deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'supports' => 'required|array',
            'supports.*' => 'exists:our_supports,id',
        ]);

        foreach ($request->supports as $index => $supportId) {
            OurSupport::where('id', $supportId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function reorderSupports()
    {
        $supports = OurSupport::orderBy('order')->get();

        foreach ($supports as $index => $support) {
            $support->update(['order' => $index + 1]);
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
            OurSupport::orderBy('order')->get([
                "title_$lang as title",
                "description_$lang as description",
                "button_text_$lang as button_text",
                "sub_header_$lang as sub_header",
                'order',
            ])
        );
    }
}
