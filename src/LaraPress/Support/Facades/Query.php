<?php namespace LaraPress\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Query extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'query';
    }
}
