<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\PublicPostController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\TagController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Homepage - shows blogs for everyone
Route::get('/', [PublicPostController::class, 'index'])->name('home');
Route::get('/blog', [PublicPostController::class, 'index'])->name('blog.index');
Route::get('/blog/{post}', [PublicPostController::class, 'show'])->name('blog.show');

// Public can like and comment
Route::post('/blog/{post}/like', [LikeController::class, 'toggle'])->name('like.toggle');
Route::post('/blog/{post}/comments', [CommentController::class, 'store'])->name('comments.store');

/*
|--------------------------------------------------------------------------
| Guest Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister']);
    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

/*
|--------------------------------------------------------------------------
| Authenticated Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PostController::class, 'index'])->name('dashboard');

    Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('/posts/{post}', [PostController::class, 'show'])->name('posts.show');
    Route::get('/posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

    // Categories management
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Tags management
    Route::get('/tags', [TagController::class, 'index'])->name('tags.index');
    Route::get('/tags/create', [TagController::class, 'create'])->name('tags.create');
    Route::post('/tags', [TagController::class, 'store'])->name('tags.store');
    Route::get('/tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit');
    Route::put('/tags/{tag}', [TagController::class, 'update'])->name('tags.update');
    Route::delete('/tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy');

    Route::get('/settings', [UserController::class, 'edit'])->name('settings');
    Route::post('/settings', [UserController::class, 'update']);
    Route::post('/settings/remove-profile-picture', [UserController::class, 'removeProfilePicture'])->name('remove-profile-picture');

    Route::post('/logout', [AuthController::class, 'logout']);
});
