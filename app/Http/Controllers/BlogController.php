<?php
namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::orderBy('order')->get();
        return view('pages.blogs.index', compact('blogs'));
    }

    public function create()
    {
        $nextOrder = Blog::max('order') + 1;
        return view('pages.blogs.create', compact('nextOrder'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'status' => 'required|in:active,inactive',
            'cover_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_direction' => 'required|in:left,right',
        ]);

        $imageName = null;
        if ($request->hasFile('cover_image')) {
            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/blogs'), $imageName);
        }

        $nextOrder = Blog::max('order') + 1;

        Blog::create([
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'cover_image' => 'assets/images/blogs/' . $imageName,
            'image_direction' => $request->image_direction,
            'status' => $request->status,
            'order' => $nextOrder,
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        return view('pages.blogs.edit', compact('blog'));
    }

    public function show(Blog $blog)
    {
        return view('pages.blogs.show', compact('blog'));
    }

    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title_en' => 'required|string|max:255',
            'title_ar' => 'required|string|max:255',
            'description_en' => 'required|string',
            'description_ar' => 'required|string',
            'status' => 'required|in:active,inactive',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'image_direction' => 'required|in:left,right',
        ]);

        $data = [
            'title_en' => $request->title_en,
            'title_ar' => $request->title_ar,
            'description_en' => $request->description_en,
            'description_ar' => $request->description_ar,
            'image_direction' => $request->image_direction,
            'status' => $request->status,
        ];

        if ($request->hasFile('cover_image')) {
            if (File::exists(public_path($blog->cover_image))) {
                File::delete(public_path($blog->cover_image));
            }

            $image = $request->file('cover_image');
            $imageName = Str::random(20) . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('assets/images/blogs'), $imageName);
            $data['cover_image'] = 'assets/images/blogs/' . $imageName;
        }

        $blog->update($data);

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if (File::exists(public_path($blog->cover_image))) {
            File::delete(public_path($blog->cover_image));
        }

        $blog->delete();
        $this->reorderBlogs();

        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

    public function reorder(Request $request)
    {
        $request->validate([
            'blogs' => 'required|array',
            'blogs.*' => 'exists:blogs,id',
        ]);

        foreach ($request->blogs as $index => $blogId) {
            Blog::where('id', $blogId)->update(['order' => $index + 1]);
        }

        return response()->json(['success' => true]);
    }

    private function reorderBlogs()
    {
        $blogs = Blog::orderBy('order')->get();
        foreach ($blogs as $index => $blog) {
            $blog->update(['order' => $index + 1]);
        }
    }

    public function apiIndex(Request $request)
    {
        $lang = $request->query('lang', 'en');
        if (!in_array($lang, ['en','ar'])) {
            return response()->json(['success'=>false,'message'=>'Invalid language parameter. Use "en" or "ar".'],400);
        }

        return response()->json(
            Blog::where('status', 'active')->orderBy('order')->get([
                "title_$lang as title",
                "description_$lang as description",
                'cover_image',
                'image_direction',
                'order',
            ])->map(function($blog){
                return [
                    'title'=>$blog->title,
                    'description'=>$blog->description,
                    'cover_image_url'=>$blog->cover_image ? asset($blog->cover_image) : null,
                    'image_direction'=>$blog->image_direction,
                    'order'=>$blog->order,
                ];
            })
        );
    }
}
