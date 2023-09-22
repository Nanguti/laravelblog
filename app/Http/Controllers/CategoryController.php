<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::where('status', 'published')->get();
        return response()->json([
            'categories' => $categories
     
        ]);
    }

    public function categoryDetail(Request $request){
        $category = Category::getCategoryBySlug($request->slug);
        return response()
            ->json(['category'=>$category]);
    }
}
