<?php
namespace LaraPress\Foundation;

use Illuminate\Events\EventServiceProvider;
use Illuminate\Foundation\Application as BaseApplication;
use LaraPress\Actions\ActionServiceProvider;
use LaraPress\Filters\FilterServiceProvider;
use LaraPress\Routing\RoutingServiceProvider;

class Application extends BaseApplication {

    /**
     * Register all of the base service providers.
     *
     * @return void
     */
    protected function registerBaseServiceProviders()
    {
        $this->register(new EventServiceProvider($this));
        $this->register(new ActionServiceProvider($this));
        $this->register(new FilterServiceProvider($this));

        $this->register(new RoutingServiceProvider($this));
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
            //'asset'        => 'LaraPress\Asset\AssetFactory',
            //'asset.finder' => 'LaraPress\Asset\AssetFinder',
            //'field'        => 'LaraPress\Field\FieldFactory',
            //'form'         => 'LaraPress\Html\FormBuilder',
            //'loop'         => 'LaraPress\View\Loop',
            //'metabox'      => 'LaraPress\MetaBox\MetaBoxBuilder',
            //'page'         => 'LaraPress\Page\PageBuilder',
            'actions'     => ['LaraPress\Actions\Dispatcher'],
            'filters'     => ['LaraPress\Filters\Dispatcher'],
            'posts'       => ['LaraPress\Posts\PostRepository', 'LaraPress\Contracts\Posts\PostRepository'],
            'posts.types' => ['LaraPress\Posts\PostTypeManager', 'LaraPress\Contracts\Posts\PostTypeManager'],
            //'sections'     => 'LaraPress\Page\Sections\SectionBuilder',
            'taxonomy'    => 'LaraPress\Posts\Manager',
        ];

        foreach ($aliases as $key => $aliases)
        {
            foreach ((array)$aliases as $alias)
            {
                $this->alias($key, $alias);
            }
        }
    }
}
