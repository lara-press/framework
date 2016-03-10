<?php

namespace LaraPress\Foundation\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use LaraPress\Routing\Router;

class BootstrapWordPress
{

    protected $extract = ['wp', 'wp_rewrite', 'wp_the_query', 'wp_query', 'wp_widget_factory', 'wp_roles'];

    /**
     * Bootstrap the given application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application $app
     *
     * @return void
     */
    public function bootstrap(Application $app)
    {
        $this->setDefaultPermalinkStructure($app);

        $app['actions']->listen('init', function () use ($app) {
            $this->extractWordPressClasses($app);
            $this->bootstrapRoutes($app['router']);
        });

        $app['actions']->listen('admin_init', function () use ($app) {
            do_action('template_redirect');
            $app['wp_admin_response'] = $app[Kernel::class]->handle($request = Request::capture());
        });
    }

    /**
     * @param Application $app
     */
    protected function extractWordPressClasses(Application $app)
    {
        foreach ($this->extract as $extractedClass) {
            $app->instance($extractedClass, $GLOBALS[$extractedClass]);
        }
    }

    /**
     * @param Application $app
     */
    protected function setDefaultPermalinkStructure(Application $app)
    {
        actions()->listen('wp_install', function () use ($app) {
            $app['wp_rewrite']->set_permalink_structure('/%postname%/');
            $app['wp_rewrite']->flush_rules(true);
        });
    }

    /**
     * @param $router
     */
    protected function bootstrapRoutes(Router $router)
    {
        $router->get('/wp-admin', function () {
            return redirect()->to('cms/wp-admin');
        });

        $router->get('robots.txt', function () {
            die;
        });

        $router->get('feed', function () {
            die;
        });
    }
}
