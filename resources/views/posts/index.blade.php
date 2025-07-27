@extends('layouts.app')

@section('content')

    {{-- Check if there are any posts --}}
    @if(count($posts) > 0)

        {{-- Loop through each post --}}
        @foreach($posts as $post)

            {{-- Card container for each post --}}
            <div class="card text-center">
                <div class="card-body">
                    <h4 class="card-title mb-3"><a href="/posts/{{$post->id}}">{{$post->title}}</a></h4>
                    <h6 class="card-text mb-3">Author: {{$post->user->name}}</h6>
                    <p class="card-subtitle mb-3 text-muted">Created at: {{$post->created_at}}</p>
                    {{-- Check if there is an authenticated user to prevent errors when no user is logged in --}}
                </div>

                {{-- Check if a user is authenticated --}}
                @if(Auth::user())
                    
                    {{-- Check if the authenticated user is the author of the post --}}
                    @if(Auth::user()->id == $post->user_id)
                    
                        {{-- Show an edit post button and a delete post button --}}
                        <div class="card-footer">
                            <form method="POST" action="/posts/{{$post->id}}">
                                @method('DELETE')
                                @csrf
                                <a href="/posts/{{$post->id}}/edit" class="btn btn-primary">Edit post</a>
                                <button type="submit" class="btn btn-danger">Delete Post</button>
                            </form>
                        </div>
                    @endif
                @endif
            </div>
        @endforeach
    @else
        <div>
            <h2>There are no posts to show</h2>
            <a href="/posts/create" class="btn btn-info">Create post</a>
        </div>
    @endif
@endsection