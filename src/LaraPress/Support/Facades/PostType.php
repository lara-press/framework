<?php namespace LaraPress\Support\Facades;

use Illuminate\Support\Facades\Facade;

class PostType extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'posts.types';
    }
}
