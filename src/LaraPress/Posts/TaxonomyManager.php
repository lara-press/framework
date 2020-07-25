<?php

namespace LaraPress\Posts;

use Illuminate\Support\Str;
use LaraPress\Actions\Dispatcher;
use LaraPress\Contracts\Taxonomies\CustomTaxonomy;

class TaxonomyManager
{

    /**
     * @var Dispatcher
     */
    private $actions;

    protected $taxonomies = [];

    public function __construct(Dispatcher $actions)
    {
        $this->actions = $actions;
    }

    public function get($taxonomy)
    {
        return isset($this->taxonomies[$taxonomy]) ? $this->taxonomies[$taxonomy] : null;
    }

    public function all()
    {
        return $this->taxonomies;
    }

    public function register($model)
    {
        if (is_string($model)) {
            if ( ! class_exists($model)) {
                throw new \InvalidArgumentException('Attempted to register a taxonomy that does not exist.');
            }

            $model = new $model;
        }

        $this->actions->listen('init', function () use ($model) {
            $this->makeCustomTaxonomy($model);
        });
    }

    protected function makeCustomTaxonomy(CustomTaxonomy $model)
    {
        $taxonomySlug = strtolower(Str::snake(class_basename($model)));

        $singular =
            property_exists($model, 'singular') ? $model->singular : str_replace(['-', '_'], ' ', $taxonomySlug);

        $plural = property_exists($model, 'plural')
            ? $model->plural
            : Str::plural(
                str_replace(['-', '_'], ' ', $taxonomySlug)
            );

        $taxonomyData = $model->taxonomyData();

        if ( ! is_array($taxonomyData)) {
            $taxonomyData = [];
        }

        $result = $this->registerTaxonomy(
            $taxonomySlug,
            $model->supportsPostTypes(),
            $singular,
            $plural,
            $taxonomyData
        );

        if ( ! $result instanceof \WP_Error) {
            $this->taxonomies[$taxonomySlug] = get_class($model);
        }
    }


    protected function registerTaxonomy($slug, $postTypes = [], $singular = '', $plural = '', $params = [])
    {
        if (empty($singular)) {
            $singular = ucwords(str_replace('_', ' ', $slug));
        }

        if (empty($plural)) {
            $plural = Str::plural($singular);
        }

        register_taxonomy($slug, $postTypes, $this->getDefaultParams($singular, $plural, $params));
    }

    /**
     * @param string $singular
     * @param string $plural
     * @param        $params
     *
     * @return array
     */
    private function getDefaultParams($singular, $plural, $params)
    {
        $labels = [
            'name'              => _x($plural, LARAPRESS_TEXTDOMAIN),
            'singular_name'     => _x($singular, LARAPRESS_TEXTDOMAIN),
            'search_items'      => __('Search ' . $plural, LARAPRESS_TEXTDOMAIN),
            'all_items'         => __('All ' . $plural, LARAPRESS_TEXTDOMAIN),
            'parent_item'       => __('Parent ' . $singular, LARAPRESS_TEXTDOMAIN),
            'parent_item_colon' => __('Parent ' . $singular . ': ', LARAPRESS_TEXTDOMAIN),
            'edit_item'         => __('Edit ' . $singular, LARAPRESS_TEXTDOMAIN),
            'update_item'       => __('Update ' . $singular, LARAPRESS_TEXTDOMAIN),
            'add_new_item'      => __('Add New ' . $singular, LARAPRESS_TEXTDOMAIN),
            'new_item_name'     => __('New ' . $singular . ' Name', LARAPRESS_TEXTDOMAIN),
            'menu_name'         => __($plural, LARAPRESS_TEXTDOMAIN),
        ];

        return array_merge([
            'label'             => __($plural, LARAPRESS_TEXTDOMAIN),
            'labels'            => $labels,
            'public'            => true,
            'query_var'         => true,
            'hierarchical'      => true,
            'show_ui'           => true,
            'show_admin_column' => true,
            'show_in_nav_menus' => true,
            'show_tagcloud'     => true,
            'rewrite'           => true,
        ], $params);
    }
}
