<?php
namespace LaraPress\Posts;

use Illuminate\Support\ServiceProvider;

class PostTypeServiceProvider extends ServiceProvider
{

    protected $postTypes = [];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->postTypes as $postType) {
            $this->app['posts.types']->register($postType);
        }
    }
}
