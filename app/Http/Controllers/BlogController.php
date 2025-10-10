<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\BlogCategory;
use App\Models\Tag;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $query = Blog::with(['author', 'category', 'tags'])
            ->where('status', 'published')
            ->orderByDesc('published_at');

        // Filters
        if ($request->filled('category')) {
            $query->whereHas('category', fn($q) => $q->where('slug', $request->category));
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', fn($q) => $q->where('slug', $request->tag));
        }

        if ($request->filled('date')) {
            $query->whereDate('published_at', $request->date);
        }

        $blogs = $query->paginate(4)->withQueryString();

        $categories = BlogCategory::select('id', 'name', 'slug')->get();
        $tags = Tag::select('id', 'name', 'slug')->get();

        return view('frontend.blogs.index', compact('blogs', 'categories', 'tags'));
    }

    public function show($slug)
    {
        $blog = Blog::with(['author', 'category', 'tags'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $relatedBlogs = Blog::where('id', '!=', $blog->id)
            ->where('status', 'published')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.blogs.show', compact('blog', 'relatedBlogs'));
    }

    public function category($slug)
    {
        $category = BlogCategory::where('slug', $slug)->firstOrFail();
        $blogs = $category->blogs()->where('status', 'published')->paginate(6);
        return view('frontend.blogs.category', compact('category', 'blogs'));
    }
}
