<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

use App\Models\Post;

use App\Models\PostLike;

use App\Models\PostComment;

use Illuminate\Http\Request;

class PostController extends Controller
{
    // Action to return a view containing a form for creating a blog post.
    public function create() {
        // The view() method is used to render a specific view in the browser.
        // posts.create refers to the create.blade.php file located in the resources/views/posts folder.
        // Blade (.blade.php) is Laravel's templating engine. It allows you to embed PHP code in your HTML and provides features like template inheritance, conditional statements, loops, and more.
        return view('posts.create');
    }

    // Action to store a new blog post in the database
    // Request - Laravel's blueprint for handling incoming data from the browser.
    // $request - holds the actual data sent from the user
    public function store(Request $request) {

        if(Auth::user()){
            
            // Instantiate a new Post object from the Post model
            $post = new Post;
            // Define the properties of the $post object using the received form data
            $post->title = $request->input('title');
            $post->content = $request->input('content');
            // Get the ID of the authenticated user and set it as the foreign key user_id of the new post
            $post->user_id = (Auth::user()->id);

            $post->save();

            return redirect('/posts');
        } else {
            return redirect('login');
        }
    }

    // Action that returns a view displaying all blog posts
    public function index()
    {
        // all() - fetches all rows from the table and returns them as a collection of Post objects.
       $posts = Post::where('isActive', true)->get();
        // with() is a method used to pass data to a Blade view.
        // posts - name of the variable you’ll use in the Blade view.
        // $posts - actual data
        return view('posts.index')->with('posts', $posts);
    }

       // PostController.php
    public function showWelcome()
    {
    $posts = Post::with('author')
             ->where('isActive', true)
             ->inRandomOrder()
             ->limit(3)
             ->get();

    return view('welcome', ['posts' => $posts]);
    }

    // Action for showing only the posts authored by the authenticated user
    public function myPosts() {
        // Check if the user is authenticated (logged in)
        // Auth::user() is used to retrieve the information of the currently authenticated user
        if(Auth::user()){
            // Get all posts that belong to the currently authenticated user
            $posts = Auth::user()->posts;
            // Return the 'posts.index' view and pass the user's posts to it
            return view('posts.index')->with('posts', $posts);  
        }else{
            return redirect('/login');
        }
    }

    // Action that returns a view showing a specific post by using the URL parameter $id to query the database for the entry to be displayed
    public function show($id)
    {
        // Find the post in the database using the given ID
        $post = Post::find($id);
        // Return the 'posts.show' view and pass the retrieved post to it
        return view('posts.show')->with('post', $post);
    }

    // Edit
    public function edit($id) {
        // Find the post in the database using the provided ID
        $post = Post::find($id);

        // Return the 'posts.edit' view and pass the post data to it for editing
        return view('posts.edit')->with('post', $post);
    }

    // Action for updating an existing post with a matching URL parameter ID
    public function update(Request $request, $id){
      // Find the post by its ID
      $post = Post::find($id);
      // Check if the authenticated user's ID matches the post's user_id
      if(Auth::user()->id == $post->user_id){
          $post->title = $request->input('title');
          $post->content = $request->input('content');
          // Save the updated post to the database
          $post->save();  
      }
      // Redirect to the posts page after updating
      return redirect('/posts');
  }

  // Action for deleting a post with the matching URL parameter ID
    public function destroy($id){
        // Check if the post exists
        $post = Post::find($id);
        // Check if the authenticated user's ID matches the post's user_id
        if(Auth::user()->id == $post->user_id){
            // Delete the post from the database
            $post->delete();    
        }
        return redirect('/posts');
    }

    // Action for archiving a post instead of deleting it 
    public function archive($id) {
    $post = Post::findOrFail($id);
    $post->isActive = false;
    $post->save();

    return redirect()->route('posts.index')->with('status', 'Post archived successfully.');
    }

    // Toggle like/unlike action for a post by an authenticated user
    public function like($id) {
        // Find the post using its ID
        $post = Post::find($id);

        // Get the currently authenticated user's ID
        $user_id = Auth::user()->id;

        // Prevent users from liking their own post
        if($post->user_id != $user_id){
            
            // Check if the user already liked the post
            if($post->likes->contains("user_id", $user_id)){
                // If already liked, remove the like (unlike)
                PostLike::where('post_id', $post->id) // Filter the post_likes table by the post's id
                        ->where('user_id', $user_id) // And by the currently logged-in user's id
                        ->delete(); // Delete the matching record (unlike the post)
            } else {
                // If not yet liked, add a new like
                $postLike = new PostLike;
                $postLike->post_id = $post->id; 
                $postLike->user_id = $user_id; 

                // Save the like to the database
                $postLike->save();
            }

            // Redirect back to the post detail page
            return redirect("/posts/$id");
        }
    }
   
        public function storeComment(Request $request, Post $post)
            {
            $request->validate(['content' => 'required']);

            $post->postComments()->create([
                'content' => $request->content,
                'user_id' => auth()->id(),
            ]);

            return back()->with('success', 'Comment added successfully!');
            }
    

}