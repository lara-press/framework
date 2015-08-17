<?php namespace LaraPress\Routing;

use Illuminate\Routing\Controller as BaseController;
use LaraPress\Posts\Post;
use LaraPress\Posts\Query;

class Controller extends BaseController {
    /** @var Post */
    protected $post;

    /** @var Query */
    protected $query;

    /**
     * @param Post $post
     */
    public function setPost(Post $post)
    {
        $this->post = $post;
    }

    /**
     * @return Post
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * @param Query $query
     */
    public function setQuery(Query $query)
    {
        $this->query = $query;
    }

    /**
     * @return Query
     */
    public function getQuery()
    {
        return $this->query;
    }
}
