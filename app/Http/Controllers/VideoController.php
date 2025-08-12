<?php

namespace App\Http\Controllers;

use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class VideoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $videos = Video::latest()->paginate(10);
        return view('pages.videos.index', compact('videos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.videos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'required|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:50000'
        ]);

        $videoFile = $request->file('video');
        $fileName = Str::random(20) . '.' . $videoFile->getClientOriginalExtension();
        $filePath = 'assets/videos/' . $fileName;

        // Create directory if it doesn't exist
        if (!File::exists(public_path('assets/videos'))) {
            File::makeDirectory(public_path('assets/videos'), 0755, true);
        }

        // Move video to public directory
        $videoFile->move(public_path('assets/videos'), $fileName);

        Video::create([
            'title' => $request->title,
            'description' => $request->description,
            'path' => $filePath
        ]);

        return redirect()->route('videos.index')->with('success', 'Video uploaded successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Video $video)
    {
        return view('pages.videos.show', compact('video'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Video $video)
    {
        return view('pages.videos.edit', compact('video'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Video $video)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv|max:50000'
        ]);

        if ($request->hasFile('video')) {
            // Delete old video
            if (File::exists(public_path($video->path))) {
                File::delete(public_path($video->path));
            }

            // Upload new video
            $videoFile = $request->file('video');
            $fileName = Str::random(20) . '.' . $videoFile->getClientOriginalExtension();
            $filePath = 'assets/videos/' . $fileName;
            $videoFile->move(public_path('assets/videos'), $fileName);

            $video->path = $filePath;
        }

        $video->title = $request->title;
        $video->description = $request->description;
        $video->save();

        return redirect()->route('videos.index')->with('success', 'Video updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Video $video)
    {
        if (File::exists(public_path($video->path))) {
            File::delete(public_path($video->path));
        }

        $video->delete();

        return redirect()->route('videos.index')->with('success', 'Video deleted successfully.');
    }

    public function apiIndex()
    {
        $videos = Video::latest()->get()->map(function ($video) {
            return [
                'path' => asset($video->path), // Complete URL to the video
            ];
        });

        return response()->json([
            'success' => true,
            'data' => $videos,
            'message' => 'Videos retrieved successfully.'
        ]);
    }
}
