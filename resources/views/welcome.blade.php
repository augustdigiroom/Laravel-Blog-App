@extends('layouts.app') {{-- Assuming app.blade.php is inside resources/views/layouts/ --}}

@section('title', 'Welcome') {{-- Optional: Set page title --}}

@section('styles')
    <style>
        .banner {
            text-align: center;
            margin-top: 20px;
        }

        .banner img {
            width: 300px;
        }

        .featured-posts {
            margin-top: 40px;
            text-align: center;
        }

        .post {
            margin-bottom: 20px;
        }
    </style>
@endsection



@section('content')
    <div class="banner">
        <a href="https://laravel.com" target="_blank">
            <img src="{{ asset('images/laravel-logo.png') }}" alt="Laravel Logo">
        </a>
    </div>

    <div class="featured-posts" style="margin-top: 40px; text-align: center;">
        <h2>Featured Posts</h2>
        @foreach ($posts as $post)
            <div class="post" style="margin-bottom: 20px;">
                <h3>
                    <a href="{{ url('/posts/' . $post->id) }}">{{ $post->title }}</a>
                </h3>
                <p>By {{ $post->author->name ?? 'Unknown Author' }}</p>
            </div>
        @endforeach
    </div>
@endsection
