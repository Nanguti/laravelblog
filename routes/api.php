<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\JobListingController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TutorialController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// post routes
Route::get('/posts/list', [PostController::class, 'posts']);
Route::post('/post/detail', [PostController::class, 'postDetail']);

// comments
Route::post('/add/comment', [CommentController::class, 'store']);
Route::post('/update/comment', [CommentController::class, 'update']);
Route::delete('/delete/comment/{id}', [CommentController::class, 'destroy']);

// categories
Route::get('/category/list', [CategoryController::class, 'categories']);
Route::post('/category/detail', [CategoryController::class, 'categoryDetail']);

//job listing
Route::get('/import/jobs', [JobListingController::class, 'importJobs']);
Route::get('/jobs/list', [JobListingController::class, 'jobList']);
Route::post('/job/details', [JobListingController::class, 'jobDetail']);
Route::post('/search/job', [JobListingController::class, 'autocompleteSearch']);

Route::post('/contactus', [ContactController::class, 'submitForm']);

// tutorials

Route::get('/youtube-tutorials', [TutorialController::class,'index']);
Route::post('/category/tutorials', [TutorialController::class,'getTutorialsByCategory']);