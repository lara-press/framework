<?php

namespace App\Providers;

use LaraPress\Sidebars\SidebarServiceProvider as BaseSidebarServiceProvider;

class SidebarServiceProvider extends BaseSidebarServiceProvider
{
    /**
     * An array of sidebars to be loaded as Wordpress sidebars.
     *
     * @see LaraPress\Sidebars\SidebarServiceProvider for proper structure
     * @var array
     */
    protected $sidebars = [
        [
            'name'        => 'Example sidebar',
            'description' => 'Just an example sidebar',
        ]
    ];
}
