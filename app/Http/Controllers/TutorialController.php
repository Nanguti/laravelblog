<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tutorial;
use Illuminate\Http\Request;

class TutorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tutorials = Tutorial::paginate(20);
        $categories = Category::all();
        return response()->json([
            'categories' => $categories,
            'tutorials'=>$tutorials
        ]);
    }

    public function getTutorialsByCategory(Request $request){
        $results = Category::getTutorialsByCategory($request->slug);
        return response()->json([
            'results' => $results,
        ]);
    }
}
