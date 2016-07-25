<?php

namespace App\Providers;

use App\Taxonomies\ProductCollection;
use LaraPress\Posts\TaxonomyServiceProvider as ServiceProvider;

class TaxonomyServiceProvider extends ServiceProvider
{
    protected $taxonomies = [
        ProductCollection::class,
    ];

    public function getTaxonomies()
    {
        return $this->taxonomies;
    }
}
