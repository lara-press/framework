<?php

namespace LaraPress\Posts;

use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['actions']->listen('wp', function () {
            $wpPost = get_post(
                (is_home() && is_archive()) && !is_post_type_archive() ?
                    get_option('page_for_posts') :
                    null
            ); // for post archive get post page instead of first post

            if ($wpPost !== null && $post = Post::resolveWordPressPostToModel($wpPost)) {
                $this->app->instance('post', $post);
            }
        });

        $this->registerLoopAndQuery();
        $this->registerPostManager();
        $this->registerPostTypeManager();
    }

    protected function registerLoopAndQuery()
    {
        $this->app['actions']->listen('wp', function () {
            $query = $GLOBALS['wp_query'];
            $query->set('fields', null);
            $this->app->instance('query', $query = Query::newInstanceFromWordPressQuery($query));
            $this->app->instance('loop', new Loop($query->get_posts()));
        });
    }

    protected function registerPostManager()
    {
        $this->app->singleton('posts', function ($app) {
            return new Repository($app);
        });
    }

    protected function registerPostTypeManager()
    {
        $this->app->singleton('posts.types', function ($app) {
            return new PostTypeManager($app['actions']);
        });
    }

    public function provides()
    {
        return ['posts', 'posts.types', 'query', 'loop'];
    }
}
