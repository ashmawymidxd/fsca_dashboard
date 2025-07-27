<?php

// app/Http/Controllers/ProjectController.php
namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('translations')->get();
        return view('pages.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('pages.projects.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        // Store image in public directory
        $imageName = time().'.'.$request->cover_image->extension();
        $request->cover_image->move(public_path('assets/images/projects'), $imageName);
        $imagePath = 'assets/images/projects/'.$imageName;

        $project = Project::create([
            'cover_image' => $imagePath,
            'is_active' => $request->has('is_active'),
        ]);
        // Create translations
        $project->translations()->createMany([
            [
                'locale' => 'en',
                'title' => $request->title_en,
                'description' => $request->description_en,
            ],
            [
                'locale' => 'ar',
                'title' => $request->title_ar,
                'description' => $request->description_ar,
            ],
        ]);

        return redirect()->route('projects.index')->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('pages.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('pages.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $request->validate([
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
        ]);

        if ($request->hasFile('cover_image')) {
            // Delete old image
            if (file_exists(public_path($project->cover_image))) {
                unlink(public_path($project->cover_image));
            }

            // Store new image in public directory
            $imageName = time().'.'.$request->cover_image->extension();
            $request->cover_image->move(public_path('assets/images/projects'), $imageName);
            $imagePath = 'assets/images/projects/'.$imageName;
            $project->cover_image = $imagePath;
        }

        $project->is_active = $request->has('is_active');
        $project->save();

        // Update translations
        $project->translations()->where('locale', 'en')->update([
            'title' => $request->title_en,
            'description' => $request->description_en,
        ]);

        $project->translations()->where('locale', 'ar')->update([
            'title' => $request->title_ar,
            'description' => $request->description_ar,
        ]);

        return redirect()->route('projects.index')->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        // Delete image
         if (file_exists(public_path($project->cover_image))) {
            unlink(public_path($project->cover_image));
        }

        $project->delete();
        return redirect()->route('projects.index')->with('success', 'Project deleted successfully.');
    }

    // API Methods
    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en'); // Default to English

        $projects = Project::where('is_active', true)
            ->with(['translations' => function($query) use ($lang) {
                $query->where('locale', $lang);
            }])
            ->get()
            ->map(function($project) use ($lang) {
                $translation = $project->translation($lang);

                return [
                    'cover_image' => url($project->cover_image),
                    'title' => $translation ? $translation->title : 'No translation available',
                    'description' => $translation ? $translation->description : 'No translation available',
                ];
            });

        return response()->json($projects);
    }
}
