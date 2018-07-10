<?php

namespace LaraPress\Posts;

use Illuminate\Support\ServiceProvider;

class PostServiceProvider extends ServiceProvider {

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['actions']->listen('wp', function()
        {
            if (get_post() !== null && $post = Post::resolveWordPressPostToModel(get_post()))
            {
                $this->app->instance('post', $post);
            }
        });

        $this->registerLoopAndQuery();
        $this->registerPostManager();
        $this->registerPostTypeManager();
    }

    protected function registerLoopAndQuery()
    {
        $this->app['actions']->listen(
            'wp',
            function ()
            {
                $query = $GLOBALS['wp_query'];
                $query->set('fields', null);
                $this->app->instance('query', $query = Query::newInstanceFromWordPressQuery($GLOBALS['wp_query']));
                $this->app->instance('loop', new Loop($query->get_posts()));
            }
        );
    }

    protected function registerPostManager()
    {
        $this->app['posts'] = $this->app->share(
            function ($app)
            {
                return new Repository($app);
            }
        );
    }

    protected function registerPostTypeManager()
    {
        $this->app['posts.types'] = $this->app->share(
            function ($app)
            {
                return new PostTypeManager($app['actions']);
            }
        );
    }

    public function provides()
    {
        return ['posts', 'posts.types', 'query', 'loop'];
    }
}
