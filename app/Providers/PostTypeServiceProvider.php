<?php

namespace App\Providers;

use LaraPress\Posts\PostTypeServiceProvider as ServiceProvider;

class PostTypeServiceProvider extends ServiceProvider
{
    protected $postTypes = [
        \App\Page::class,
        \App\Post::class
    ];

    public function getPostTypes() {
        return $this->postTypes;
    }
}