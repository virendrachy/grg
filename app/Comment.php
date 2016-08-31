<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = array('body', 'user_id', 'post_id');
    
    // user details
    public function author()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    // returns post of any comment
    public function post()
    {
        return $this->belongsTo('App\Post', 'post_id');
    }
}
