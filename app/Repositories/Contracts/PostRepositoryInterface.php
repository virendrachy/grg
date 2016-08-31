<?php

namespace App\Repositories\Contracts;

interface PostRepositoryInterface
{
    public function find($id);

    public function findBy($att, $column);
    
    public function getActive();
}
