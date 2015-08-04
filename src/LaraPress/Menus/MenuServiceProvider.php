<?php namespace LaraPress\Menus;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider {

    /**
     * An array of "id => title" pairs to be registered as Wordpress menus.
     *
     * @var array
     */
    protected $menus;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->menus as &$menuTitle)
        {
            $menuTitle = __($menuTitle);
        }

        register_nav_menus($this->menus);
    }
}
