<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{    
    protected $fillable = ['user_id','title', 'body','slug','active','publish_date'];
    
    // many comments on post
    public function comment()
    {
        return $this->hasMany('App\Comment', 'post_id');
    }

    // returns user details
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
    
    // Delete relative comments
    protected static function boot() {
        parent::boot();

        static::deleting(function($post) { 
             $post->comment()->delete();
        });
    }
}
