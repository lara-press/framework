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
            $this->app['filters']->listen(
                'theme_' . strtolower(class_basename($postType)) . '_templates',
                function ($page_templates) use ($postType) {
                    $laraPressTemplates = [];

                    foreach ((new $postType)->templates as $template) {
                        $laraPressTemplates[$template] = ucwords(str_replace('-', ' ', $template));
                    }

                    return array_merge($page_templates, $laraPressTemplates);
                }
            );
        }
    }
}
