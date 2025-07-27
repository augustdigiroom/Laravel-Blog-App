{{-- Extend the base layout called 'app' --}}
@extends('layouts.app')

{{-- Start defining the content section --}}
@section('content')
	
	<form method="POST" action="/posts">
		{{-- CSRF token for security (prevents cross-site request forgery) --}}
		@csrf

		<div class="form-group">
            <label for="title">Title:</label>
            <input type="text" class="form-control" id="title" name="title">
        </div>
		<div class="form-group">
            <label for="content">Content:</label>
            <textarea class="form-control" id="content" name="content" rows="3"></textarea>
        </div>
		<div class="mt-2">
            <button type="submit" class="btn btn-primary">Create Post</button>
        </div>

	</form>

@endsection