<?php namespace LaraPress\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Action extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'actions';
    }
}
