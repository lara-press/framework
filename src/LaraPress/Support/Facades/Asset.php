<?php namespace LaraPress\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Asset extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'assets';
    }
}
