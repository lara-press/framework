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

                    foreach ((new $postType)->getAvailableTemplates() as $key => $template) {
                        if (is_int($key)) {
                            $key = $template;
                            $template = ucwords(str_replace('-', ' ', $template));
                        }
                        $laraPressTemplates[$key] = $template;
                    }

                    return array_merge($page_templates, $laraPressTemplates);
                }
            );
        }
    }
}
