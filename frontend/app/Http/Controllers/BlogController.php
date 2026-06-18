<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::latest()->get();
        return view('pages.blog', compact('blogs'));
    }

    public function show($url)
    {
        $blog = Blog::where('url', $url)->firstOrFail();
        $recent = Blog::where('url', '!=', $url)->latest()->take(4)->get();
        return view('pages.blog-single', compact('blog', 'recent'));
    }
}
