<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use PHPUnit\Framework\Attributes\PostCondition;

class PostController extends Controller
{
    

    public function posts()
    {
        $categories= Category:: all();
        $posts = Post::where('status', 'published')
            ->with('comments')
            ->orderBy('id', 'desc')
            ->paginate(10);
            
        return response()
            ->json([
                'categories' => $categories,
                'posts' => $posts
            ]);
    }

    public function postDetail(Request $request)
    {
        $postDetail = Post::getPostBySlug($request->slug);
        return response()
            ->json(['postDetail' => $postDetail]);

    }
}
