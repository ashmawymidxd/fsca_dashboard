<?php
namespace App\Http\Controllers;

use App\Models\TechCreativity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class TechCreativityController extends Controller
{
    public function index()
    {
        $items = TechCreativity::orderBy('order')->get();
        return view('pages.tech-creativity.index', compact('items'));
    }

    public function create()
    {
        $nextOrder = (int) TechCreativity::max('order') + 1;
        return view('pages.tech-creativity.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:banner,category',
            'image_direction' => 'required|in:left,right,center',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $imageName = null;
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/tech_creativity'), $imageName);
        }

        $nextOrder = (int) TechCreativity::max('order') + 1;

        TechCreativity::create([
            'type' => $request->type,
            'image_direction' => $request->image_direction,
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => $imageName ? 'assets/images/tech_creativity/' . $imageName : null,
            'order' => $nextOrder,
        ]);

        return redirect()->route('tech-creativity.index')->with('success', 'Item created successfully.');
    }

    public function show(TechCreativity $tech_creativity)
    {
        return view('pages.tech-creativity.show', compact('tech_creativity'));
    }

    public function edit(TechCreativity $tech_creativity)
    {
        return view('pages.tech-creativity.edit', ['item' => $tech_creativity]);
    }

    public function update(Request $request, TechCreativity $tech_creativity)
    {
        $request->validate([
            'type' => 'required|in:banner,category',
            'image_direction' => 'required|in:left,right,center',
            'title_en' => 'nullable|string|max:255',
            'title_ar' => 'nullable|string|max:255',
            'description_en' => 'nullable|string',
            'description_ar' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);

        $data = $request->only([
            'type','image_direction','title_en','title_ar','description_en','description_ar'
        ]);

        if ($request->hasFile('cover_image')) {
            if ($tech_creativity->cover_image && File::exists(public_path($tech_creativity->cover_image))) {
                File::delete(public_path($tech_creativity->cover_image));
            }
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/tech_creativity'), $imageName);
            $data['cover_image'] = 'assets/images/tech_creativity/' . $imageName;
        }

        $tech_creativity->update($data);

        return redirect()->route('tech-creativity.index')->with('success', 'Item updated successfully.');
    }

    public function destroy(TechCreativity $tech_creativity)
    {
        if ($tech_creativity->cover_image && File::exists(public_path($tech_creativity->cover_image))) {
            File::delete(public_path($tech_creativity->cover_image));
        }

        $tech_creativity->delete();
        $this->reorderAll();

        return redirect()->route('tech-creativity.index')->with('success', 'Item deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'items' => 'required|array',
            'items.*' => 'exists:tech_creativities,id',
        ]);

        foreach ($request->items as $index => $id) {
            TechCreativity::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function reorderAll(): void
    {
        $all = TechCreativity::orderBy('order')->get();
        foreach ($all as $i => $item) {
            $item->update(['order' => $i + 1]);
        }
    }

    // API: /api/tech-creativity?lang=en&type=banner
    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en');
        $type = $request->query('type'); // optional filter

        if (!in_array($lang, ['en','ar'])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid language parameter. Use "en" or "ar".',
            ], 400);
        }

        $q = TechCreativity::orderBy('order');
        if ($type && in_array($type, ['banner','category'])) {
            $q->where('type', $type);
        }

        $items = $q->get([
            'type',
            'image_direction',
            "title_$lang as title",
            "description_$lang as description",
            'cover_image',
            'order',
        ])->map(function ($i) {
            return [
                'type' => $i->type,
                'image_direction' => $i->image_direction,
                'title' => $i->title,
                'description' => $i->description,
                'cover_image_url' => $i->cover_image ? asset($i->cover_image) : null,
                'order' => $i->order,
            ];
        });

        return response()->json($items);
    }
}
