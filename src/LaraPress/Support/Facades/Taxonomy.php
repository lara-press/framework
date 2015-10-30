<?php

namespace LaraPress\Support\Facades;

use Illuminate\Support\Facades\Facade;

class Taxonomy extends Facade {

    protected static function getFacadeAccessor()
    {
        return 'taxonomy';
    }
}
