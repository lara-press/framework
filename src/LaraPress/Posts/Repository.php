<?php

namespace LaraPress\Posts;

use App\Post;
use LaraPress\Contracts\Posts\Repository as RepositoryContract;

class Repository implements RepositoryContract {

    /**
     * @param $id
     *
     * @return Post
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    /** @return string */
    public function getModelClassName()
    {
        // TODO: Implement getModelClassName() method.
    }
}
