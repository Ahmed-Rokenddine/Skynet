<?php

use App\Models\post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\postController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Common Resource Routes:
// index - Show all posts
// show - Show single post
// create - Show form to create new post
// store - Store new post
// edit - Show form to edit post
// update - Update post
// destroy - Delete post  

// All posts
Route::get('/', [postController::class, 'index']);

// Show Create Form
Route::get('/posts/create', [postController::class, 'create'])->middleware('auth');

// Store post Data
Route::post('/posts', [postController::class, 'store'])->middleware('auth');

// Show Edit Form
Route::get('/posts/{post}/edit', [postController::class, 'edit'])->middleware('auth');

// Update post
Route::put('/posts/{post}', [postController::class, 'update'])->middleware('auth');

// Delete post
Route::delete('/posts/{post}', [postController::class, 'destroy'])->middleware('auth');

// Manage posts
Route::get('/posts/manage', [postController::class, 'manage'])->middleware('auth');

// Single post
Route::get('/posts/{post}', [postController::class, 'show']);

// Show Register/Create Form
Route::get('/register', [UserController::class, 'create'])->middleware('guest');

// Create New User
Route::post('/users', [UserController::class, 'store']);

// Log User Out
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth');

// Show Login Form
Route::get('/login', [UserController::class, 'login'])->name('login')->middleware('guest');

// Log In User
Route::post('/users/authenticate', [UserController::class, 'authenticate']);

// Comment
Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->middleware('auth');

//add comment
Route::post('/comments', [CommentController::class, 'store'])->name('comments.store');

//modify comment 
Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

 
//delete comment 
 Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');


