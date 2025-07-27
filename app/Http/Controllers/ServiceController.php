<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('categories')->get();
        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
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

        $imagePath = $this->uploadImage($request->file('cover_image'), 'services');

        $service = Service::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => $imagePath,
            'slug_en' => Str::slug($request->title_en),
            'slug_ar' => Str::slug($request->title_en),
        ]);

        return redirect()->route('services.index')->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {
        return view('services.show', compact('service'));
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = [
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'slug_en' => Str::slug($request->title_en),
            'slug_ar' => Str::slug($request->title_en),
        ];

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if (file_exists(public_path($service->cover_image))) {
                unlink(public_path($service->cover_image));
            }
            $data['cover_image'] = $this->uploadImage($request->file('cover_image'), 'services');
        }

        $service->update($data);

        return redirect()->route('services.index')->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        // Delete cover image
        if (file_exists(public_path($service->cover_image))) {
            unlink(public_path($service->cover_image));
        }

        // Delete related categories and their images
        foreach ($service->categories as $category) {
            if (file_exists(public_path($category->cover_image))) {
                unlink(public_path($category->cover_image));
            }
            $category->delete();
        }

        $service->delete();

        return redirect()->route('services.index')->with('success', 'Service deleted successfully.');
    }

    private function uploadImage($image, $folder)
    {
        $imageName = time() . '_' . $image->getClientOriginalName();
        $path = 'uploads/' . $folder . '/';
        $image->move(public_path($path), $imageName);
        return $path . $imageName;
    }
};
