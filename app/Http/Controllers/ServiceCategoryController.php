<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index(Service $service)
    {
        $categories = $service->categories;
        return view('services.categories.index', compact('service', 'categories'));
    }

    public function create(Service $service)
    {
        return view('services.categories.create', compact('service'));
    }

    public function store(Request $request, Service $service)
    {
        $request->validate([
            'type' => 'required|in:category,banner',
            'main_header_en' => 'required|string|max:255',
            'main_header_ar' => 'required|string|max:255',
            'sub_header_en' => 'required|string|max:255',
            'sub_header_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'focus_en' => 'nullable|string|max:255',
            'focus_ar' => 'nullable|string|max:255',
            'button_text_en' => 'nullable|string|max:255',
            'button_text_ar' => 'nullable|string|max:255',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $this->uploadImage($request->file('cover_image'), 'service_categories');

        ServiceCategory::create([
            'type' => $request->type,
            'main_header_en' => $request->main_header_en,
            'main_header_ar' => $request->main_header_ar,
            'sub_header_en' => $request->sub_header_en,
            'sub_header_ar' => $request->sub_header_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'focus_en' => $request->focus_en,
            'focus_ar' => $request->focus_ar,
            'button_text_en' => $request->button_text_en,
            'button_text_ar' => $request->button_text_ar,
            'slug_en' => Str::slug($request->main_header_en),
            'slug_ar' => Str::slug($request->main_header_ar),
            'cover_image' => $imagePath,
            'service_id' => $service->id,
        ]);

        return redirect()->route('services.categories.index', $service)->with('success', 'Category created successfully.');
    }

    public function show(Service $service, ServiceCategory $category)
    {
        return view('services.categories.show', compact('service', 'category'));
    }

    public function edit(Service $service, ServiceCategory $category)
    {
        return view('services.categories.edit', compact('service', 'category'));
    }

    public function update(Request $request, Service $service, ServiceCategory $category)
    {
        $request->validate([
            'type' => 'required|in:category,banner',
            'main_header_en' => 'required|string|max:255',
            'main_header_ar' => 'required|string|max:255',
            'sub_header_en' => 'required|string|max:255',
            'sub_header_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'focus_en' => 'nullable|string|max:255',
            'focus_ar' => 'nullable|string|max:255',
            'button_text_en' => 'nullable|string|max:255',
            'button_text_ar' => 'nullable|string|max:255',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'type' => $request->type,
            'main_header_en' => $request->main_header_en,
            'main_header_ar' => $request->main_header_ar,
            'sub_header_en' => $request->sub_header_en,
            'sub_header_ar' => $request->sub_header_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'focus_en' => $request->focus_en,
            'focus_ar' => $request->focus_ar,
            'button_text_en'=>$request->button_text_en,
            'button_text_ar'=>$request->button_text_ar,
            'slug_en' => Str::slug($request->main_header_en),
            'slug_ar' => Str::slug($request->main_header_ar),
        ];

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if (file_exists(public_path($category->cover_image))) {
                unlink(public_path($category->cover_image));
            }
            $data['cover_image'] = $this->uploadImage($request->file('cover_image'), 'service_categories');
        }

        $category->update($data);

        return redirect()->route('services.categories.index', $service)->with('success', 'Category updated successfully.');
    }

    public function destroy(Service $service, ServiceCategory $category)
    {
        // Delete cover image
        if (file_exists(public_path($category->cover_image))) {
            unlink(public_path($category->cover_image));
        }

        $category->delete();

        return redirect()->route('services.categories.index', $service)->with('success', 'Category deleted successfully.');
    }

    private function uploadImage($image, $folder)
    {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $path = 'uploads/' . $folder . '/';
        $image->move(public_path($path), $imageName);
        return $path . $imageName;
    }
}
