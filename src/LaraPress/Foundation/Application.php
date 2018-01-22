<?php

namespace LaraPress\Foundation;

use Illuminate\Foundation\Application as BaseApplication;

class Application extends BaseApplication
{

    /**
     * Register all of the base service providers.
     *
     * @return void
     */
    protected function registerBaseServiceProviders()
    {
        $this->register(new \Illuminate\Events\EventServiceProvider($this));
        $this->register(new \Illuminate\Log\LogServiceProvider($this));
        $this->register(new \LaraPress\Actions\ActionServiceProvider($this));
        $this->register(new \LaraPress\Filters\FilterServiceProvider($this));
        $this->register(new \LaraPress\Routing\RoutingServiceProvider($this));
        $this->register(new \LaraPress\Foundation\Providers\PublishServiceProvider($this));
    }

    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    public function registerCoreContainerAliases()
    {
        parent::registerCoreContainerAliases();

        $aliases = [
            'actions'     => [\LaraPress\Actions\Dispatcher::class],
            'filters'     => [\LaraPress\Filters\Dispatcher::class],
            'posts.types' => [
                \LaraPress\Posts\PostTypeManager::class,
                \LaraPress\Contracts\Posts\PostTypeManager::class,
            ],
        ];

        foreach ($aliases as $key => $aliases) {
            foreach ((array)$aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }
}
