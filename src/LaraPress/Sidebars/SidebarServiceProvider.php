<?php

namespace LaraPress\Sidebars;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class SidebarServiceProvider extends ServiceProvider {

    /**
     * An array of sidebars to be loaded as WordPress sidebars.
     *
     * @see \LaraPress\Sidebars\SidebarServiceProvider for proper structure
     *
     * @var array
     */
    protected $sidebars = [];

    public function register()
    {
        foreach ($this->sidebars as $sidebar)
        {
            $sidebar = $this->prepareSidebar($sidebar);

            register_sidebar($sidebar);
        }
    }

    protected function prepareSidebar($sidebar)
    {
        $sidebar = array_merge(
            [
                'name'          => '',
                'id'            => '',
                'description'   => '',
                'before_widget' => '<div>',
                'after_widget'  => '</div>',
                'before_title'  => '<h2>',
                'after_title'   => '</h2>'

            ],
            $sidebar
        );

        $sidebar['name'] = __($sidebar['name']);
        $sidebar['description'] = __($sidebar['description']);

        if (empty($sidebar['id']))
        {
            $sidebar['id'] = Str::snake(preg_replace('/[^a-zA-Z0-9]/', '-', $sidebar['name']));
        }

        return $sidebar;
    }
}
