<?php

namespace LaraPress\Assets;

use Illuminate\Support\ServiceProvider;

class AssetServiceProvider extends ServiceProvider {

    /**
     * Area of assets to include, format :
     *
     * [
     *     handle       => string | unique slug for assets
     *     path         => string | path to asset, can be local bath or remote URL
     *     dependencies => array | list of asset dependencies
     *     version      => int | version # of asset (default: 0)
     *     footer       => bool | whether to enqueue the asset to the footer (default: false)
     *     area         => string | [front|login|admin] where the asset should be rendered (default: front)
     *     type         => string | [script|style] type of the asset (optional)
     * ]
     *
     * @var array
     */
    protected $assets = [];

    public function register()
    {
        $this->app->instance('assets', $assets = new Manager($this->app['actions'], $this->app['files']));

        foreach ($this->assets as $asset)
        {
            $args = array_merge(
                [
                    'handle' => '',
                    'path' => '',
                    'dependencies' => [],
                    'version' => 0,
                    'footer' => false,
                    'area' => Manager::FRONT,
                    'type' => ''
                ],
                $asset
            );

            $assets->enqueue(
                $args['handle'],
                $args['path'],
                $args['dependencies'],
                $args['version'],
                $args['footer'],
                $args['area'],
                $args['type']
            );
        }
    }
}
