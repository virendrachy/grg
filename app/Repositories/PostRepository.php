<?php

// app/Repositories/PostRepository.php
namespace App\Repositories;

use App\Repositories\Contracts\PostRepositoryInterface;
use App\Post;

class PostRepository implements PostRepositoryInterface
{

    protected $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function find($id)
    {
        return $this->post->find($id);
    }

    public function findBy($att, $column)
    {
        return $this->post->where($att, $column);
    }

    /**
     * Get All active records
     *
     * @return post
     */
    public function getActive()
    {
        return $this->post->where('active', 1)
                        ->whereDate('publish_date', '<=', date('Y-m-d'))
                        ->orderBy('created_at', 'desc');
    }
    
    /**
     * Get All active records
     *
     * @return post
     */
    public function getAll()
    {
        return $this->post->orderBy('created_at', 'desc');
    }

}
