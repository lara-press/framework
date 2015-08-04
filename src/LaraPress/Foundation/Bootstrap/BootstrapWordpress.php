<?php namespace LaraPress\Foundation\Bootstrap;

use Illuminate\Contracts\Foundation\Application;
use LaraPress\Routing\Router;

class BootstrapWordpress
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
        $app['actions']->listen(
            'init',
            function () use ($app) {

                $this->extractWordpressClasses($app);

                $this->setDefaultPermalinkStructure($app);

                $this->bootstrapRoutes($app['router']);
            }
        );
    }

    /**
     * @param Application $app
     */
    protected function extractWordpressClasses(Application $app)
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
        actions()->listen(
            'wp_install',
            function () use ($app) {
                $app['wp_rewrite']->set_permalink_structure('/%postname%/');
                $app['wp_rewrite']->flush_rules(true);
            }
        );
    }

    /**
     * @param $router
     */
    protected function bootstrapRoutes(Router $router)
    {
        $router->get(
            '/wp-admin',
            function () {
                return redirect()->to('cms/wp-admin');
            }
        );

        $router->get(
            'robots.txt',
            function () {
                die;
            }
        );

        $router->get(
            'feed',
            function () {
                die;
            }
        );
    }
}
