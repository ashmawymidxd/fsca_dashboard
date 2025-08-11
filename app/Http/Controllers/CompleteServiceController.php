<?php

namespace App\Http\Controllers;

use App\Models\CompleteService;
use Illuminate\Http\Request;

class CompleteServiceController extends Controller
{
    public function index()
    {
        $services = CompleteService::latest()->get();
        return view('pages.services.index', compact('services'));
    }

    public function create()
    {
        return view('pages.services.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('assets/images/Complete_services'), $imageName);
        $imagePath = 'assets/images/Complete_services/'.$imageName;

        CompleteService::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'image_path' => $imagePath,
            'status' => $request->status,
        ]);

        return redirect()->route('complete_services.index')->with('success', 'Service created successfully.');
    }

    public function show(CompleteService $completeService)
    {
        return view('pages.services.show', compact('completeService'));
    }

    public function edit(CompleteService $completeService)
    {
        return view('pages.services.edit', compact('completeService'));
    }

    public function update(Request $request, CompleteService $completeService)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'status' => $request->status,
        ];

        if ($request->hasFile('image')) {
            // Delete old image
            if (file_exists(public_path($completeService->image_path))) {
                unlink(public_path($completeService->image_path));
            }

            // Store new image in public directory
            $imageName = time().'.'.$request->image->extension();
            $request->image->move(public_path('assets/images/Complete_services'), $imageName);
            $imagePath = 'assets/images/Complete_services/'.$imageName;
            $data['image_path'] = $imagePath;
        }

        $completeService->update($data);

        return redirect()->route('complete_services.index')->with('success', 'Service updated successfully.');
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

        $services = CompleteService::where('status', 'active')
            ->select([
                "title_$lang as title",
                'image_path',
            ])
            ->get()
            ->map(function ($service) {
                return [
                    'title' => $service->title,
                    'image_url' => $service->image_path ? asset($service->image_path) : null,
                ];
            });

        return response()->json($services);
    }

    public function destroy(CompleteService $completeService)
    {
        // Delete image
        if (file_exists(public_path($completeService->image_path))) {
            unlink(public_path($completeService->image_path));
        }

        $completeService->delete();

        return redirect()->route('complete_services.index')->with('success', 'Service deleted successfully.');
    }
}
