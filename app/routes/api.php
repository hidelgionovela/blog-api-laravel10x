<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CommentsController;
use App\Http\Controllers\Api\LikesController;
use App\Http\Controllers\Api\PostsController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// User Routes
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/logout', [AuthController::class, 'logout']);


// Post Routes
Route::post('posts/create', [PostsController::class, 'store'])->middleware('jwtAuth');
Route::post('posts/delete', [PostsController::class, 'destroy'])->middleware('jwtAuth');
Route::post('posts/update', [PostsController::class, 'update'])->middleware('jwtAuth');
Route::get('posts', [PostsController::class, 'index'])->middleware('jwtAuth');

//comments Routes
Route::post('comments/create', [CommentsController::class, 'store'])->middleware('jwtAuth');
Route::post('comments/delete', [CommentsController::class, 'destroy'])->middleware('jwtAuth');
Route::post('comments/update', [CommentsController::class, 'update'])->middleware('jwtAuth');
Route::post('posts/comments', [CommentsController::class, 'comment'])->middleware('jwtAuth');

//Likes Routes
Route::post('posts/like', [LikesController::class, 'like'])->middleware('jwtAuth');



