<?php

namespace App\Http\Controllers;

use App\Models\CommonUnit;
use Illuminate\Http\Request;

class CommonUnitController extends Controller
{
    public function index()
    {
        $commonUnits = CommonUnit::latest()->get(); // Added latest() for ordering
        return view('pages.common-units.index', compact('commonUnits'));
    }

    public function create()
    {
        return view('pages.common-units.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'page_name' => 'required|string|unique:common_units,page_name',
            'description_ar' => 'required|string',
        ]);

        CommonUnit::create($validated);

        return redirect()->route('common-units.index')
            ->with('success', 'Common Unit created successfully.');
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
        $validated = $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'page_name' => 'required|string|unique:common_units,page_name,'.$commonUnit->id,
            'description_ar' => 'required|string',
        ]);

        $commonUnit->update($validated);

        return redirect()->route('common-units.index')
            ->with('success', 'Common Unit updated successfully.');
    }

    public function destroy(CommonUnit $commonUnit)
    {
        $commonUnit->delete();

        return redirect()->route('common-units.index')
            ->with('success', 'Common Unit deleted successfully.');
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

        $commonUnits = CommonUnit::select([
            "title_$lang as title",
            "description_$lang as description",
            'page_name'
        ])->get();

        return response()->json($commonUnits);
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

        $commonUnit = CommonUnit::where('page_name', $page_name)->firstOrFail();

        return response()->json([
            'page_name' => $commonUnit->page_name,
            'title' => $commonUnit["title_$lang"],
            'description' => $commonUnit["description_$lang"],
        ]);
    }
}
