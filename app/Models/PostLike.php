<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PostLike extends Model
{
    // A 'PostLike' belongs to a 'User'
    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    // A 'PostLike' belongs to a 'Post'
    public function post() {
        return $this->belongsTo('App\Models\Post');
    }
}
