{{-- Extend the main layout from layouts/app.blade.php --}}
@extends('layouts.app')

{{-- Define the content section that will be inserted into the layout --}}
@section('content')
    <div class="card">
      <div class="card-body">
        {{-- Display the post title --}}
        <h2 class="card-title">{{ $post->title }}</h2>

        {{-- Display the name of the post's author (via relationship) --}}
        <p class="card-subtitle text-muted">Author: {{ $post->user->name }}</p>

        {{-- Display the date/time the post was created --}}
        <p class="card-subtitle text-muted mb-3">Created at: {{ $post->created_at }}</p>

        {{-- Display the post content --}}
        <p class="card-text">{{ $post->content }}</p>

          @if(Auth::user())
              @if(Auth::id() != $post->user_id)
                <form class="d-inline" method="POST" action="/posts/{{$post->id}}/like">
                    @method('PUT')
                    @csrf
                    @if($post->likes->contains("user_id", Auth::id()))
                        <button type="submit" class="btn btn-danger">Unlike</button>
                    @else
                        <button type="submit" class="btn btn-success">Like</button>
                    @endif
                </form>
              @endif
          @endif

          @auth
              <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#commentModal">
                  Add Comment
              </button>
          @endauth

                  <!-- Comment Modal -->
        <div class="modal fade" id="commentModal" tabindex="-1" aria-labelledby="commentModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">

              <div class="modal-header">
                <h5 class="modal-title" id="commentModalLabel">Leave a Comment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <form method="POST" action="{{ route('postComments.store', $post) }}">
                @csrf
                <div class="modal-body">
                    <textarea class="form-control" name="content" rows="4" required></textarea>
                </div>

                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Post Comment</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
              </form>

            </div>
          </div>
        </div>

            <h4 class="mt-4">🗨️ Recent Comments</h4>

        @forelse ($post->postComments as $comment)
            <div class="d-flex justify-content-end mb-3">
                <div class="card shadow-sm border-0" style="width: 100%;">
                    <div class="card-body">
                        <h6 class="card-subtitle mb-1 text-muted text-end">
                            <p class="text-center" style="font-size: 1.2rem;">
                                 {{ $comment->content }}
                            </p>
                            Posted by: {{ $comment->user->name }} <br>
                            <small>{{ $comment->created_at->format('M d, Y \a\t h:i A') }}</small>
                        </h6>
                       
                    </div>
                </div>
            </div>
        @empty
            <p class="text-muted text-end">No comments yet. Be the first to say something!</p>
        @endforelse

        <div class="mt-3">
            {{-- Link to go back to the list of all posts --}}
            <a href="/posts" class="card-link">View all posts</a>
        </div>
      </div>
    </div>
@endsection