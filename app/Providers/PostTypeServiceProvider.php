<?php

namespace App\Providers;

use App\Designer;
use App\Event;
use App\Page;
use App\Post;
use App\Product;
use LaraPress\Posts\PostTypeServiceProvider as ServiceProvider;

class PostTypeServiceProvider extends ServiceProvider
{
    protected $postTypes = [
        Page::class,
        Post::class,
        Designer::class,
        Product::class,
        Event::class,
    ];

    public function getPostTypes()
    {
        return $this->postTypes;
    }
}
