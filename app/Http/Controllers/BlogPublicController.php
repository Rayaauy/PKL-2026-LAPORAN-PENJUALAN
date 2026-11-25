<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;

class BlogPublicController extends Controller
{
    public function index()
    {
        $posts = BlogPost::published()
            ->latest('published_at')
            ->paginate(9);

        $seo = [
            'title'       => 'Blog & Tips UMKM — UMKM Sales',
            'description' => 'Artikel, tips, dan panduan pencatatan penjualan untuk pelaku UMKM Indonesia.',
            'canonical'   => url('/blog'),
        ];

        return view('blog.index', compact('posts', 'seo'));
    }

    public function show(string $slug)
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $related = BlogPost::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('blog.show', compact('post', 'related'));
    }
}
