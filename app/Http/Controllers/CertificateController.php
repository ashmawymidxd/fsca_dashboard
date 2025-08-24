<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::orderBy('order')->get();
        return view('pages.certificates.index', compact('certificates'));
    }

    public function create()
    {
        $nextOrder = Certificate::max('order') + 1;
        return view('pages.certificates.create', compact('nextOrder'));
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

        // Handle image upload
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/certificates'), $imageName);
        }

        // Get the next order value
        $nextOrder = Certificate::max('order') + 1;

        Certificate::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => 'assets/images/certificates/' . $imageName,
            'order' => $nextOrder,
        ]);

        return redirect()->route('certificates.index')->with('success', 'Certificate created successfully.');
    }

    public function show(Certificate $certificate)
    {
        return view('pages.certificates.show', compact('certificate'));
    }

    public function edit(Certificate $certificate)
    {
        return view('pages.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
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
        ];

        // Handle image update
        if ($request->hasFile('cover_image')) {
            // Delete old image
            if (File::exists(public_path($certificate->cover_image))) {
                File::delete(public_path($certificate->cover_image));
            }

            // Upload new image
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/certificates'), $imageName);
            $data['cover_image'] = 'assets/images/certificates/' . $imageName;
        }

        $certificate->update($data);

        return redirect()->route('certificates.index')->with('success', 'Certificate updated successfully.');
    }

    public function destroy(Certificate $certificate)
    {
        // Delete image
        if (File::exists(public_path($certificate->cover_image))) {
            File::delete(public_path($certificate->cover_image));
        }

        $certificate->delete();

        // Reorder remaining certificates
        $this->reorderCertificates();

        return redirect()->route('certificates.index')->with('success', 'Certificate deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'certificates' => 'required|array',
            'certificates.*' => 'exists:certificates,id',
        ]);

        foreach ($request->certificates as $index => $certificateId) {
            Certificate::where('id', $certificateId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function reorderCertificates()
    {
        $certificates = Certificate::orderBy('order')->get();

        foreach ($certificates as $index => $certificate) {
            $certificate->update(['order' => $index + 1]);
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
            Certificate::orderBy('order')->get([
                "title_$lang as title",
                "description_$lang as description",
                'cover_image',
                'order',
            ])->map(function ($certificate) {
                return [
                    'title' => $certificate->title,
                    'description' => $certificate->description,
                    'cover_image_url' => $certificate->cover_image ? asset($certificate->cover_image) : null,
                    'order' => $certificate->order,
                ];
            })
        );
    }
}
