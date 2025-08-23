<?php

namespace App\Http\Controllers;

use App\Models\CompleteService;
use Illuminate\Http\Request;

class CompleteServiceController extends Controller
{
    public function index()
    {
        $services = CompleteService::orderBy('order')->get();
        return view('pages.services.index', compact('services'));
    }

    public function create()
    {
        // Get the next order number
        $nextOrder = CompleteService::max('order') + 1;
        return view('pages.services.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:active,inactive',
            'order' => 'sometimes|integer',
        ]);

        $imageName = time().'.'.$request->image->extension();
        $request->image->move(public_path('assets/images/Complete_services'), $imageName);
        $imagePath = 'assets/images/Complete_services/'.$imageName;

        CompleteService::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'image_path' => $imagePath,
            'status' => $request->status,
            'order' => $request->order ?? (CompleteService::max('order') + 1),
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

    public function reorder(Request $request)
    {
        $request->validate([
            'services' => 'required|array',
            'services.*' => 'exists:complete_services,id',
        ]);

        foreach ($request->services as $index => $serviceId) {
            CompleteService::where('id', $serviceId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
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
                'order'
            ])
            ->get()
            ->map(function ($service) {
                return [
                    'title' => $service->title,
                    'image_url' => $service->image_path ? asset($service->image_path) : null,
                    'order' => $service->order,
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

        // Reorder remaining services
        CompleteService::ordered()->get()->each(function($service, $index) {
            $service->update(['order' => $index + 1]);
        });

        return redirect()->route('complete_services.index')->with('success', 'Service deleted successfully.');
    }
}


