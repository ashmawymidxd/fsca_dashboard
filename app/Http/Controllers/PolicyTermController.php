<?php
namespace App\Http\Controllers;

use App\Models\PolicyTerm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class PolicyTermController extends Controller
{
    public function index()
    {
        $policyTerms = PolicyTerm::orderBy('order')->get();
        return view('pages.policy_terms.index', compact('policyTerms'));
    }

    public function create()
    {
        $nextOrder = PolicyTerm::max('order') + 1;
        return view('pages.policy_terms.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'type' => 'required|in:banner,category',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imageName = null;
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/policy_terms'), $imageName);
        }

        $nextOrder = PolicyTerm::max('order') + 1;

        PolicyTerm::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'type' => $request->type,
            'cover_image' => $imageName ? 'assets/images/policy_terms/' . $imageName : null,
            'order' => $nextOrder,
        ]);

        return redirect()->route('policy-terms.index')->with('success', 'Policy/Term created successfully.');
    }

    public function edit(PolicyTerm $policyTerm)
    {
        return view('pages.policy_terms.edit', compact('policyTerm'));
    }

    public function show(PolicyTerm $policyTerm)
    {
        return view('pages.policy_terms.show', compact('policyTerm'));
    }

    public function update(Request $request, PolicyTerm $policyTerm)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'type' => 'required|in:banner,category',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->only([
            'title_en', 'title_ar', 'description_en', 'description_ar', 'type'
        ]);

        if ($request->hasFile('cover_image')) {
            if ($policyTerm->cover_image && File::exists(public_path($policyTerm->cover_image))) {
                File::delete(public_path($policyTerm->cover_image));
            }
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/policy_terms'), $imageName);
            $data['cover_image'] = 'assets/images/policy_terms/' . $imageName;
        }

        $policyTerm->update($data);

        return redirect()->route('policy-terms.index')->with('success', 'Policy/Term updated successfully.');
    }

    public function destroy(PolicyTerm $policyTerm)
    {
        if ($policyTerm->cover_image && File::exists(public_path($policyTerm->cover_image))) {
            File::delete(public_path($policyTerm->cover_image));
        }

        $policyTerm->delete();
        $this->reorderPolicyTerms();

        return redirect()->route('policy-terms.index')->with('success', 'Policy/Term deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'policy_terms' => 'required|array',
            'policy_terms.*' => 'exists:policy_terms,id',
        ]);

        foreach ($request->policy_terms as $index => $id) {
            PolicyTerm::where('id', $id)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function reorderPolicyTerms()
    {
        $policyTerms = PolicyTerm::orderBy('order')->get();
        foreach ($policyTerms as $index => $policyTerm) {
            $policyTerm->update(['order' => $index + 1]);
        }
    }

    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en');
        $type = $request->query('type'); // filter by banner/category if needed

        if (!in_array($lang, ['en', 'ar'])) {
            return response()->json(['success' => false, 'message' => 'Invalid language.'], 400);
        }

        $query = PolicyTerm::orderBy('order');
        if ($type) $query->where('type', $type);

        return response()->json(
            $query->get([
                "title_$lang as title",
                "description_$lang as description",
                'type',
                'cover_image',
                'order',
            ])->map(function ($item) {
                return [
                    'title' => $item->title,
                    'description' => $item->description,
                    'type' => $item->type,
                    'cover_image_url' => $item->cover_image ? asset($item->cover_image) : null,
                    'order' => $item->order,
                ];
            })
        );
    }
}
