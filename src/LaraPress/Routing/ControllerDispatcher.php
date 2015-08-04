<?php namespace LaraPress\Routing;

use App\Post;
use Illuminate\Routing\ControllerDispatcher as BaseControllerDispatcher;
use LaraPress\Admin\AdminPageController;
use LaraPress\Posts\Model;
use LaraPress\Posts\Query;

class ControllerDispatcher extends BaseControllerDispatcher {

    /**
     * Make a controller instance via the IoC container.
     *
     * @param  string $controller
     *
     * @return mixed
     */
    protected function makeController($controller)
    {
        Controller::setRouter($this->router);

        $controller = $this->container->make($controller);

        if ( ! $controller instanceof AdminPageController)
        {
            if ($this->container->isShared('post'))
            {
                $controller->setPost($this->container['post']);
            }

            $controller->setQuery($this->container['query']);
        }

        if (method_exists($controller, 'boot'))
        {
            $this->container->call([$controller, 'boot']);
        }

        return $controller;
    }
}
