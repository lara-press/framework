<?php namespace LaraPress\Routing;

use Illuminate\Routing\Controller as BaseController;
use LaraPress\Posts\Model;
use LaraPress\Posts\Query;

class Controller extends BaseController {
    /** @var Model */
    protected $post;

    /** @var Query */
    protected $query;

    /**
     * @param Model $post
     */
    public function setPost(Model $post)
    {
        $this->post = $post;
    }

    /**
     * @return Model
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
