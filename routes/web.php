+<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PostController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Welcome posts
Route::get('/', [PostController::class, 'showWelcome']);

// Define a route that returns a view for creating a post to the user
// Route – Used to define routes that respond to HTTP requests in Laravel.
// :: Scope Resolution Operator – Used to access static methods or constants in a class (e.g., Route::get()).
// '/posts/create' – The URL path or endpoint that triggers the route.
// [PostController::class, 'create'] – An array that tells Laravel to use the PostController class and call its create method when this route is accessed.
Route::get('/posts/create', [PostController::class, 'create']);

// Handle form submission sent to /posts using POST method
Route::post('/posts', [PostController::class, 'store']);

// Define a route that returns a view containing all posts
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

// Define a route that returns a view containing only the authenticated user's posts.
Route::get('/myPosts', [PostController::class, 'myPosts']);

// Define a route that returns a view displaying a specific post based on the matching URL parameter ID.
// {} - used to capture values from the URL.
Route::get('/posts/{id}', [PostController::class, 'show']);

// Define a route that edit a form.
Route::get('/posts/{id}/edit', [PostController::class, 'edit']);

// Define a route that will update an existing post with a matching URL parameter ID using the PUT method.
Route::put('/posts/{id}', [PostController::class, 'update']);

// Define a route that will delete a post with the matching URL parameter ID
// Route::delete('/posts/{id}', [PostController::class, 'destroy']);

// Define a route that will archive a post
Route::delete('/posts/{id}', [PostController::class, 'archive'])->name('posts.archive');

// Defines a route for liking a post. It handles PUT requests to /posts/{id}/like and invokes the 'like' method in the PostController.
Route::put('/posts/{id}/like', [PostController::class, 'like']);

// Defines a route for commenting on a post
Route::post('/posts/{post}/comments', [PostController::class, 'storeComment'])->name('postComments.store');


