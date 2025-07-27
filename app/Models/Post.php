<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    // Each post belongs to one user (inverse of the one-to-many relationship)
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    // app/Models/Post.php
    public function author()
    {
    return $this->belongsTo(User::class, 'user_id');
    }
    
    // A 'Post' can have many 'PostLikes'
    public function likes() {
        return $this->hasMany('App\Models\PostLike');
    }

    public function postComments() {
    return $this->hasMany(PostComment::class);
}
    
}