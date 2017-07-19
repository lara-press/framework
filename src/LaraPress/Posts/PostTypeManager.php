<?php

namespace LaraPress\Posts;

use LaraPress\Actions\Dispatcher;
use LaraPress\Contracts\Posts\CustomPostType;
use LaraPress\Contracts\Posts\PostTypeManager as PostTypeManagerContract;

class PostTypeManager implements PostTypeManagerContract
{

    /** @var Post[] */
    protected $postTypes = [];

    /**
     * @var Dispatcher
     */
    protected $actions;

    public function __construct(Dispatcher $actions)
    {
        $this->actions = $actions;
    }

    public function register($model)
    {
        if (is_string($model)) {
            if ( ! class_exists($model)) {
                throw new \InvalidArgumentException('Attempted to register a post type whose model does not exist.');
            }

            $model = new $model;
        }

        $this->actions->listen('init', function () use ($model) {
            $this->makeCustomPostType($model);
        });
    }

    public function get($postType)
    {
        return isset($this->postTypes[$postType]) ? $this->postTypes[$postType] : null;
    }

    public function all()
    {
        return $this->postTypes;
    }

    protected function makeCustomPostType(Post $model)
    {
        $postTypeSlug = strtolower(snake_case(class_basename($model)));

        if ($model instanceof CustomPostType) {
            $singular = property_exists($model, 'singular') ? $model->singular : str_replace(['-', '_'], ' ', $postTypeSlug);

            $plural = property_exists($model, 'plural')
                ? $model->plural
                : str_plural(
                    str_replace(['-', '_'], ' ', $postTypeSlug)
                );

            $postTypeData = $model->customPostTypeData();

            if ( ! is_array($postTypeData)) {
                $postTypeData = [];
            }

            $result = register_post_type($postTypeSlug, $this->buildPostTypeData($singular, $plural, $postTypeData));

            if ( ! $result instanceof \WP_Error) {
                $this->postTypes[$postTypeSlug] = get_class($model);

                if (property_exists($model, 'placeholderText')) {
                    add_filter(
                        'enter_title_here',
                        function ($default) use ($postTypeSlug, $model) {
                            if ($postTypeSlug == get_current_screen()->post_type) {
                                $default = $model->placeholderText;
                            }

                            return $default;
                        }
                    );
                }
            }
        } else {
            $this->postTypes[$postTypeSlug] = get_class($model);
        }
    }

    /**
     * @param $singular
     * @param $plural
     * @param $args
     *
     * @return array
     */
    protected function buildPostTypeData($singular, $plural, $args)
    {
        $singular = ucwords($singular);
        $plural = ucwords($plural);

        $labels = [
            'name'               => __($plural, LARAPRESS_TEXTDOMAIN),
            'singular_name'      => __($singular, LARAPRESS_TEXTDOMAIN),
            'add_new'            => __('Add New', LARAPRESS_TEXTDOMAIN),
            'add_new_item'       => __('Add New ' . $singular, LARAPRESS_TEXTDOMAIN),
            'edit_item'          => __('Edit ' . $singular, LARAPRESS_TEXTDOMAIN),
            'new_item'           => __('New ' . $singular, LARAPRESS_TEXTDOMAIN),
            'all_items'          => __('All ' . $plural, LARAPRESS_TEXTDOMAIN),
            'view_item'          => __('View ' . $singular, LARAPRESS_TEXTDOMAIN),
            'search_items'       => __('Search ' . $singular, LARAPRESS_TEXTDOMAIN),
            'not_found'          => __('No ' . strtolower($singular) . ' found', LARAPRESS_TEXTDOMAIN),
            'not_found_in_trash' => __('No ' . strtolower($singular) . ' found in trash', LARAPRESS_TEXTDOMAIN),
            'parent_item_colon'  => '',
            'menu_name'          => __($plural, LARAPRESS_TEXTDOMAIN),
        ];

        return array_merge(
            [
                'label'         => __($plural, LARAPRESS_TEXTDOMAIN),
                'labels'        => $labels,
                'description'   => '',
                'public'        => true,
                'menu_position' => 20,
                'has_archive'   => true,
            ],
            $args
        );
    }
}
