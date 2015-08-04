<?php namespace LaraPress\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Filter extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'filters';
    }
}
