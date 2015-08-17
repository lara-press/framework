<?php namespace LaraPress\Posts;

use LaraPress\Actions\Dispatcher;

class TaxonomyManager {

    /**
     * @var Dispatcher
     */
    private $actions;

    public function __construct(Dispatcher $actions)
    {
        $this->actions = $actions;
    }

    public function register($slug, $postTypes = [], $singular = '', $plural = '', $params = [])
    {
        if (empty($singular))
        {
            $singular = ucwords(str_replace('_', ' ', $slug));
        }

        if (empty($plural))
        {
            $plural = str_plural($singular);
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
            'menu_name'         => __($plural, LARAPRESS_TEXTDOMAIN)
        ];

        return array_merge(
            [
                'label'     => __($plural, LARAPRESS_TEXTDOMAIN),
                'labels'    => $labels,
                'public'    => true,
                'query_var' => true
            ],
            $params
        );
    }
}
