<?php namespace LaraPress\Admin;

use Illuminate\Support\ServiceProvider;

class AdminPageServiceProvider extends ServiceProvider {

    /** @var array */
    protected $adminControllers = [];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['actions']->listen(
            'admin_menu',
            function ()
            {
                foreach ($this->adminControllers as $adminController)
                {
                    /** @var AdminPageController $adminController */
                    $adminController = $this->app->make($adminController);

                    $menuTitle = $adminController->getMenuTitle();
continue;
                    add_menu_page(
                        $adminController->getTitle(),
                        !empty($menuTitle) ?: $adminController->getTitle(),
                        'manage_options',
                        $adminController->getSlug(),
                        [$adminController, '_render'],
                        $adminController->getIcon(),
                        $adminController->getPosition()
                    );
                }
            }
        );
    }
}
