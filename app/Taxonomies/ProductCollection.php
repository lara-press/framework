<?php

namespace App\Taxonomies;

use LaraPress\Contracts\Taxonomies\CustomTaxonomy;

class ProductCollection implements CustomTaxonomy
{
    public function supportsPostTypes()
    {
        return ['product'];
    }

    public function taxonomyData()
    {
        return [
            'hierarchical'      => true,
            'public'            => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => false,
            'rewrite'           => ['slug' => 'products'],
        ];
    }

}
