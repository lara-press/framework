<?php
namespace LaraPress\Posts;

use Illuminate\Database\Eloquent\Collection;

class Loop extends Collection {

    public function __construct($items = [])
    {
        $posts = [];

        foreach ($items as $item)
        {
            $posts[] = Model::resolveWordpressPostToModel($item);
        }

        parent::__construct($posts);
    }

    public function thePost()
    {
        return $this->getIterator()->current();
    }

    /**
     * Get the title of the current post.
     *
     * @return string The title of the current post.
     */
    public function title()
    {
        return $this->thePost()->post_title;
    }

    /**
     * Get the content of the current post.
     *
     * @return string The content of the current post.
     */
    public function content()
    {
        $content = apply_filters('the_content', $this->thePost()->post_content);
        $content = str_replace(']]>', ']]&gt;', $content);

        return $content;
    }

    /**
     * Get the excerpt of the current post.
     *
     * @return string The excerpt of the current post.
     */
    public function excerpt()
    {
        return apply_filters('get_the_excerpt', $this->thePost()->post_excerpt);
    }

    /**
     * Get the post thumbnail of the current post.
     *
     * @param string|array The size of the current post thumbnail.
     * @param string|array The attributes of the current post thumbnail.
     *
     * @return string The thumbnail of the current post.
     */
    public function thumbnail($size = null, $attr = null)
    {
        return get_the_post_thumbnail($this->id(), $size, $attr);
    }

    /**
     * Get the id of the current post.
     *
     * @return int The ID of the current post.
     */
    public function id()
    {
        return $this->thePost()->ID;
    }

    /**
     * Get the permalink of the current post.
     *
     * @return string The permalink of the current post.
     */
    public function link()
    {
        return get_permalink($this->thePost());
    }

    /**
     * Get the categories of the current post.
     */
    public function category()
    {
        return get_the_category($this->thePost());
    }

    /**
     * Get the tags of the current post.
     *
     * @return array The tags of the current post.
     */
    public function tags()
    {
        return get_the_tags($this->thePost());
    }

    /**
     * Get the terms (custom taxonomies) of the current post.
     *
     * @param string $taxonomy The custom taxonomy slug.
     *
     * @see https://codex.wordpress.org/Function_Reference/get_the_terms
     * @return array|false|\WP_Error
     */
    public function terms($taxonomy)
    {
        return get_the_terms($this->thePost(), $taxonomy);
    }

    /**
     * Add the classes for a given post.
     *
     * @author Guriev Eugen
     *
     * @param string|array $class  One or more classes to add to the post class list.
     * @param int|\WP_Post $postId The post ID or the post object.
     *
     * @return string
     */
    public function postClass($class = '', $postId = null)
    {
        return 'class="' . join(' ', get_post_class($class, $this->thePost())) . '"';
    }
}
