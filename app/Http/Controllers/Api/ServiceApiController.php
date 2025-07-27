<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceApiController extends Controller
{
    public function index(Request $request)
    {
        $lang = $request->query('lang', 'en');

        $services = Service::get([
            'id',
            "title_$lang as title",
            "slug_en as slug"
        ]);

        return response()->json($services);
    }

    public function show(Request $request, $slug)
    {
        $lang = $request->query('lang', 'en');

        $service = Service::with(['categories' => function($query) use ($lang) {
            $query->select(
                'id', 'service_id', 'type', 'cover_image',
                "main_header_$lang as main_header",
                "sub_header_$lang as sub_header",
                "description_$lang as description",
                "focus_$lang as focus",
                "button_text_$lang as button_text"
            );
        }])->where('slug_en', $slug)
        ->first([
            'id', 'cover_image',
            "title_$lang as title",
            "description_$lang as description",
        ]);

        if (!$service) {
            return response()->json(['message' => 'Service not found'], 404);
        }

        // Add full URLs to images
        $service->cover_image = url($service->cover_image);
        $service->categories->transform(function($category) {
            $category->cover_image = url($category->cover_image);
            return $category;
        });

        // Calculate metadata
        $categoryTypes = $service->categories->groupBy('type')->map->count();
        $totalCategories = $service->categories->count();

        // Prepare the response with metadata
        $response = [
            'service' => $service,
            'metadata' => [
                'total_categories' => $totalCategories,
                'category_types' => $categoryTypes,
                'has_categories' => $totalCategories > 0,
            ]
        ];

        return response()->json($response);
    }
}
